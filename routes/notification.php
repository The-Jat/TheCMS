<?php


Route::middleware(['auth:sanctum', 'verified'])->controller(NotificationsController::class)->prefix('admin/notifications')->name('admin.notification.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::get('/delete/{id}', 'destroy')->name('destroy');
    Route::match(['get', 'post'], '/settings', 'settings')->name('settings');
    Route::match(['get', 'post'], '/notifications_config', 'notifications_config')->name('notifications_config');
    Route::match(['get', 'post'], '/edit_template/{config_id}', 'edit_template')->name('edit_template');
    Route::match(['get', 'post'], '/edit_email_template/{config_id}', 'edit_email_template')->name('edit_email_template');
    Route::match(['get', 'post'], '/edit_web_template/{config_id}', 'edit_web_template')->name('edit_web_template');
    Route::match(['get', 'post'], '/edit_sms_template/{config_id}', 'edit_sms_template')->name('edit_sms_template');

});
