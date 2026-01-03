<?php

use App\Helper\DzHelper;
use App\Http\Controllers\Admin\ConfigurationsController;
use App\Models\Configuration;

Route::post('/configurations/make-slug', [ConfigurationsController::class, 'make_slug'])->name('configurations.make_slug');
Route::post('/configurations/upload-files', [ConfigurationsController::class, 'upload_files'])->name('configurations.upload_files');
Route::post('/configurations/remove-file', [ConfigurationsController::class, 'remove_file'])->name('configurations.remove_files');
Route::match(['get','post'],'/ckeditor/uploads', [ConfigurationsController::class, 'ckeditor_uploads']);


/* ------ Routes for Frontend ----- */
Route::middleware(['theme','DzFrontLangMiddleware'])->controller(HomeController::class)->group(function () {
	
	Route::post('/language', 'themelanguage')->name('language');
	Route::post('/comment/store', 'comment_store')->name('home.comments.store');

	try {
		if(Schema::hasTable('configurations'))
		{
			$permalink		= Configuration::getConfig('Permalink.settings');
			$rewritereplace = config('menu.permalink_structure_rewritecode');
			$rewritecode 	= config('menu.permalink_structure');
			$link 			= str_replace( $rewritecode, $rewritereplace, $permalink );

			if(empty($link) || Str::contains(URL::current(), 'install'))
			{
				$link = '/';
			}

		    $pageLink = '/{slug}';

		    if(empty($permalink) || Str::contains(URL::current(), 'install'))
		    {
		    	$pageLink = '?page_id={page_id?}';
		    }

		    Route::get('/category/{slug?}', 'category')->name('permalink.category_action');
			Route::get('/author/{name?}', 'author')->name('permalink.author_action');
			Route::get('/tag/{slug?}', 'tag')->name('permalink.blogtag_action');
			Route::get('/search', 'search')->name('permalink.search');
			Route::get('/{year}/{month?}', 'archive')->name('permalink.archive_action')->where(['year' => '[0-9]{4}+','month' => '[0-9]|[0-9]{2}']);
			Route::post('/contact', 'contact')->name('front.contact');
		
			Route::get('/blog', 'blogslist');
			Route::post('/ajax-get-data', 'ajax_get_data')->name('front.ajax_get_data');
		   	Route::match(['get','post'],$pageLink, 'detail')->name('permalink.page_action');
	   		// Route::match(['get','post'],$link, 'detail')->name('permalink.action');
	   		
	   		$postTypes = DzHelper::get_post_types()->pluck('slug')->toArray();
			$regex = !empty($postTypes) ? implode('|', $postTypes) : '___invalid___';
	   		Route::match(['get','post'],'/{post_type?}'.$link, 'detail')->name('permalink.action')->where('post_type', $regex);

		}
	} catch (Exception $e) {
		
	}

});
