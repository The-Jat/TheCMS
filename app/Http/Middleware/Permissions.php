<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()) {

            $chunks = explode("\\", Route::currentRouteAction());
            $controller = end($chunks);

            $user = auth()->user();

            if(!$user->hasRole(config('constants.roles.admin')))
            {
                $roles = DB::table('model_has_roles')->select('role_id')->where('model_id', '=', $user->id)->get();

                $roleArr = array();
                foreach ($roles as $value) {
                    $roleArr[] = $value->role_id;
                }

                $user_permissions = DB::table('permissions')
                        ->join('model_has_permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
                        ->select('permissions.id')
                        ->where('permissions.action', 'LIKE',  "%{$controller}")
                        ->where('model_has_permissions.model_id', $user->id)
                        ->where('model_has_permissions.deny', '=', 0)
                        ->get();

                $user_deny_permission = DB::table('permissions')
                        ->join('model_has_permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
                        ->select('permissions.id')
                        ->where('permissions.action', 'LIKE',  "%{$controller}")
                        ->where('model_has_permissions.model_id', $user->id)
                        ->where('model_has_permissions.deny', '=', 1)
                        ->count();

                $hasUserPermission = count($user_permissions);


                $role_permissions = DB::table('permissions')
                        ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                        ->select('permissions.id')
                        ->where('permissions.action', 'LIKE',  "%{$controller}")
                        ->whereIn('role_has_permissions.role_id', $roleArr)
                        ->get();

                $hasRolePermission = count($role_permissions);


                if($hasRolePermission == 0 && $hasUserPermission == 0) {
                    if(request()->headers->get('referer')) {
                        return redirect()->back()->with('error', __('Permission are not allowed.'));
                    } else {
                        abort(403, $message = __('Permission are not allowed.'));
                    }
                } 

                if($hasRolePermission > 0) {

                    if($user_deny_permission > 0) {
                        if(request()->headers->get('referer')) {
                            return redirect()->back()->with('error', __('Permission are not allowed.'));
                        } else {
                            abort(403, $message = __('Permission are not allowed.'));
                        }
                    }

                }
            }

        }

        return $next($request);
    }
}
