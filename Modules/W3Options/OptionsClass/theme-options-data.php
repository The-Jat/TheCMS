<?php

/* Single Pages Template */
function page_template_options(){
	
	$page_templates = array(
		'coming' => array(
			array(
				'title' => __('Comingsoon'),
				'id'   => 'coming_style_1',
				'img'   => asset('/images/theme-options-images/page-template/coming-soon.png'),
				'param'  => array()
			)
		),
		'maintenance' => array(
			array(
				'title' => __('Maintenance'),
				'id'   	=> 'maintenance_style_1',
				'img'   => asset('/images/theme-options-images/page-template/site-down-for-maintain.png'),
				'param'  => array()
			)
		),
		'error' => array(
			array(
				'title' => __('Error'),
				'id'   => 'error_style_1',
				'img'   => asset('/images/theme-options-images/page-template/error-404.png'),
				'param'  => array()
			)
		)
	);
	return $page_templates;
}

/* Single Post Layouts */
function post_layouts_options(){

	$post_layouts = array(
		array(
			"id"   => "post_standard",
			'layout_param' => array(
		    	'title' => 'Standard',
		    	'img' => asset('images/theme-options-images/post-layout/standard-post.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "post_cornerimage",
			'layout_param' => array(
		    	'title' => 'Corner Post',
		    	'img' => asset('images/theme-options-images/post-layout/corner-image-post.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "post_link",
			'layout_param' => array(
		    	'title' => 'Link Post',
		    	'img' => asset('images/theme-options-images/post-layout/link-post.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "post_video",
			'layout_param' => array(
		    	'title' => 'Video Post',
		    	'img' => asset('images/theme-options-images/post-layout/video-post.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "post_audio",
			'layout_param' => array(
		    	'title' => 'Audio Post',
		    	'img' => asset('images/theme-options-images/post-layout/audio-post.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "post_slider_1",
			'layout_param' => array(
		    	'title' => 'Slider Post 1',
		    	'img' => asset('images/theme-options-images/post-layout/slider-post-1.png')
		    ),
			"param"  => array()
		),
		array(
			'id'   => 'post_quote',
			'layout_param' => array(
		    	'title' => __('Quote Post'),
		    	'img' => asset('images/theme-options-images/post-layout/post-quote.png')
		    ),
			'param'  => array()
		),
		array(
			'id'   => 'post_header_image',
			'layout_param' => array(
		    	'title' => __('Header Image'),
		    	'img' => asset('images/theme-options-images/post-layout/post-header-image.png')
		    ),
			'param'  => array()
		),
	);

	return $post_layouts;
}

/* Header Layouts Options */
function header_style_options(){
	$header_styles = array(
		array(
			"id"   => "header_1",
			'img_param' => array(
				"title" => __('Style - Normal For Container'),
				"img"   => asset('/images/theme-options-images/header/header-1.png')
			),
			"param"  => array(
				"class" => "",
				'social_link' => 1,
				'search' => 0,
				'call_to_action_button' => 1,
				'social_links' => 6,
				'top_bar' => 1,
				'informative_fields_header'	=> 0
			)
		),

		array(
			"id"   => "header_2",
			'img_param' => array(
				"title" => __('Style - transparant'),
				"img"   => asset('/images/theme-options-images/header/header-2.png')
			),
			"param"  => array(
				"class" => "",
				'social_link' => 0,
				'search' => 0,
				'call_to_action_button' => 1,
				'social_links' => 0,
				'top_bar' => 0,
				'informative_fields_header'	=> 0
			)
		),

		array(
			"id"   => "header_3",
			'img_param' => array(
				"title" => __('Style - Normal'),
				"img"   => asset('/images/theme-options-images/header/header-3.png')
			),
			"param"  => array(
				"class" => "",
				'social_link' => 1,
				'search' => 0,
				'call_to_action_button' => 1,
				'social_links' => 6,
				'top_bar' => 1,
				'informative_fields_header'	=> 0
			)
		),

	);

	return $header_styles;
}

/* Foote Layouts Options */
function footer_style_options(){
	$footer_styles = array(
		array(
			"title" => __('Footer 1'),
			"id"   => "footer_template_1",
			'img_param' => array(
				"title" => __('Footer Template 1'),
				"img"   => asset('/images/theme-options-images/footer/footer-1.png'),
			),
			"param"  => array(
				'social_link' => 1,
				'copyright'	=> 1,
				'powered_by'	=> 0,
				'sections'	=> 1,
				'bg_image'	=> 1,
                'informative_field'	=> 0,
			)
		),
		array(
			"title" => __('Footer 2'),
			"id"   => "footer_template_2",
			'img_param' => array(
				"title" => __('Footer Template 2'),
				"img"   => asset('/images/theme-options-images/footer/footer-2.png'),
			),
			"param"  => array(
				'social_link' => 1,
				'copyright'	=> 1,
				'powered_by'	=> 0,
				'sections'	=> 1,
				'bg_image'	=> 1,
                'informative_field'	=> 0,
			)
		),

	);

	return $footer_styles;
}

/* Foote Theme Options */
function theme_style_options(){
	$theme_styles = array(
		array(
			"title" => __('Sky Blue'),
			"id"   => "skin-1",
			'img_param' => array(
				"title" => __('Sky Blue'),
				"img"   => asset('/images/theme-options-images/theme/sky-blue.png'),
			),
			"param"  => array()
		),
		array(
			"title" => __('Light Pink'),
			"id"   => "skin-2",
			'img_param' => array(
				"title" => __('Light Pink'),
				"img"   => asset('/images/theme-options-images/theme/light-pink.png'),
			),
			"param"  => array()
		),

	);

	return $theme_styles;
}

/* Banner Layouts Options */
function page_banner_layout_options(){
	$banner_styles = array(
		array(
			"title" => __('Banner Layout 1'),
			"id"   => "banner_layout_1",
			'img_param' => array(
				"title" => __('Banner Layout 1'),
				"img"   => asset('/images/theme-options-images/footer/footer-1.png'),
			),
			"param"  => array()
		),
		array(
			"title" => __('Banner Layout 2'),
			"id"   => "banner_layout_2",
			'img_param' => array(
				"title" => __('Banner Layout 2'),
				"img"   => asset('/images/theme-options-images/footer/footer-1.png'),
			),
			"param"  => array()
		),
	);

	return $banner_styles;
}


/* Sidebar Layouts Options*/
function sidebar_layout_options(){

	$sidebar_layout = array(
		array(
			'id' => 'sidebar_full',
			'sidebar_param' => array(
				'title' => 'Full Width',
				'img' 	=> asset('images/theme-options-images/sidebar/sidebar-full.png')
			),
			"param"  => array()
		),
		array(
			'id' => 'sidebar_left',
			'sidebar_param' => array(
				'title' => 'Left Side',
				'img' 	=> asset('images/theme-options-images/sidebar/sidebar-left.png')
			),
			"param"  => array()
		),
		array(
			'id' => 'sidebar_right',
			'sidebar_param' => array(
				'title' => 'Right Side',
				'img' 	=> asset('images/theme-options-images/sidebar/sidebar-right.png')
			),
			"param"  => array()
		),
	);

	return $sidebar_layout;
}

/* Post Box/Wrapper Style Options */
function post_wrapper_options(){
	
	$post_wrapper_layout = array(
		array(
			"id"   => "post_box_1",
			"img_param" =>  array(
				"title" => 'Post Box 1',
				"img"   => asset('images/theme-options-images/post-box/box-1.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_2",
			"img_param" =>  array(
				"title" => 'Post Box 2',
				"img"   => asset('images/theme-options-images/post-box/box-2.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_3",
			"img_param" =>  array(
				"title" => 'Post Box 3',
				"img"   => asset('images/theme-options-images/post-box/box-3.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_4",
			"img_param" =>  array(
				"title" => 'Post Box 4',
				"img"   => asset('images/theme-options-images/post-box/box-4.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_5",
			"img_param" =>  array(
				"title" => 'Post Box 5',
				"img"   => asset('images/theme-options-images/post-box/box-5.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_6",
			"img_param" =>  array(
				"title" => 'Post Box 6',
				"img"   => asset('images/theme-options-images/post-box/box-6.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_7",
			"img_param" =>  array(
				"title" => 'Post Box 7',
				"img"   => asset('images/theme-options-images/post-box/box-7.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_8",
			"img_param" =>  array(
				"title" => 'Post Box 8',
				"img"   => asset('images/theme-options-images/post-box/box-8.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_9",
			"img_param" =>  array(
				"title" => 'Post Box 9',
				"img"   => asset('images/theme-options-images/post-box/box-9.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_box_10",
			"img_param" =>  array(
				"title" => 'Post Box 10',
				"img"   => asset('images/theme-options-images/post-box/box-10.png')
			),
			"param"  => array()
		)
	);

	return $post_wrapper_layout;
}

/* Post Listing Style Options */
function post_listing_options(){

	$post_listing_layout = array(
		array(
			"id"   => "post_listing_1",
			"listing_param" =>  array(
				"title" => 'Post Listing 1',
				"img"   => asset('images/theme-options-images/post-listing/layout-1.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "post_listing_2",
			"listing_param" => array(
				"title" => 'Post Listing 2',
				"img"   => asset('images/theme-options-images/post-listing/layout-2.png')
			),
			"param"  => array()
		)
	);

	return $post_listing_layout;
}

/* Page Banner Style Options */
function page_banner_options(){
	$page_banner_style = array(
		array(
			"id"   => "page_banner_big",
			'banner_param' => array(
		    	'title' => 'Fit to Screen',
		    	'img' => asset('images/theme-options-images/page-banner/page-banner-big.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "page_banner_medium",
			'banner_param' => array(
		    	'title' => 'Banner Medium',
		    	'img' => asset('images/theme-options-images/page-banner/page-banner-medium.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "page_banner_small",
			'banner_param' => array(
		    	'title' => 'Banner Small',
		    	'img' => asset('images/theme-options-images/page-banner/page-banner-small.png')
		    ),
			"param"  => array()
		),
		array(
			"id"   => "page_banner_custom",
			'banner_param' => array(
		    	'title' => 'Custom Height',
		    	'img' => asset('images/theme-options-images/page-banner/page-banner-small.png')
		    ),
			"param"  => array()
		)	
	);

	return $page_banner_style;
}


/* Posts Banners
"param"  => array(
			'limit' => array(3,12),
			'category' => true,
			'type' => array('all','featured', 'most-visited', 'most-liked')
			'post_with' => array('all', 'images-only','without')
			)
limit : array(3,12) : limit select box value start from 3 and end with 12 
array(3) : limit will be 3 fix with disable input box : hint limit is fixed for this 
array(3,15,3) : limit select box values start from 3 and end with 15 with steps 3 like (3,6,9,12,15)  
*/
/* Post Banner Options */

function post_banner_options(){
	$post_banners = array(
		array(
			"id"   => "post_banner_v1",
			"post_banner_param" => array(
				"title" => 'Post Banner 1',
				"img"   => asset('images/theme-options-images/post-banner/post-slider-v1.png')
			),
			"param"  => array(
				'limit' => array(2,5),
				'category' => true,
				'type' => array('all','featured', 'most-visited', 'most-liked'),
				'post_with' => array('all', 'images-only','without')
				)
		),
		array(
			"id"   => "post_banner_v2",
			"post_banner_param" => array(
				"title" => 'Post Banner 2',
				"img"   => asset('images/theme-options-images/post-banner/post-slider-v2.png')
			),
			"param"  => array(
				'limit' => array(3,12),
				'category' => true,
				'type' => array('all','featured', 'most-visited', 'most-liked'),
				'post_with' => array('all', 'images-only','without')
				)
		),
		array(
			"id"   => "post_banner_v3",
			"post_banner_param" => array(
				"title" => 'Post Banner 3',
				"img"   => asset('images/theme-options-images/post-banner/post-slider-v3.png')
			),
			"param"  => array(
				'limit' => array(3,12),
				'category' => true,
				'type' => array('all','featured', 'most-visited', 'most-liked'),
				'post_with' => array('all', 'images-only','without')
			)    
		)
	);

	return $post_banners;
}

/* Theme Layout Options */
function theme_layout_options(){
	$theme_layouts = array(
		array(
			"id"   => "theme_layout_1",
			"img_param" => array(
				"title" => 'Full',
				"img"   => asset('images/theme-options-images/theme-layout/full-width.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "theme_layout_2",
			"img_param" => array(
				"title" => 'Box',
				"img"   => asset('images/theme-options-images/theme-layout/boxed.png')
			),
			"param"  => array()
		),
		array(
			"id"   => "theme_layout_3",
			"img_param" => array(
				"title" => 'Frame',
				"img"   => asset('images/theme-options-images/theme-layout/frame.png')
			),
			"param"  => array()
		)
	);

	return $theme_layouts;
}

/* Theme Color Background Options */
function theme_color_background_options(){
	$theme_color_background = array(
		array(
			"id"   => "bg_color_1",
			"img_param" => array(
				"title" => 'Orange',
				"img"   => asset('images/theme-options-images/bg-pattern/bg1.jpg')
			),
			"param"  => array()      
		),
		array(
			"id"   => "bg_color_2",
			"img_param" => array(
				"title" => 'Red',
				"img"   => asset('images/theme-options-images/bg-pattern/bg2.jpg')
			),
			"param"  => array()      
		),
		array(
			"id"   => "bg_color_3",
			"img_param" => array(
				"title" => 'Color Name',
				"img"   => asset('images/theme-options-images/bg-pattern/bg3.jpg')
			),
			"param"  => array()      
		),
		array(
			"id"   => "bg_color_4",
			"img_param" => array(
				"title" => 'Color Name',
				"img"   => asset('images/theme-options-images/bg-pattern/bg4.jpg')
			),
			"param"  => array()      
		),
		array(
			"id"   => "bg_color_5",
			"img_param" => array(
				"title" => 'Color Name',
				"img"   => asset('images/theme-options-images/bg-pattern/bg5.jpg')
			),
			"param"  => array()      
		),
		array(
			"id"   => "bg_color_6",
			"img_param" => array(
				"title" => 'Color Name',
				"img"   => asset('images/theme-options-images/bg-pattern/bg6.jpg')
			),
			"param"  => array()      
		)
	);

	return $theme_color_background;
}

/* Theme Image Background Options */
function theme_image_background_options(){
	$theme_image_background = array(
		array(
			"id"   => "bg_img_1",
			"img"   => asset('images/theme-options-images/bg-image/bg1.jpg'),
			"param"  => array()
		),
		array(
			"id"   => "bg_img_2",
			"img"   => asset('images/theme-options-images/bg-image/bg2.jpg'),
			"param"  => array()
		),
		array(
			"id"   => "bg_img_3",
			"img"   => asset('images/theme-options-images/bg-image/bg3.jpg'),
			"param"  => array()
		),
		array(
			"id"   => "bg_img_4",
			"img"   => asset('images/theme-options-images/bg-image/bg4.jpg'),
			"param"  => array()
		)
	);

	return $theme_image_background;
}

/* Theme Pattern Background Options */
function theme_pattern_background_options(){
	$theme_pattern_background = array(
		array(
			"id"   => "bg_pattern_1",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg1.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_2",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg2.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_3",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg3.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_4",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg4.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_5",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg5.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_6",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg6.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_7",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg7.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_8",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg8.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_9",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg9.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_10",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg10.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_11",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg11.jpg'),
			"param" => array()
		),
		array(
			"id"   => "bg_pattern_12",
			"title" => "Pattern Name",
			"img"   => asset('images/theme-options-images/bg-pattern/bg12.jpg'),
			"param" => array()
		)
	);

	return $theme_pattern_background;
}

/* Page Loader Options */
function theme_color_options(){
	$theme_color = array(
		array(
			"title" => 'Theme 1',
			"id"    => "skin-1",
			"img"   => asset('images/theme-options-images/skins/skin1.png'),
			"color" => array( '#a7d1f1', '#6d9ec4', '#ffffff', '#3f3f3f', '#666666' ),
			"param"  => array()
		),
		array(
			"title" => 'Theme 2',
			"id"   => "skin-2",
			"img"   => asset('images/theme-options-images/skins/skin2.png'),
			"color" => array( '#5f0ee1', '#decaff', '#ffffff', '#3f3f3f', '#666666' ),
			"param"  => array()
		),
		array(
			"title" => 'Theme 3',
			"id"   => "skin-3",
			"img"   => asset('images/theme-options-images/skins/skin3.png'),
			"color" => array( '#5f0ee1', '#decaff', '#ffffff', '#3f3f3f', '#666666' ),
			"param"  => array()
		),
		array(
			"title" => 'Theme 4',
			"id"   => "skin-4",
			"img"   => asset('images/theme-options-images/skins/skin4.png'),
			"color" => array( '#5f0ee1', '#decaff', '#ffffff', '#3f3f3f', '#666666' ),
			"param"  => array()
		)
	);

	return $theme_color;
}

/* Page Loader Options */
function page_loader_options(){
	$page_loader = array(
		array(
			"title" => 'Loading 1',
			"id"   => "loading1",
			"img"   => asset('images/theme-options-images/loading-images/loading1.svg'),
			"param"  => array()
		),
		array(
			"title" => 'Loading 2',
			"id"   => "loading2",
			"img"   => asset('images/theme-options-images/loading-images/loading2.svg'),
			"param"  => array()
		),
		array(
			"title" => 'Loading 3',
			"id"   => "loading3",
			"img"   => asset('images/theme-options-images/loading-images/loading3.svg'),
			"param"  => array()
		),
		array(
			"title" => 'Loading 4',
			"id"   => "loading4",
			"img"   => asset('images/theme-options-images/loading-images/loading4.svg'),
			"param"  => array()
		),
		array(
			"title" => 'Loading 5',
			"id"   => "loading5",
			"img"   => asset('images/theme-options-images/loading-images/loading5.svg'),
			"param"  => array()
		)
	);

	return $page_loader;
}

/* Sorting Options */
function sort_by_options(){
	$sort_by = array(
		'created_at__asc'  => __('Date ASC'),
		'created_at__desc'  => __('Date DESC'),
		'title__asc'  => __('Title ASC'),
		'title__desc'  => __('Title DESC'),
	);

	return $sort_by;
}

/* Button Link Target Options */
function link_target_options(){
	$link_target = array(
		'_blank' 	=>	'Opens the link in a new tab.',
		'_parent' 	=> 	'Opens the link in the parent frame.',
		'_self'		=>	'Open the link in the current frame.',
		'_top'		=>	'Opens the link in the top-most frame.'
	);
	
	return $link_target;
}

/* Advertisement Banner Size Options */
function adsence_size_options(){
	$adsence_size = array(
		'auto' => __( 'Auto' ),
		'120 x 90' => __('120 x 90'),
		'120 x 240' => __('120 x 240'),
		'120 x 600' => __('120 x 600'),
		'125 x 125' => __('125 x 125'),
		'160 x 90' => __('160 x 90'),
		'160 x 600' => __('160 x 600'),
		'180 x 90' => __('180 x 90'),
		'180 x 150' => __('180 x 150'),
		'200 x 90' => __('200 x 90'),
		'200 x 200' => __('200 x 200'),
		'234 x 60' => __('234 x 60'),
		'250 x 250' => __('250 x 250'),
		'320 x 100' => __('320 x 100'),
		'300 x 250' => __('300 x 250'),
		'300 x 600' => __('300 x 600'),
		'300 x 1050' => __('300 x 1050'),
		'320 x 50' => __('320 x 50'),
		'336 x 280' => __('336 x 280'),
		'360 x 300' => __('360 x 300'),
		'435 x 300' => __('435 x 300'),
		'468 x 15' => __('468 x 15'),
		'468 x 60' => __('468 x 60'),
		'640 x 165' => __('640 x 165'),
		'640 x 190' => __('640 x 190'),
		'640 x 300' => __('640 x 300'),
		'728 x 15' => __('728 x 15'),
		'728 x 90' => __('728 x 90'),
		'970 x 90' => __('970 x 90'),
		'970 x 250' => __('970 x 250'),
		'240 x 400' => __('240 x 400 - Regional ad sizes'),
		'250 x 360' => __('250 x 360 - Regional ad sizes'),
		'580 x 400' => __('580 x 400 - Regional ad sizes'),
		'750 x 100' => __('750 x 100 - Regional ad sizes'),
		'750 x 200' => __('750 x 200 - Regional ad sizes'),
		'750 x 300' => __('750 x 300 - Regional ad sizes'),
		'980 x 120' => __('980 x 120 - Regional ad sizes'),
		'930 x 180' => __('930 x 180 - Regional ad sizes')
	);

	return $adsence_size;
}

/* Social Link Options */
function social_link_options(){
	
	$social_links = array(
	    'facebook' => array(
	        'id' => 'facebook',
	        'title' => 'Facebook',
	    ),
	    'twitter' => array(
	        'id' => 'twitter',
	        'title' => 'Twitter',
	    ),
	    'linkedin' => array(
	        'id' => 'linkedin',
	        'title' => 'Linkedin',
	    ),
	    'instagram' => array(
	        'id' => 'instagram',
	        'title' => 'Instagram',
	    ),
	    'behance' => array(
	        'id' => 'behance',
	        'title' => 'Behance',
	    ),
	    'google' => array(
	        'id' => 'google',
	        'title' => 'Google',
	    ),
	    'skype' => array(
	        'id' => 'skype',
	        'title' => 'Skype',
	    ),
	    'pinterest' => array(
	        'id' => 'pinterest',
	        'title' => 'Pinterest',
	    ),
	    'vimeo' => array(
	        'id' => 'vimeo',
	        'title' => 'Vimeo',
	    ),
	    'youtube' => array(
	        'id' => 'youtube',
	        'title' => 'Youtube',
	    ),
	    'tumblr' => array(
	        'id' => 'tumblr',
	        'title' => 'Tumblr',
	    ),
	    'rss' => array(
	        'id' => 'rss',
	        'title' => 'Rss',
	    ),
	    'yelp' => array(
	        'id' => 'yelp',
	        'title' => 'Yelp',
	    ),
	    'tripadvisor' => array(
	        'id' => 'tripadvisor',
	        'title' => 'Tripadvisor',
	    ),
	    'blogger' => array(
	        'id' => 'blogger',
	        'title' => 'Blogger',
	    ),
	    'delicious' => array(
	        'id' => 'delicious',
	        'title' => 'Delicious',
	    ),
	    'digg' => array(
	        'id' => 'digg',
	        'title' => 'Digg',
	    ),
	    'dribbble' => array(
	        'id' => 'dribbble',
	        'title' => 'Dribbble',
	    ),
	    'flickr' => array(
	        'id' => 'flickr',
	        'title' => 'Flickr',
	    ),
	    'lastfm' => array(
	        'id' => 'lastfm',
	        'title' => 'Lastfm',
	    ),
	    'paypal' => array(
	        'id' => 'paypal',
	        'title' => 'Paypal',
	    ),
	    'reddit' => array(
	        'id' => 'reddit',
	        'title' => 'Reddit',
	    ),
	    'share' => array(
	        'id' => 'share',
	        'title' => 'Share',
	    ),
	    'soundcloud' => array(
	        'id' => 'soundcloud',
	        'title' => 'Soundcloud',
	    ),
	    'spotify' => array(
	        'id' => 'spotify',
	        'title' => 'Spotify',
	    ),
	    'stack-overflow' => array(
	        'id' => 'stack-overflow',
	        'title' => 'Stack Overflow',
	    ),
	    'steam' => array(
	        'id' => 'steam',
	        'title' => 'Steam',
	    ),
	    'stumbleupon' => array(
	        'id' => 'stumbleupon',
	        'title' => 'Stumbleupon',
	    ),
	    'telegram' => array(
	        'id' => 'telegram',
	        'title' => 'Telegram',
	    ),
	    'twitch' => array(
	        'id' => 'twitch',
	        'title' => 'Twitch',
	    ),
	    'vk' => array(
	        'id' => 'vk',
	        'title' => 'VKontakte',
	    ),
	    'windows' => array(
	        'id' => 'windows',
	        'title' => 'Windows',
	    ),
	    'wordpress' => array(
	        'id' => 'wordpress',
	        'title' => 'WordPress',
	    ),
	    'yahoo' => array(
	        'id' => 'yahoo',
	        'title' => 'Yahoo',
	    )

	);

	return $social_links;
}

/* Button Link Target Options */
function banner_type(){
	$banner_type = array(
		'image'  => __('Image Type Banner')
	);
	
	return $banner_type;
}