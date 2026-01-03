<?php

/*Route for permissions*/

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(PermissionsController::class)->prefix('admin/permissions')->name('admin.permissions.')->group(function () {
	
	Route::get('/', 'index')->name('index');
	Route::get('/roles-permissions', 'roles_permissions')->name('roles_permissions');
	Route::get('/role-permissions/{id}', 'role_permissions')->name('role_permissions');
	Route::get('/user-permissions', 'user_permissions')->name('user_permissions');
	Route::get('/manage-user-permissions/{id}', 'manage_user_permissions')->name('manage_user_permissions');
	Route::get('/manage-role-all-permissions/{id}', 'manage_role_all_permissions')->name('manage-role-all-permissions');
	Route::get('/manage-role-permission/{role_id}/{permission_id}', 'manage_role_permission')->name('manage-role-permission');
	Route::get('/manage-user-permission/{user_id}/{permission_id}', 'manage_user_permission')->name('manage-user-permission');
	Route::get('/delete-user-permission/{user_id}/{permission_id}', 'delete_user_permission')->name('delete-user-permission');
	Route::get('/manage-user-all-permission/{user_id}', 'manage_user_all_permission')->name('manage_user_all_permission');

	Route::get('/temp_permissions', 'temp_permissions')->name('temp_permissions');
	Route::get('/generate_permissions', 'generate_permissions')->name('generate_permissions');
	Route::get('/add_to_permissions', 'add_to_permissions')->name('add_to_permissions');

	Route::post('/permission_by_action', 'permission_by_action')->name('permission_by_action');
	Route::post('/get_users_by_role', 'get_users_by_role')->name('get_users_by_role');
	Route::post('/get_permission_by_user', 'get_permission_by_user')->name('get_permission_by_user');
});