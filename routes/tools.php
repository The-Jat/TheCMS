<?php

// use App\Http\Controllers\Admin\ToolsController;
// use App\Http\Controllers\Admin\ThemesController;
// use App\Http\Controllers\Admin\MagicEditorsController;
// use Illuminate\Http\Request;

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


/*=========== ToolsController ===========*/
Route::middleware(['auth:sanctum', 'verified'])->controller(ToolsController::class)->prefix('admin/tools')->name('tools.admin.')->group(function () {
    Route::match(['get', 'post'], '/export', 'export')->name('export');
    Route::match(['get', 'post'], '/import', 'import')->name('import');
});

/*=========== ThemesController ===========*/
Route::middleware(['auth:sanctum', 'verified'])->controller(ThemesController::class)->name('themes.admin.')->prefix('admin/themes')->group(function () {
    Route::match(['get', 'post'], '/index', 'index')->name('index');
    Route::match(['get', 'post'], '/admin_themes', 'admin_themes')->name('admin_themes');
    Route::post('/import_theme', 'import_theme')->name('import_theme');
    Route::match(['get', 'post'], '/add_theme', 'add_theme')->name('add_theme');
    Route::match(['get', 'post'], '/add_admin_theme', 'add_admin_theme')->name('add_admin_theme');
    Route::match(['get', 'post'], '/install_theme', 'install_theme')->name('install_theme');
    Route::match(['get', 'post'], '/install_upload_theme', 'install_upload_theme')->name('install_upload_theme');
    Route::match(['get', 'post'], '/delete', 'delete')->name('delete');
});

/*=========== MagicEditorsController ===========*/
Route::middleware(['auth:sanctum', 'verified'])->controller(MagicEditorsController::class)->prefix('admin/magic_editors')->group(function () {
    Route::get( '/use-me', 'admin_use_me')->name('admin.use.me');
    Route::post( '/add-element', 'add_element')->name('admin.add_element.me');
    Route::match(['get', 'post'], '/edit-section', 'admin_edit_section')->name('admin.edit.me');
    Route::match(['get', 'post'], '/update-element', 'admin_update_element')->name('update.element.me');
    Route::match(['get', 'post'], '/remove-image', 'admin_remove_image')->name('me.admin.remove_image');
    Route::match(['get', 'post'], '/page-content/{page_id}', 'get_page_content')->name('get.page_content.me');
    Route::get('/get-all-cpt', 'get_all_cpt')->name('admin.get_all_cpt.me');
    Route::get('/get-post-by-cpt/{post_type}', 'get_post_by_cpt')->name('admin.get_post_by_cpt.me');
    Route::get('/get-post-taxonomy/{taxonomy}', 'get_post_taxonomy')->name('admin.get_post_taxonomy.me');

    /*  editor elements ajax routes  */
    Route::post('/get_post_by_category', 'get_post_by_category')->name('admin.get_post_by_category.me');
    Route::post('/get_cpt_categories', 'get_cpt_categories')->name('admin.get_cpt_categories.me');
    Route::post('/get_post_by_cpt_category', 'get_post_by_cpt_category')->name('admin.get_post_by_cpt_category.me');
});

/*=========== MagicEditorsController ===========*/
Route::controller(MagicEditorsController::class)->prefix('admin/magic_editors')->group(function () {
    Route::match(['get', 'post'],'/ajax_load_more', 'ajax_load_more')->name('admin.ajax_load_more.me');
});


/* ============================== Use this route for themes preview images ============================== */
Route::get('/themes/{vendor}/{theme}/{file}', function($vendor, $theme, $file){
    $path = base_path() . '/themes/' . $vendor.'/'.$theme.'/'.$file;

    if(File::exists($path)) {
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    return false;
})->name('get_file');
/* ============================== Use this route for themes preview images ============================== */