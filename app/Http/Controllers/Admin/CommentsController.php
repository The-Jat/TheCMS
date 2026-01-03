<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Notification;
use DzHelper;
use Str;
use Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index(Request $request)
    {
        $page_title = __('common.comments');
        $resultQuery = Comment::query();

        if($request->isMethod('get'))
        {
            if($request->filled('commenter')) {
                $resultQuery->where('commenter', 'like', "%{$request->input('commenter')}%");
            }
            if($request->filled('email')) {
                $resultQuery->where('email', 'like', "%{$request->input('email')}%");
            }
            if($request->filled('approve')) {
                $resultQuery->where('approve', $request->input('approve'));
            }
        }
        $comments = $resultQuery->orderBy('created_at', 'desc')->paginate(config('Reading.nodes_per_page'));

        return view('admin.comments.index', compact('page_title', 'comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function admin_store(Request $request)
    {

        $validationRule = [
                    'comment'            => 'required',
                ];

        if(!Auth::check() && config('Discussion.name_email_require'))
        {
            $validationRule['commenter']    = 'required';
            $validationRule['email']        = 'required|email';
        }

        $this->validate($request, $validationRule,
                [],
                [
                   'commenter' => 'Name',
                ],
            );

        $modKeys = trim(config('Discussion.moderation_keys'));
        $disallowedKeys = trim(config('Discussion.disallowed_comment_keys'));
        $status = "1";

        if (!empty($modKeys)) {
            $modKeys = explode(",", $modKeys );
            foreach ($modKeys as $key) {

                if ( empty( trim($key) ) ) {
                    continue;
                }

                foreach($request->all() as $inputValue)
                {
                    if(Str::is($key.'*', $inputValue))
                    {
                        $status = "0";
                        break;
                    }
                }
            }
        }

        if (!empty($disallowedKeys)) {
            $disallowedKeys = explode(",", $disallowedKeys );
            foreach ($disallowedKeys as $key) {

                if ( empty( trim($key) ) ) {
                    continue;
                }

                foreach($request->all() as $inputValue)
                {
                    if(Str::is($key.'*', $inputValue))
                    {
                        $status = "3";
                        break;
                    }
                }
            }
        }

        $parentComment = Comment::where('parent_id', $request->input('parent_id'))->first();

        setcookie('comment_author_'.config('constants.comment_cookie_hash'), '', time() + (86400), '/');
        setcookie('comment_email_'.config('constants.comment_cookie_hash'), '', time() + (86400), '/');
        setcookie('comment_website_'.config('constants.comment_cookie_hash'), '', time() + (86400), '/');

        if(config('Discussion.save_comments_cookie') && $request->input('set_comment_cookie'))
        {
            setcookie('comment_author_'.config('constants.comment_cookie_hash'), $request->input('commenter'), time() + (86400), '/');
            setcookie('comment_email_'.config('constants.comment_cookie_hash'), $request->input('email'), time() + (86400), '/');
            setcookie('comment_website_'.config('constants.comment_cookie_hash'), $request->input('profile_url'), time() + (86400), '/');
        }

        if(!empty($parentComment) && $parentComment->approve != '1' && config('Discussion.comment_previously_approved'))
        {
            return redirect()->back()->with('unapprove_comment_error', __('Sorry, You can replay after approved previously comment.'));
        }

        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());
        }

        $comment = Comment::create([
            'parent_id'         => $request->input('parent_id'),
            'object_id'         => $request->input('object_id'),
            'object_type'       => $request->input('object_type'),
            'user_id'           => isset($user->id) ? $user->id : null,
            'commenter'         => isset($user->name) ? $user->name : $request->input('commenter'),
            'profile_url'       => isset($user->id) ? DzHelper::author($user->id) : $request->input('profile_url'),
            'ip'                => \Request::ip(),
            'email'             => isset($user->email) ? $user->email : $request->input('email'),
            'comment'           => $request->input('comment'),
            'approve'           => config('Discussion.comment_moderation') ? '0' : $status,
            'browser_agent'     => $request->userAgent(),
        ]);

        if($comment)
        {
            if(config('Discussion.comments_notify'))
            {
                /* Send Event Notification */
                $notificationObj        = new Notification();
                $notificationObj->notification_entry('BLOG-NBC', $comment->id, Auth::id(), config('constants.superadmin'));
                /* End Send Event Notification */
            }

            return redirect()->back()->with('comment_success', __('common.comment_added_success'));
        }else{
            return redirect()->back()->with('comment_error', __('common.problem_in_form_submition'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_edit($id)
    {
        $page_title = __('common.edit_comment');
        $comment = Comment::findorFail($id);
        return view('admin.comments.edit', compact('comment','page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_update(Request $request, $id)
    {

        $this->validate($request, [
                'commenter'        => 'required|regex:/^[\pL\s\-]+$/u',
                'email'            => 'required|email',
                'comment'          => 'required',
            ],
            [],
            [
               'commenter' => 'Name',
            ],
        );

        $comment = Comment::findorFail($id);
        $comment->commenter     = $request->input('commenter');
        $comment->email         = $request->input('email');
        $comment->approve       = $request->input('approve');
        $comment->comment       = $request->input('comment');
        $comment->profile_url   = $request->input('profile_url');

        if($comment->save())
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-UBC', $comment->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('comments.admin.index')->with('success', __('common.comment_updated_success'));
        }
        else{
            return redirect()->back()->with('error', __('common.problem_in_form_submition'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_destroy($id)
    {

        $comment           = Comment::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('BLOG-BCD', $id, Auth::id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        if($comment->delete())
        {

            return redirect()->back()->with('success', __('common.comment_deleted_success'));
        }
        return redirect()->back()->with('error', __('common.problem_in_form_submition'));
    }

    public function admin_trash($id)
    {

        $comment           = Comment::findOrFail($id);
        $comment->approve  = 4;
        $res               = $comment->save();

        if($res)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-TBC', $id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('comments.admin.index')->with('success', __('common.comment_trashed_success'));
        }
        return redirect()->back()->with('error', __('common.problem_in_form_submition'));
    }
}
