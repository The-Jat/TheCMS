<?php


/*Route for configurations*/
Route::middleware(['auth:sanctum', 'verified'])->controller(ConfigurationsController::class)->prefix('admin/configurations')->name('admin.configurations.')->group(function () {

	Route::match(['get'], '/index', 'admin_index')->name('admin_index');
	Route::match(['get', 'post'], '/add', 'admin_add')->name('admin_add');
	Route::match(['get', 'post'], '/edit/{id}', 'admin_edit')->name('admin_edit');
	Route::match(['get'], '/delete/{id}', 'admin_delete')->name('admin_delete');
	Route::match(['get'], '/view/{id?}', 'admin_view')->name('admin_view');
	Route::match(['get', 'post'], '/prefix/Reading', 'admin_reading')->name('admin_reading');
	Route::match(['get','post'], '/prefix/Settings', 'admin_settings')->name('admin_settings');
	Route::match(['get', 'post'], '/prefix/{prefix?}', 'admin_prefix')->name('admin_prefix');
	Route::match(['post'], '/save_config/{prefix}', 'save_config')->name('save_config');
	Route::match(['get', 'post'], '/admin_change_theme/{id?}/{value?}', 'admin_change_theme')->name('admin_change_theme');
	Route::match(['get'], '/change/{id}', 'admin_change')->name('admin_change');
	Route::match(['get'], '/moveup/{id}', 'admin_moveup')->name('admin_moveup');
	Route::match(['get'], '/movedown/{id}', 'admin_movedown')->name('admin_movedown');
	Route::match(['post'], '/save_permalink', 'save_permalink')->name('save_permalink');
	Route::match(['post'], '/upload_editor_image', 'upload_editor_image')->name('upload_editor_image');
	Route::get('/remove_image/{id}/{name}', 'remove_config_image')->name('remove_config_image');
	Route::post('/date_time_format/', 'date_time_format')->name('date_time_format');

});