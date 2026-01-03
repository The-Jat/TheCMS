<?php

Route::middleware(['auth:sanctum', 'verified'])->controller(MenusController::class)->prefix('admin/menu')->name('menu.admin.')->group(function () {

    Route::match(['get', 'post'], '/index/{id?}', 'admin_index')->name('admin_index');
    Route::post('/create', 'admin_create')->name('admin_create');
    Route::post('/delete', 'admin_destroy')->name('admin_destroy');
    Route::post('/ajax_menu_item_delete', 'ajax_menu_item_delete')->name('ajax_menu_item_delete');
    Route::post('/admin_select_menu/{id?}', 'admin_select_menu')->name('admin_select_menu');
    Route::post('/ajax_add_link', 'ajax_add_link')->name('ajax_add_link');
    Route::post('/ajax_add_page', 'ajax_add_page')->name('ajax_add_page');
    Route::post('/search_menus', 'search_menus')->name('search_menus');

});
