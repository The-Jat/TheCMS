<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TempPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the permission.
     */
    public function index()
    {
        $page_title = __('common.all_permissions'); 
        $roles = Role::all();
        $modulesPermissions = TempPermission::where('parent_id', '=', 0)->whereIn('type', ['App', 'Module'])->get();

        $modulePermissions = $tempPermissions = array();
        foreach ($modulesPermissions as $modulesPermissionkey => $modulesPermission) {
            $controllerPermissions = $this->get_child_id($modulesPermission->id, 'Controller');
            foreach($controllerPermissions as $controllerPermission)
            {
                $actionPermissions = TempPermission::where('parent_id', '=', $controllerPermission->id)->whereIn('type', ['Action'])->get();
                $tempPermissions[$controllerPermission->name][] = $actionPermissions;
            }
            $modulePermissionsName = preg_replace('#[0-9 ]*#', '', $modulesPermission->name);
            $modulePermissions[$modulePermissionsName] = $tempPermissions;
            $tempPermissions = array();
        }
        return view('admin.permissions.index', compact('modulePermissions', 'roles','page_title'));
    }

    /*
     * Single role permission listing here
     */
    public function role_permissions($role_id='')
    {
        $page_title = __('common.role_permissions');
        $role = Role::findorFail($role_id);
        $permissions = Permission::pluck('id', 'action')->toArray();
        $allPermissionCount = Permission::all()->count();
        $rolePermissionCount = DB::table('role_has_permissions')->where('role_id', '=', $role_id)->get()->count();
        return view('admin.permissions.role_permissions', compact('role', 'permissions', 'allPermissionCount', 'rolePermissionCount','page_title'));
    }

    /*
     * All role permissions listing here
     */
    public function roles_permissions()
    {
        $page_title = __('common.roles_permissions');
        $roles = Role::all();
        $permissions = Permission::pluck('id', 'action')->toArray();
        $allPermissionCount = Permission::all()->count();

        $modulesPermissions = TempPermission::where('parent_id', '=', 0)->whereIn('type', ['App', 'Module'])->get();

        $modulePermissions = $tempPermissions = array();
        foreach ($modulesPermissions as $modulesPermissionkey => $modulesPermission) {
            $controllerPermissions = $this->get_child_id($modulesPermission->id, 'Controller');
            foreach($controllerPermissions as $controllerPermission)
            {
                $actionPermissions = TempPermission::where('parent_id', '=', $controllerPermission->id)->whereIn('type', ['Action'])->get();
                $tempPermissions[$controllerPermission->name][] = $actionPermissions;
            }
            $modulePermissionsName = preg_replace('#[0-9 ]*#', '', $modulesPermission->name);
            $modulePermissions[$modulePermissionsName] = $tempPermissions;
            $tempPermissions = array();
        }

        return view('admin.permissions.roles_permissions', compact('roles', 'permissions', 'allPermissionCount', 'modulePermissions','page_title'));
    }

    /*
     * User listing with permission button link here
     */
    public function user_permissions($id='')
    {
        $page_title = __('common.users_permissions');
        $users = User::paginate(config('Reading.nodes_per_page'));
        return view('admin.permissions.user_permissions', ['users' => $users],compact('page_title'));
    }

    /*
     * Single user permissions listing here
     */
    public function manage_user_permissions($user_id='')
    {
        $user = User::findorFail($user_id);
        $roles = DB::table('model_has_roles')->select('role_id')->where('model_id', $user_id)->get()->toArray();
        $rolesIds = array_column($roles, 'role_id');
        $rolesArr = DB::table('roles')->whereIn('id', $rolesIds)->get();
        $permissions = Permission::pluck('id', 'action')->toArray();
        $userPermissions = $user->getDirectPermissions();

        $modulesPermissions = TempPermission::where('parent_id', '=', 0)->whereIn('type', ['App', 'Module'])->get();

        $modulePermissions = $tempPermissions = array();
        foreach ($modulesPermissions as $modulesPermissionkey => $modulesPermission) {
            $controllerPermissions = $this->get_child_id($modulesPermission->id, 'Controller');
            foreach($controllerPermissions as $controllerPermission)
            {
                $actionPermissions = TempPermission::where('parent_id', '=', $controllerPermission->id)->whereIn('type', ['Action'])->get();
                $tempPermissions[$controllerPermission->name][] = $actionPermissions;
            }
            $modulePermissionsName = preg_replace('#[0-9 ]*#', '', $modulesPermission->name);
            $modulePermissions[$modulePermissionsName] = $tempPermissions;
            $tempPermissions = array();
        }

        return view('admin.permissions.manage_user_permissions', compact('user', 'permissions', 'rolesArr', 'userPermissions', 'modulePermissions'));
    }

    /*
     * Update all permission by role here
     */
    public function manage_role_all_permissions($role_id='')
    {

        $status = false;
        $role = Role::findorFail($role_id);
        $rolePermissionCount = DB::table('role_has_permissions')->where('role_id', '=', $role_id)->get()->count();
        $allPermissionCount = Permission::all()->count();
        
        if(!empty($role)) {

            if($rolePermissionCount == $allPermissionCount) {
                $permissions = Permission::all();
                $role->revokePermissionTo($permissions);
                $status = true;
            } else {
                $permissions = Permission::all();
                $role->syncPermissions($permissions);
                $status = true;
            }
        
        }

        if($status)
        {
            $response['status'] = $status;
            $response['msg'] = __('common.permission_update_success');
            return response()->json( $response );
        }

        $response['status'] = $status;
        $response['msg'] = __('common.something_went_wrong');
        return response()->json( $response );
    }

    /*
     * Update single permission for role
     */
    public function manage_role_permission($role_id='', $permission_id='')
    {

        $status = false;
        $role = Role::findorFail($role_id);
        $rolePermissionCount = DB::table('role_has_permissions')->where('role_id', '=', $role_id)->where('permission_id', '=', $permission_id)->get()->count();
        
        if(!empty($role)) {

            if($rolePermissionCount > 0) {
                $permissions = Permission::where('id', '=', $permission_id)->get();
                $role->revokePermissionTo($permissions);
                $status = true;
            } else {
                $permissions = Permission::where('id', '=', $permission_id)->get();
                $role->givePermissionTo($permissions);
                $status = true;
            }
        
        }

        if($status)
        {
            $response['status'] = $status;
            $response['msg'] = __('common.permission_update_success');
            return response()->json( $response );
        }

        $response['status'] = $status;
        $response['msg'] = __('common.something_went_wrong');
        return response()->json( $response );

    }

    /*
     * Update permission for user
     */
    public function manage_user_permission($user_id='', $permission_id='')
    {

        $whereCondition = [['model_id', '=', $user_id], ['permission_id', '=', $permission_id]];

        $status = false;
        $user = User::findorFail($user_id);
        $userPermission = DB::table('model_has_permissions')->where($whereCondition)->first();
        
        if(!empty($user)) {

            if(!empty($userPermission)) {

                if($userPermission->deny == 1) {
                    DB::table('model_has_permissions')->where($whereCondition)->update(['deny'=> 0]);
                } else {
                    DB::table('model_has_permissions')->where($whereCondition)->update(['deny'=> 1]);
                }
                $status = true;
            } else {
                $permissions = Permission::where('id', '=', $permission_id)->get();
                $user->givePermissionTo($permissions);
                $status = true;
            }
        
        }

        if($status)
        {
            $response['status'] = $status;
            $response['msg'] = __('common.permission_update_success');
            return response()->json( $response );
        }

        $response['status'] = $status;
        $response['msg'] = __('common.something_went_wrong');
        return response()->json( $response );

    }

    /*
     * Delete permission for user
     */
    public function delete_user_permission($user_id='', $permission_id='')
    {

        $permissions = Permission::where('id', '=', $permission_id)->get();
        $user = User::findorFail($user_id);
        $res = $user->revokePermissionTo($permissions);

        if($res)
        {
            $response['status'] = $res;
            $response['msg'] = __('common.permission_delete_success');
            return response()->json( $response );
        }

        $response['status'] = $res;
        $response['msg'] = __('common.something_went_wrong');
        return response()->json( $response );
    }

    /*
     * Delete user all permission
     */
    public function manage_user_all_permission($user_id='')
    {

        $user = User::findorFail($user_id);
        $permissions = Permission::all();
        $userPermissions = $user->getDirectPermissions();
        if(!$userPermissions->isEmpty()) 
        {
            $status = $user->revokePermissionTo($userPermissions);
        } 
        else 
        {
            $status = $user->givePermissionTo($permissions);
        }

        if($status)
        {
            $response['status'] = $status;
            $response['checked'] = $status;
            $response['msg'] = __('common.permission_update_success');
            return response()->json( $response );
        }

        $response['status'] = false;
        $response['checked'] = false;
        $response['msg'] = __('common.something_went_wrong');
        return response()->json( $response );
    }

    public function temp_permissions()
    {

        $page_title = __('common.all_temp_permissions');
        $permissionsArr = Permission::all();
        $permissionsCount = $permissionsArr->count();
        $permissionsArr = $permissionsArr->toArray();
        $permissionsArr = array_column($permissionsArr, 'temp_permission_id');
        $tempPermissionsCount = TempPermission::where('type', '=', 'Action')->count();
        $modulesPermissions = TempPermission::whereIn('type', ['App', 'Module'])->get();

        $moduleTempPermissions = $tempPermissions = array();
        foreach ($modulesPermissions as $modulesPermissionkey => $modulesPermission) {
            $controllerPermissions = $this->get_child_id($modulesPermission->id, 'Controller');
            foreach($controllerPermissions as $controllerPermission)
            {
                $actionPermissions = TempPermission::where('parent_id', '=', $controllerPermission->id)->whereIn('type', ['Action'])->get();
                $tempPermissions[$controllerPermission->name][] = $actionPermissions;
            }
            $moduleName = preg_replace('#[0-9 ]*#', '', $modulesPermission->name);
            $moduleTempPermissions[$moduleName] = $tempPermissions;
            $tempPermissions = array();
        }

        return view('admin.permissions.temp_permissions', compact('moduleTempPermissions', 'permissionsCount', 'tempPermissionsCount', 'permissionsArr','page_title'));
    }

    private function get_child_id($parent_id, $type)
    {
        $permission = TempPermission::where('parent_id', '=', $parent_id)->get();
        if(!$permission->isEmpty())
        {
            foreach($permission as $value)
            {
                if($value->type == 'App')
                {
                    $appModulePermissions = TempPermission::where('parent_id', '=', $parent_id)->whereIn('type', ['App'])->get();
                    if(!$appModulePermissions->isEmpty())
                    {   $appControllerData = array();
                        foreach ($appModulePermissions as $modulesPermission) {
                            $appControllerData = array_merge($appControllerData, self::get_child_id($modulesPermission->id, $type)->toArray());
                        }
                        $appControllerData = collect($appControllerData);
                        $appControllerData = $appControllerData->map(function ($value, $key) {
                            return (object) $value;
                        });
                        return $appControllerData;
                    }
                }
                if($value->type != $type)
                {
                    return self::get_child_id($value->id, $type);       
                }
                else
                {
                    return $permission;
                }
            }
        } else {
            return collect();
        }
    }

    public function add_to_permissions()
    {
        
        $modulesPermissions = TempPermission::where('parent_id', '=', 0)->whereIn('type', ['App', 'Module'])->get();
        $i = $j = 0;
        $message = __('common.nothing_to_added');
        $moduleTempPermissions = $tempPermissions = array();
        foreach ($modulesPermissions as $modulesPermissionkey => $modulesPermission) {
            $controllerPermissions = $this->get_child_id($modulesPermission->id, 'Controller');
            foreach($controllerPermissions as $controllerPermission)
            {
                $actionPermissions = TempPermission::where('parent_id', '=', $controllerPermission->id)->whereIn('type', ['Action'])->get();
                foreach ($actionPermissions as $ActionPermissionKey => $ActionPermissionValue) {
                    $controllerPath = explode('\\', $controllerPermission->name);
                    $moduleName = preg_replace('#[0-9 ]*#', '', $modulesPermission->name);
                    $actionPath = $moduleName.'/'.end($controllerPath).'@'.$ActionPermissionValue->name;
                    $permissionName = $moduleName.' > '.end($controllerPath).' > '.$ActionPermissionValue->name;
                    $permissionsArr = ['name' => $permissionName, 'guard_name' => 'web', 'action' => $actionPath, 'temp_permission_id' => $ActionPermissionValue->id];
                    $permissionsRow = Permission::firstWhere('name', $permissionName);
                    ++$i;
                    if(!$permissionsRow)
                    {
                        ++$j;
                        Permission::create( $permissionsArr );
                    }
                }
            }
        }
        if($j)
        {
            $message = $j.__('common.new_permissions_added');
        }
        return redirect()->back()->with('success', $message);
    }

    public function generate_permissions()
    {
        
        foreach (\Route::getRoutes()->getRoutes() as $route)
        {
            $routeActionList = $route->getAction();
            if (array_key_exists('controller', $routeActionList))
            {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $fullPath = $routeActionList['controller'];
                if(\Str::contains($routeActionList['controller'], 'App\Http\\') > 0)
                {
                    $controllerPath = str_replace('App\Http\\', '', $routeActionList['controller']);    
                    $controllerPath = explode('\\', $controllerPath);
                    $endKey = 0;
                    $parent_id=0;

                    if(count($controllerPath) > 0)
                    {
                        $endKey = count($controllerPath)-1;
                        $type = "App";
                        for($i=0; $i<$endKey; $i++)
                        {
                            $parentFolder = $controllerPath[$i];  
                            $temp_permission = TempPermission::where('name', '=', $parentFolder)->where('type', '=', 'App')->first();   
                            if($temp_permission)
                            {
                                $parent_id = $temp_permission->id;
                            }   
                            else{
                                $parent_id = TempPermission::insertGetId([
                                    'parent_id' => $parent_id,
                                    'name' => $parentFolder,
                                    'path' => $fullPath,
                                    'type' => 'App'
                                ]);
                            }
                        }       
                    }
                    
                    $controller_action = explode('@', $controllerPath[$endKey]);
                    $controller_path = explode('@', $routeActionList['controller'])[0];
                    $controller = $controller_action[0];
                    
                    $check_controller = TempPermission::where('name', '=', $controller_path)->where('type', '=', 'Controller')->first();    

                    if($check_controller)
                    {
                        $parent_id = $check_controller->id;
                    } 
                    else 
                    {
                        $parent_id = TempPermission::insertGetId([
                                        'parent_id' => $parent_id,
                                        'name' => $controller_path,
                                        'path' => $fullPath,
                                        'controller' => $controller,
                                        'type' => 'Controller'
                                    ]);
                    }

                    if(isset($controller_action[1]) && !empty($controller_action[1]))
                    {
                        $action = $controller_action[1];

                        $check_action = TempPermission::where('name', '=', $action)->where('parent_id', '=', $parent_id)->where('type', '=', 'Action')->first();

                        if(!$check_action)
                        {
                            $temp_permission = TempPermission::insertGetId([
                                            'parent_id' => $parent_id,
                                            'name' => $action,
                                            'path' => $fullPath,
                                            'controller' => $controller,
                                            'action' => $action,
                                            'type' => 'Action'
                                        ]);
                        }
                    }
                    
                }

                if(\Str::contains($routeActionList['controller'], 'Modules\\') > 0)
                {
                    $controllerPath = str_replace('Modules\\', '', $routeActionList['controller']); 
                    $controllerPath = explode('\\',$controllerPath);
                    $endKey = 0;
                    $parent_id=0;

                    if(count($controllerPath) > 0)
                    {
                        $endKey = count($controllerPath)-1;
                        $type = "App";
                        for($i=0; $i<$endKey; $i++)
                        {
                            $parentFolder = $controllerPath[$i];  

                            $temp_permission = TempPermission::where('name', '=', $parentFolder.' '.$parent_id)->where('type', '=', 'Module')->first(); 
                            
                            if($temp_permission)
                            {
                                $parent_id = $temp_permission->id;
                            }   
                            else
                            {
                                $parent_id = TempPermission::insertGetId([
                                    'parent_id' => $parent_id,
                                    'name' => $parentFolder.' '.$parent_id,
                                    'path' => $fullPath,
                                    'type' => 'Module'
                                ]);
                            }
                        }       
                    }
                    
                    $controller_action = explode('@', $controllerPath[$endKey]);
                    $controller_path = explode('@', $routeActionList['controller'])[0];
                    $controller = $controller_action[0];

                    $check_controller = TempPermission::where('name', '=', $controller_path)->where('type', '=', 'Controller')->first();    

                    if($check_controller)
                    {
                        $parent_id = $check_controller->id;
                    } 
                    else 
                    {
                        $parent_id = TempPermission::insertGetId([
                                        'parent_id' => $parent_id,
                                        'name' => $controller_path,
                                        'path' => $fullPath,
                                        'controller' => $controller,
                                        'type' => 'Controller'
                                    ]);
                    }
                    $action = $controller_action[1];

                    $check_action = TempPermission::where('name', '=', $action)->where('parent_id', '=', $parent_id)->where('type', '=', 'Action')->first();    

                    if(!$check_action)
                    {
                        $temp_permission = TempPermission::insertGetId([
                                        'parent_id'     => $parent_id,
                                        'name'          => $action,
                                        'path'          => $fullPath,
                                        'controller'    => $controller,
                                        'action'        => $action,
                                        'type'          => 'Action'
                                    ]);
                    }

                    
                }               
                
            }
        }
        return redirect()->back()->with('success', __('common.temp_permissions_add_success'));
    }

    public function permission_by_action(Request $request)
    {
        $roles = Role::all();
        $permission_id = $request->input('permission_id');
        $type = $request->input('type');
        $viewFile = 'admin.permissions.ajax.user_permission_by_action';
        if($type == 'role')
        {
            $viewFile = 'admin.permissions.ajax.role_permission_by_action';
        }
        return view($viewFile, compact('permission_id', 'roles'));      
    }

    public function get_users_by_role(Request $request)
    {
        $role_id = $request->input('role_id');

        $users = User::whereHas('roles', function($query) use($role_id) {
                                $query->where('roles.id', '=', $role_id);
                            })
                            ->get();

        return view('admin.permissions.ajax.get_users_by_role', compact('users'));
    }

    public function get_permission_by_user(Request $request)
    {
        $permission_id  = $request->input('permission_id');
        $user_id        = $request->input('user_id');
        
        return view('admin.permissions.ajax.get_permission_by_user', compact('permission_id', 'user_id'));
    }
}
