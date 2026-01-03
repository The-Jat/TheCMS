<?php
namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Acl
{
    
    public static function action() {
        $chunks = explode("@",Route::currentRouteAction());
        return end($chunks);
    }
    
    public static function controller() {
        $chunks = explode("\\",Route::currentRouteAction());
        $controller = explode("@",end($chunks));
        return $controller[0]; 
    }
    
    public static function get_role_permissions_count($role_id) {
    
		$rolePermission = DB::table('role_has_permissions')->where('role_id', '=', $role_id)->get()->count();

        return $rolePermission;
    }

    public static function checked_user_permission($user_id='', $permission_id='') {
    
		$hasModelPermission = DB::table('model_has_permissions')->where('model_id', '=', $user_id)->where('permission_id', '=', $permission_id);

        if($hasModelPermission->count() > 0) {

            $permission = $hasModelPermission->first();
            if(!empty($permission) && $permission->deny == 0) {
                return 1;
            } else if(!empty($permission) && $permission->deny == 1) {
                return 2;
            }
            
        }
        return 0;
    }
    
    public static function checked_role_permission($role_id='', $permission_id='') {
    
		$hasRolePermission = DB::table('role_has_permissions')->where('role_id', '=', $role_id)->where('permission_id', '=', $permission_id)->get()->count();

		if($hasRolePermission > 0) {
			return 'checked="checked"';
		}
        return false;
    }

    public static function get_permission_id($temp_permission_id)
    {
        $permission = Permission::select('id')->where('temp_permission_id', '=', $temp_permission_id)->first();
        return $permission ? $permission->id : 0;
    }
    
    
}