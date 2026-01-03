<?php

Route::middleware(['auth:sanctum', 'verified'])->controller(DashboardController::class)->prefix('admin')->group(function () {
	Route::get('/', 'dashboard');
	Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
});

/*Route for users*/
Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(UsersController::class)->prefix('admin')->group(function () {
	Route::get('/users', 'index')->name('admin.users.index');
	Route::get('/users/create', 'create')->name('admin.users.create');
	Route::post('/users/store', 'store')->name('admin.users.store');
	Route::get('/users/edit/{id}', 'edit')->name('admin.users.edit');
	Route::post('/users/update/{id}', 'update')->name('admin.users.update');
	Route::match(['get', 'post'],'/users/delete/{id}', 'destroy')->name('admin.users.delete');
	Route::post('/users/update-password/{id}', 'update_password')->name('admin.users.update-password');
	Route::post('/users/update-roles/{id}', 'update_user_roles')->name('admin.users.update_user_roles');
	Route::match(['get', 'post'], '/profile', 'profile')->name('admin.users.profile');
	Route::get('user/remove_image/{id}', 'remove_user_image')->name('admin.user.remove_user_image');
});

/*Route for Roles*/
Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(RolesController::class)->prefix('admin/roles')->name('admin.roles.')->group(function () {
	Route::get('/', 'index')->name('index');
	Route::get('/create', 'create')->name('create');
	Route::post('/store', 'store')->name('store');
	Route::get('/edit/{id}', 'edit')->name('edit');
	Route::post('/update/{id}', 'update')->name('update');
	Route::get('/delete/{id}', 'destroy')->name('delete');
});

/*Route for Languages*/
Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(LanguageController::class)->prefix('admin/languages')->name('admin.languages.')->group(function () {
	Route::match(['get', 'post'], '/', 'index')->name('index');
	Route::post('/get_languages', 'show')->name('show');
	Route::post('/translate', 'translate')->name('translate');
    Route::post('/add', 'add_language')->name('add');

});
