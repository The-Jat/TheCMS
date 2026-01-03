<?php

use Illuminate\Support\Facades\Route;
use Modules\W3Options\Http\Controllers\W3OptionsController;

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

Route::controller(W3OptionsController::class)->middleware(['auth:sanctum', 'verified'])->prefix('admin/theme-options')->group(function () {
    Route::match(['get', 'post'], '/index', 'theme_options')->name('w3options.admin.theme-options');
    Route::post('/save', 'theme_options_save')->name('w3options.admin.save-theme-options');
});