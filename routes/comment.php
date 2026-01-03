<?php

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(CommentsController::class)->prefix('admin/comments')->name('comments.admin.')->group(function () {

    Route::get('/', 'admin_index')->name('index');
    Route::get('/edit/{id}', 'admin_edit')->name('edit');
    Route::post('/update/{id}', 'admin_update')->name('update');
    Route::get('/trash/{id}', 'admin_trash')->name('trash');
    Route::get('/delete/{id}', 'admin_destroy')->name('destroy');
    Route::post('/store', 'admin_store')->name('store');

});
