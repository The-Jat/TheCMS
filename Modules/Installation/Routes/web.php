<?php
use Modules\Installation\Http\Controllers\InstallationController;

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

Route::name('LaravelInstaller::')->prefix('install')->group(function () {
    Route::get('/', [InstallationController::Class, 'welcome'])->name('welcome');
    Route::get('/environment/wizard', [InstallationController::Class, 'environmentWizard'])->name('environmentWizard');
    Route::post('/environment/saveWizard', [InstallationController::Class, 'saveWizard'])->name('environmentSaveWizard');
    Route::match(['GET', 'POST'], '/database', [InstallationController::Class, 'database'])->name('database');
    Route::get('/admin', [InstallationController::Class, 'admin'])->name('admin');
    Route::post('/admin/save', [InstallationController::Class, 'saveAdmin'])->name('saveAdmin');
    Route::get('/final', [InstallationController::Class, 'finish'])->name('final');
    Route::match(['GET', 'POST'], '/requirements', [InstallationController::Class, 'requirements'])->name('requirements');
});
