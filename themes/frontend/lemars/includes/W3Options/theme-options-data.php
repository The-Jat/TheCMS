<?php 

function _page_template_options(){
	
	$page_templates = array(
		'coming' => array(
			array(
				'title' => __('Comingsoon'),
				'id'   => 'coming_style_1',
				'img'   => asset('/themes/frontend/lemars/images/page-template/coming-soon.png'),
				'param'  => array()
			)
		),
		'maintenance' => array(
			array(
				'title' => __('Maintenance'),
				'id'   	=> 'maintenance_style_1',
				'img'   => asset('/themes/frontend/lemars/images/page-template/site-down-for-maintain.png'),
				'param'  => array()
			)
		),
		'error' => array(
			array(
				'title' => __('Error'),
				'id'   => 'error_style_1',
				'img'   => asset('/themes/frontend/lemars/images/page-template/error-404.png'),
				'param'  => array()
			)
		)
	);
	return $page_templates;
}

function _post_layouts_options(){

	$post_layouts = array(
		array(
			'id'   => 'post_slider_2',
			'layout_param' => array(
		    	'title' => __('Slider Post 2'),
		    	'img' => asset('/themes/frontend/lemars/images/post-layout/slider-post-2.png')
		    ),
			'param'  => array()
		),
	);

	return $post_layouts;
}

function _header_style_options(){
	$header_styles = array(
		array(
			'id'   => 'header_1',
			'img_param' => array(
				'title' => __('Style - Normal'),
				'img'   => asset('/themes/frontend/lemars/images/header/header-1.png')
			),
			'param'  => array(
				'class' => '',
				'social_link' => 1,
				'search' => 1,
				'call_to_action_button' => 0,
				'social_links' => 6,
				'top_bar' => 0,
			)
		),
		array(
			'id'   => 'header_2',
			'img_param' => array(
				'title' => __('Style - Center Logo'),
				'img'   => asset('/themes/frontend/lemars/images/header/header-2.png')
			),
			'param'  => array(
				'class' => '',
				'social_link' => 1,
				'search' => 1,
				'call_to_action_button' => 1,
				'social_links' => 6,
				'top_bar' => 0,
			)
		),
		array(
			'id'   => 'header_3',
			'img_param' => array(
				'title' => __('Style - Transparent'),
				'img'   => asset('/themes/frontend/lemars/images/header/header-3.png')
			),
			'param'  => array(
				'class' => '',
				'social_link' => 1,
				'search' => 1,
				'call_to_action_button' => 1,
				'social_links' => 6,
				'top_bar' => 0,
			)
		),
	);

	return $header_styles;
}

function _footer_style_options(){
	$footer_styles = array(
		array(
			'id'   => 'footer_template_1',
			'img_param' => array(
				'title' => __('Style - Normal'),
				'img'   => asset('/themes/frontend/lemars/images/footer/footer-1.png'),
			),
			'param'  => array(
				'social_link' => 1,
				'copyright'	=> 1,
				'powered_by'	=> 0,
				'sections'	=> 3,
				'bg_image'	=> 0
			)
		),
	);

	return $footer_styles;
}


?>