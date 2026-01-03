<?php

use Modules\CustomField\Http\Controllers\CustomFieldsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/customfield/custom_field/{id?}', [CustomFieldsController::class, 'get_custom_field'])->name('customfields.admin.get_custom_field')->prefix('admin');

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(CustomFieldsController::class)->prefix('admin/customfield')->group(function () {

    Route::get('/', 'index')->name('customfields.admin.index');
    Route::get('/create', 'create')->name('customfields.admin.create');
    Route::post('/store', 'store')->name('customfields.admin.store');
    Route::get('/edit/{id}', 'edit')->name('customfields.admin.edit');
    Route::post('/update/{id}', 'update')->name('customfields.admin.update');
    Route::get('/delete/{id}', 'destroy')->name('customfields.admin.destroy');
    Route::match(['get', 'post'], '/remove-image', 'remove_image')->name('customfields.admin.remove_image');
    Route::match(['get','post'],'/ajax-modal/{field_type}', 'ajax_modal')->name('customfields.admin.ajax_modal');

});
