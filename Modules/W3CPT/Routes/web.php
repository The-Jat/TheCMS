<?php

use Modules\W3CPT\Http\Controllers\W3CPTController;
use Modules\W3CPT\Http\Controllers\BlogsController;
use Modules\W3CPT\Http\Controllers\BlogCategoriesController;
use Modules\W3CPT\Http\Controllers\BlogTagsController;

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

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/w3cpt')->group(function() {
    Route::get('/index', [W3CPTController::class, 'index'])->name('cpt.admin.index');
    Route::match(['get', 'post'], '/save/{id?}', [W3CPTController::class, 'save'])->name('cpt.admin.save');
    Route::match(['get'], '/delete/{id}', [W3CPTController::class, 'destroy'])->name('cpt.admin.destroy');
    Route::get('/w3cpt_taxo/index', [W3CPTController::class, 'index_taxo'])->name('cpt_taxo.admin.index');
    Route::match(['get', 'post'], '/w3cpt_taxo/save/{id?}', [W3CPTController::class, 'save_taxo'])->name('cpt_taxo.admin.save');
    Route::match(['get', 'post'], '/w3cpt_taxo/delete/{id}', [W3CPTController::class, 'destroy_taxo'])->name('cpt_taxo.admin.destroy');
    Route::get('/trash_cpt/{id}', [W3CPTController::class, 'trash_cpt'])->name('cpt.admin.trash');
    Route::get('/trash_taxo/{id}', [W3CPTController::class, 'trash_taxo'])->name('cpt_taxo.admin.trash');
    Route::get('/trash_list', [W3CPTController::class, 'trash_list'])->name('cpt.admin.trash_list');
    Route::get('/trash_taxo_list', [W3CPTController::class, 'trash_taxo_list'])->name('cpt.admin.trash_taxo_list');
    Route::get('/restore/{id}', [W3CPTController::class, 'resotre_cpt_taxo'])->name('cpt.admin.restore');
});

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->prefix('admin/w3-cpt')->group(function () {

    Route::get('', [BlogsController::class, 'admin_index'])->name('cpt.blog.admin.index');
    Route::get('/create', [BlogsController::class, 'admin_create'])->name('cpt.blog.admin.create');
    Route::post('/store', [BlogsController::class, 'admin_store'])->name('cpt.blog.admin.store');
    Route::get('/edit/{id}', [BlogsController::class, 'admin_edit'])->name('cpt.blog.admin.edit');
    Route::post('/update/{id}', [BlogsController::class, 'admin_update'])->name('cpt.blog.admin.update');
    Route::get('/delete/{id}', [BlogsController::class, 'admin_destroy'])->name('cpt.blog.admin.destroy');
    Route::get('/trash-status/{id}', [BlogsController::class, 'admin_trash_status'])->name('cpt.blog.admin.admin_trash_status');
    Route::get('/restore-blog/{id}', [BlogsController::class, 'restore_blog'])->name('cpt.blog.admin.restore_blog');
    Route::get('/trashed-blogs', [BlogsController::class, 'trash_list'])->name('cpt.blog.admin.trash_list');
    Route::get('/remove_feature_image/{id}', [BlogsController::class, 'remove_feature_image'])->name('cpt.blog.admin.remove_feature_image');

    Route::match(['GET', 'POST'], '/categories/list/{id?}', [BlogCategoriesController::class, 'list'])->name('cpt.blog_category.admin.list');
    Route::get('/categories', [BlogCategoriesController::class, 'admin_index'])->name('cpt.blog_category.admin.index');
    Route::get('/categories/create', [BlogCategoriesController::class, 'admin_create'])->name('cpt.blog_category.admin.create');
    Route::post('/categories/store', [BlogCategoriesController::class, 'admin_store'])->name('cpt.blog_category.admin.store');
    Route::get('/categories/edit/{id}', [BlogCategoriesController::class, 'admin_edit'])->name('cpt.blog_category.admin.edit');
    Route::post('/categories/update/{id}', [BlogCategoriesController::class, 'admin_update'])->name('cpt.blog_category.admin.update');
    Route::get('/categories/delete/{id}', [BlogCategoriesController::class, 'admin_destroy'])->name('cpt.blog_category.admin.destroy');
    Route::get('/categories/trash-status/{id}', [BlogCategoriesController::class, 'admin_trash_status'])->name('cpt.blog_category.admin.admin_trash_status');
    Route::post('/categories/admin_ajax_add_category', [BlogCategoriesController::class, 'admin_ajax_add_category'])->name('cpt.blog_category.admin.admin_ajax_add_category');

    Route::match(['get'], '/categories/moveup/{id}', [BlogCategoriesController::class, 'admin_moveup'])->name('cpt.blog_category.admin.categories.admin_moveup');
    Route::match(['get'], '/categories/movedown/{id}', [BlogCategoriesController::class, 'admin_movedown'])->name('cpt.blog_category.admin.categories.admin_movedown');

    Route::match(['GET', 'POST'], '/tags/list/{id?}', [BlogTagsController::class, 'list'])->name('cpt.blog_tag.admin.list');
    Route::get('/tags', [BlogTagsController::class, 'admin_index'])->name('cpt.blog_tag.admin.index');
    Route::get('/tags/create', [BlogTagsController::class, 'admin_create'])->name('cpt.blog_tag.admin.create');
    Route::post('/tags/store', [BlogTagsController::class, 'admin_store'])->name('cpt.blog_tag.admin.store');
    Route::get('/tags/edit/{id}', [BlogTagsController::class, 'admin_edit'])->name('cpt.blog_tag.admin.edit');
    Route::post('/tags/update/{id}', [BlogTagsController::class, 'admin_update'])->name('cpt.blog_tag.admin.update');
    Route::get('/tags/delete/{id}', [BlogTagsController::class, 'admin_destroy'])->name('cpt.blog_tag.admin.destroy');

});