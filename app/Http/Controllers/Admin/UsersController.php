<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Blog;
use App\Models\Page;
use Spatie\Permission\Models\Role;
use App\Models\Role as UserRole;
use App\Models\Notification;
use Modules\CustomField\Entities\CustomField;
use Auth;
use Jenssegers\Agent\Agent;
use Storage;


class UsersController extends Controller
{

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = __('common.all_users');
        $resultQuery = User::query();

        if($request->filled('name')) {
            $resultQuery->where('name', 'like', "%{$request->input('name')}%");
        }

        if($request->filled('email')) {
            $resultQuery->where('email', 'like', "%{$request->input('email')}%");
        }

        if($request->filled('role'))
        {
            $resultQuery->whereHas('roles', function($query) use($request) {
                $query->where('id', '=', $request->input('role'));
            });
        }

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);

        $users = $resultQuery->with('roles')->paginate(config('Reading.nodes_per_page'));

        $usersArr = User::pluck('name', 'id');
        $roleArr = UserRole::pluck('name', 'id')->prepend(__('common.select_role'),'');
        return view('admin.users.index', compact('users', 'roleArr','page_title','usersArr'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = __('common.add_new_user');
        $roles = Role::get();
        return view('admin.users.create', compact('roles','page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'first_name'        => 'required',
                'last_name'         => 'nullable',
                'email'             => 'required|email|unique:users',
                'password'          => 'required|confirmed',
                'password_confirmation'  => 'required',
                'roles'  => 'required',
                'user_img'      => 'mimes:jpg,png,jpeg,gif',
            ],
        );

        $fileName = $this->__imageSave($request, 'user_img', 'user-images');
        $full_name = $request->input('first_name').' '.$request->input('last_name');
        
        $new_user = [
            'name'          => $full_name,
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'email'         => $request->input('email'),
            'profile'       => $fileName,
            'password'      => Hash::make($request->input('password')),
        ];

        $user = User::create($new_user);
        
        if($user)
        {
            $user->roles()->sync($request->input('roles'));
            
            $CustomFieldObj = new CustomField();
            $CustomFieldObj->update_custom_field($request, $user->id);
            
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('ADMIN-ANU', $user->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('admin.users.index')->with('success', __('common.user_add_success'));  
        } else
        {
            return redirect()->back()->with('error', __('common.problem_in_form_submition'));
        }

    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = __('common.edit_user');
        $user = User::findorFail($id);
        $roles = Role::get();
        $userRoles = User::get_roles($id);
        return view('admin.users.edit', compact('user', 'roles', 'userRoles','page_title'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
                'first_name'    => 'required',
                'last_name'     => 'nullable',
                'email'         => 'required|email|unique:users,email,'.$id,
                'user_img'      => 'mimes:jpg,png,jpeg,gif',
            ],
        );

        $user = User::findorFail($id);

        $fileName = $this->__imageSave($request, 'user_img', 'user-images', $user->profile);
        $full_name = $request->input('first_name').' '.$request->input('last_name');

        $user->name       = $full_name;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        if(!empty($fileName)) 
        {
            $user->profile = $fileName;
        }

        if($user->save()) 
        {

            $CustomFieldObj = new CustomField();
            $CustomFieldObj->update_custom_field($request, $user->id);

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('ADMIN-UP', $user->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('admin.users.index')->with('success', __('common.user_update_success'));
        } else {
            return redirect()->back()->with('error', __('common.problem_in_form_submition'));
        }

    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $user = User::findorFail($id);
        
        if($request->isMethod('post')) {
            if (isset($request->delete_option) && $request->delete_option == 'delete') {
                Blog::with('blog_categories', 'blog_tags', 'blog_seos', 'blog_metas')->where('user_id', '=', $id)->delete();
                Page::with('page_metas', 'page_seos')->where('user_id', '=', $id)->delete();
            }
            elseif (isset($request->delete_option) && $request->delete_option == 'reassign' && $request->filled('reassign_user')) {
                Blog::with('blog_categories', 'blog_tags', 'blog_seos', 'blog_metas')->where('user_id', '=', $id)->update(['user_id' => $request->reassign_user]);
                Page::with('page_metas', 'page_seos')->where('user_id', '=', $id)->update(['user_id' => $request->reassign_user]);
            }
        }
        
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('ADMIN-DU', $id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */

        if($user->delete()) 
        {

            return redirect()->back()->with('success', __('common.user_delete_success'));
        } else {
            return redirect()->back()->with('error', __('common.problem_in_form_submition'));
        }

    }

    /**
     * Update Password the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, $user_id='')
    {
        $this->validate($request, [
                'password'          => ['required', 
                                    Password::min(8),
                                    'same:confirm_password'],
                'confirm_password'  => 'required',
            ],
        );

        $user = User::findorFail($user_id);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        if($user->save()) 
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('ADMIN-UUPASS', $user_id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('admin.users.index')->with('success', __('common.password_update_success'));
        } else {
            return redirect()->back()->with('error', __('common.problem_in_form_submition'));
        }

    }

    /**
     * Update roles the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user_roles(Request $request, $user_id='')
    {
        $user = User::findorFail($user_id);
        $user->roles()->sync($request->input('roles'));

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('ADMIN-AUR', $user_id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */

        return redirect()->route('admin.users.index')->with('success', __('common.roles_update_success'));
    }

    private function __imageSave($request, $key='', $folder_name='', $old_img='')
    {
        $fileName = "";
        if($request->hasFile($key) && !empty($key) && !empty($folder_name)) { 
            $image = $request->file($key);
            $OriginalName = $image->getClientOriginalName();
            $fileName = time().'.'.$OriginalName;
            $request->file($key)->storeAs('public/'.$folder_name.'/', $fileName);
            if(!empty($old_img)) {
                if (Storage::exists('public/'.$folder_name.'/', $old_img)) {
                    Storage::delete('public/'.$folder_name.'/'.$old_img);
                }
            }
        }

        return $fileName;
    }

    public function profile()
    {
        $page_title = __('common.profile');
        $user_id    = Auth::id();
        $sessionArr = DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                        ->where('user_id', $user_id)
                        ->orderBy('last_activity', 'desc')
                        ->get();

        $sessions = collect( $sessionArr )->map(function ($session) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });

        $user = User::findorFail(Auth::id());
        $roles = Role::get();
        $userRoles = User::get_roles(Auth::id());
        return view('admin.profile.profile', compact('user', 'roles', 'userRoles', 'sessions', 'page_title'));
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function remove_user_image($id)
    {
        $user = User::where('id', '=', $id)->first();
        if(!empty($user->profile) && Storage::exists('public/user-images/'.$user->profile))
        {
            Storage::delete('public/user-images/'.$user->profile);
            $user->profile = Null;
            return $user->save();
        }

    }
}
