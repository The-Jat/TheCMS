<?php


Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(PagesController::class)->prefix('admin/pages')->name('page.admin.')->group(function () {

    Route::match(['get', 'post'], '/', 'admin_index')->name('index');
    Route::get('/create', 'admin_create')->name('create');
    Route::post('/store', 'admin_store')->name('store');
    Route::get('/edit/{id}', 'admin_edit')->name('edit');
    Route::post('/update/{id}', 'admin_update')->name('update');
    Route::get('/delete/{id}', 'admin_destroy')->name('destroy');
    Route::get('/trashed-pages', 'trash_list')->name('trash_list');
    Route::get('/restore-page/{id}', 'restore_page')->name('restore_page');
    Route::get('/trash-status/{id}', 'admin_trash_status')->name('admin_trash_status');
    Route::get('/remove_feature_image/{id}', 'remove_feature_image')->name('remove_feature_image');

});