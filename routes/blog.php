<?php

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(BlogsController::class)->name('blog.admin.')->prefix('admin/blogs')->group(function () {

    Route::get('/', 'admin_index')->name('index');
    Route::get('/create', 'admin_create')->name('create');
    Route::post('/store', 'admin_store')->name('store');
    Route::get('/edit/{id}', 'admin_edit')->name('edit');
    Route::post('/update/{id}', 'admin_update')->name('update');
    Route::get('/delete/{id}', 'admin_destroy')->name('destroy');
    Route::get('/trash-status/{id}', 'admin_trash_status')->name('admin_trash_status');
    Route::get('/restore-blog/{id}', 'restore_blog')->name('restore_blog');
    Route::get('/trashed-blogs', 'trash_list')->name('trash_list');
    Route::get('/remove_feature_image/{id}', 'remove_feature_image')->name('remove_feature_image');
});

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(BlogCategoriesController::class)->name('blog_category.admin.')->prefix('admin/blogs/categories')->group(function () {

    Route::match(['GET', 'POST'], '/list/{id?}', 'list')->name('list');
    Route::get('/', 'admin_index')->name('index');
    Route::get('/create', 'admin_create')->name('create');
    Route::post('/store', 'admin_store')->name('store');
    Route::get('/edit/{id}', 'admin_edit')->name('edit');
    Route::post('/update/{id}', 'admin_update')->name('update');
    Route::get('/delete/{id}', 'admin_destroy')->name('destroy');
    Route::get('/trash-status/{id}', 'admin_trash_status')->name('admin_trash_status');
    Route::post('/admin_ajax_add_category', 'admin_ajax_add_category')->name('admin_ajax_add_category');

    Route::match(['get'], '/moveup/{id}', 'admin_moveup')->name('categories.admin_moveup');
    Route::match(['get'], '/movedown/{id}', 'admin_movedown')->name('categories.admin_movedown');
});

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(BlogTagsController::class)->name('blog_tag.admin.')->prefix('admin/blogs/tags')->group(function () {

    Route::match(['GET', 'POST'], '/list/{id?}', 'list')->name('list');
    Route::get('/', 'admin_index')->name('index');
    Route::get('/create', 'admin_create')->name('create');
    Route::post('/store', 'admin_store')->name('store');
    Route::get('/edit/{id}', 'admin_edit')->name('edit');
    Route::post('/update/{id}', 'admin_update')->name('update');
    Route::get('/delete/{id}', 'admin_destroy')->name('destroy');

});

Route::middleware(['auth:sanctum', 'verified', 'permissions'])->controller(WidgetsController::class)->prefix('admin/widgets')->name('admin.widgets.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/update/{id}', 'update')->name('update');
    Route::get('/destroy/{id}', 'destroy')->name('destroy');
    Route::get('/destroy-block/{id?}', 'destroy_block')->name('destroy_block');
    Route::post('/create-or-store-block/{id?}', 'create_or_update_block')->name('create_or_update_block');
    Route::post('/update-block', 'update_block')->name('update_block');
});
