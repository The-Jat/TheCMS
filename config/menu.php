<?php

return [
    'name'              => 'Menu',
    'slug'              => 'menu',
    'route_prefix'      => 'menus',

    'ScreenOption'  => array(
        'Pages'                 => array('visibility' => true),
        'Blogs'                 => array('visibility' => false),
        'CustomLinks'           => array('visibility' => true),
        'Categories'            => array('visibility' => false),
        'Tags'                  => array('visibility' => false),
        'LinkTarget'            => array('visibility' => false),
        'TitleAttribute'        => array('visibility' => false),
        'CssClasses'            => array('visibility' => false),
        'Description'           => array('visibility' => false),
    ),

     'menu_location' => array(
        'primary' => array(
            'title' => 'Desktop Horizontal Menu',
            'menu' => ''
        ),
        'expanded' => array(
            'title' => 'Desktop Expanded Menu',
            'menu' => ''
        ),
        'mobile' => array(
            'title' => 'Mobile Menu',
            'menu' => ''
        ),
        'footer' => array(
            'title' => 'Footer Menu',
            'menu' => '',
        ),
        'social' => array(
            'title' => 'Social Menu',
            'menu' => ''
        ),
    ),

    'permalink_structure' => array(
        '%year%',
        '%month%',
        '%day%',
        '%hour%',
        '%minute%',
        '%second%',
        '%slug%',
        '%category%',
        '%author%',
        '/archives/%post_id%',
    ),

    'permalink_structure_rewritecode' => array(
        '{year?}',
        '{month?}',
        '{day?}',
        '{hour?}',
        '{minute?}',
        '{second?}',
        '{slug?}',
        '{category?}',
        '{author?}',
        '/archives/{post_id?}',
    ),

    'Site' => array(
        'logo' => 'logo-full-white.png',
        'logo-dark' => 'logo-full-black.png',
    )

];
