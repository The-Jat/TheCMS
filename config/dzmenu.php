<?php
    
return [

    /*
        |--------------------------------------------------------------------------
        | Application Name
        |--------------------------------------------------------------------------
        |
        | This value is the name of your application. This value is used when the
        | framework needs to place the application's name in a notification or
        | any other location as required by the application or its packages.
        |
    */
    'System' => [

    	'Users' => [
    		'index',
    		'create',
    		'edit'
    	],
    	'Roles' => [
    		'index',
    		'create',
    		'edit'
    	],
    	'Permissions' => [
    		'index',
    		'role_permissions',
    		'roles_permissions',
    		'user_permissions',
    		'manage_user_permissions',
    		'temp_permissions'
    	],
    	'Configurations' => [
    		'admin_index',
    		'admin_prefix',
    		'admin_view',
    		'admin_add',
    		'admin_edit',
    	],
		'Module' => [
			'system',
		],
		'Countries' => [
			'index',
    		'create',
    		'edit'
		],
		'States' => [
			'index',
    		'create',
    		'edit'
		],
		'Cities' => [
			'index',
    		'create',
    		'edit'
		],

    ],

    'Page' => [
    	'Pages' => [
    		'admin_index',
    		'admin_create',
    		'admin_edit',
    	],
    ],
    
    'Blog' => [
    	'Blogs' => [
    		'admin_index',
    		'admin_create',
    		'admin_edit',
    	],
    	'BlogCategories' => [
    		'list',
    		'admin_index',
    		'admin_create',
    		'admin_edit',
    	],
    ],
    
    'Menu' => [
    	'Menus' => [
    		'admin_index',
    		'admin_create',
    		'admin_edit',
    	],
    	'MenuItems' => [
    		'admin_index',
    		'admin_create',
    		'admin_edit',
    	],
    ],

];
