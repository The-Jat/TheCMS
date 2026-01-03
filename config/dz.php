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

    'name' => env('APP_NAME', 'W3CMS Laravel'),


    'public' => [
	    'favicon' => 'media/img/logo/favicon.ico',
	    'fonts' => [
			'google' => [
				'families' => [
					'Poppins:300,400,500,600,700'
				]
			]
		],
	    'global' => [
	    	'css' => [
		    	'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
		    	'vendor/sweetalert2/dist/sweetalert2.min.css',
		    	'css/style.css',
		    	'css/custom.min.css',
		    ],
		    'js' => [
		    	'top'=>[
					'vendor/global/global.min.js',
					'vendor/bootstrap-select/dist/js/bootstrap-select.min.js',
					'vendor/sweetalert2/dist/sweetalert2.min.js',
				],
				'bottom'=>[
					'js/deznav-init-min.js',
					'js/custom-min.js',
					'js/w3cms_custom-min.js',
					'js/rdxjs-min.js',
				],
		    ],
	    ],
	    'pagelevel' => [
			'css' => [
				'PermissionsController_index' => [
					'css/acl-custom.min.css',
				],
				'PermissionsController_role_permissions' => [
					'css/acl-custom.min.css',
				],
				'PermissionsController_roles_permissions' => [
					'css/acl-custom.min.css',
				],
				'PermissionsController_user_permissions' => [
					'css/acl-custom.min.css',
				],
				'PermissionsController_manage_user_permissions' => [
					'css/acl-custom.min.css',
				],
				'PermissionsController_temp_permissions' => [
					'vendor/jstree/dist/themes/default/style.min.css',
				],

				'DashboardController_dashboard' => [
					'vendor/jqvmap/css/jqvmap.min.css',
		    		'vendor/owl-carousel/owl.carousel.css',
					'vendor/chartist/css/chartist.min.css',
				],
				'UsersController_index' => [
				],
				'UsersController_create' => [
				],
				'UsersController_edit' => [
				],

				'RolesController_index' => [
				],
				'RolesController_create' => [
				],
				'RolesController_edit' => [
				],

				'PagesController_admin_index' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'PagesController_admin_create' => [
					'css/jquery-ui.css',
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
					'vendor/nouislider/nouislider.min.css',
				],
				'PagesController_admin_edit' => [
					'css/jquery-ui.css',
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
					'vendor/nouislider/nouislider.min.css',
				],

				'BlogsController_index' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'BlogsController_admin_index' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'BlogsController_admin_create' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'css/bootstrap-tagsinput.css',
					'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
					'vendor/nouislider/nouislider.min.css',
				],
				'BlogsController_admin_edit' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'css/bootstrap-tagsinput.css',
					'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
					'vendor/nouislider/nouislider.min.css',
				],

				'BlogCategoriesController_admin_index' => [
				],
				'BlogCategoriesController_admin_create' => [
				],
				'BlogCategoriesController_admin_edit' => [
				],

				'MenusController_admin_index' => [
					'vendor/nestable2/css/jquery.nestable.min.css'
				],
				'MenusController_admin_create' => [
				],
				'MenusController_admin_edit' => [
				],

				'MenuItemsController_admin_index' => [
				],
				'MenuItemsController_admin_create' => [
				],
				'MenuItemsController_admin_edit' => [
				],

				'ConfigurationsController_admin_prefix' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],

				'NotificationsController_index' => [
				],
				'NotificationsController_create' => [
				],
				'NotificationsController_edit' => [
				],
				'NotificationsController_edit_template' => [
				],
				'NotificationsController_edit_email_template' => [
				],
				'NotificationsController_edit_web_template' => [
				],
				'NotificationsController_edit_sms_template' => [
				],

				'W3CPTController_index' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'W3CPTController_index_taxo' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'W3CPTController_trash_list' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'W3CPTController_trash_taxo_list' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'W3OptionsController_theme_options' => [
					'css/jquery-ui.css',
					'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'vendor/nouislider/nouislider.min.css',
				],
				'WidgetsController_create' => [
					'css/jquery-ui.css',
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'vendor/jquery-asColorPicker/css/asColorPicker.min.css',
					'vendor/nouislider/nouislider.min.css',

				],

			],
		    'js' => [
				'PermissionsController_index' => [
				],
				'PermissionsController_role_permissions' => [
				],
				'PermissionsController_roles_permissions' => [
				],
				'PermissionsController_user_permissions' => [
				],
				'PermissionsController_manage_user_permissions' => [
				],
				'PermissionsController_temp_permissions' => [
					'vendor/jstree/dist/jstree.min.js',
				],

				'DashboardController_dashboard' => [
				    'vendor/chart.js/Chart.bundle.min.js',
				    'vendor/peity/jquery.peity.min.js',
				    'vendor/apexchart/apexchart.js',
				    'js/dashboard/dashboard-min.js',
				    '/vendor/owl-carousel/owl.carousel.js',
				],
				'UsersController_index' => [
				],
				'UsersController_create' => [
					'js/magic_editor-min.js',
				],
				'UsersController_edit' => [
					'js/magic_editor-min.js',
				],
				'RolesController_index' => [
				],
				'RolesController_create' => [
				],
				'RolesController_edit' => [
				],

				'PagesController_admin_index' => [
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],
				'PagesController_admin_create' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'vendor/jquery-asColor/jquery-asColor.min.js',
					'vendor/jquery-asGradient/jquery-asGradient.min.js',
					'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
					'vendor/nouislider/nouislider.min.js',
					'js/pages-min.js',
					'js/jquery-ui.js',
					'js/w3options.min.js',
					'js/magic_editor-min.js',
				],
				'PagesController_admin_edit' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'vendor/jquery-asColor/jquery-asColor.min.js',
					'vendor/jquery-asGradient/jquery-asGradient.min.js',
					'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
					'vendor/nouislider/nouislider.min.js',
					'js/pages-min.js',
					'js/jquery-ui.js',
					'js/w3options.min.js',
					'js/magic_editor-min.js',
				],

				'BlogsController_admin_index' => [
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],
				'BlogsController_admin_create' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
					'js/bootstrap-tagsinput.min.js',
					'vendor/jquery-asColor/jquery-asColor.min.js',
					'vendor/jquery-asGradient/jquery-asGradient.min.js',
					'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
					'vendor/nouislider/nouislider.min.js',
					'js/jquery-ui.js',
					'js/w3options.min.js',
					'js/magic_editor-min.js',
				],
				'BlogsController_admin_edit' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'vendor/jquery-asColor/jquery-asColor.min.js',
					'vendor/jquery-asGradient/jquery-asGradient.min.js',
					'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
					'vendor/nouislider/nouislider.min.js',
					'js/blogs-min.js',
					'js/bootstrap-tagsinput.min.js',
					'js/jquery-ui.js',
					'js/w3options.min.js',
					'js/magic_editor-min.js',
				],

				'BlogCategoriesController_admin_index' => [
				],
				'BlogCategoriesController_admin_create' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],
				'BlogCategoriesController_admin_edit' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'BlogTagsController_admin_create' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'BlogCategoriesController_list' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'BlogTagsController_list' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'MenusController_admin_index' => [
					'vendor/nestable2/js/jquery.nestable.min.js',
					'js/menu-min.js',
				],
				'MenusController_admin_create' => [
				],
				'MenusController_admin_edit' => [
				],

				'MenuItemsController_admin_index' => [
				],
				'MenuItemsController_admin_create' => [
				],
				'MenuItemsController_admin_edit' => [
				],

				'ConfigurationsController_admin_prefix' => [
					'vendor/moment/moment.min.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],

				'NotificationsController_index' => [
				],
				'NotificationsController_create' => [
					'vendor/ckeditor/ckeditor.js',
				],
				'NotificationsController_edit' => [
					'vendor/ckeditor/ckeditor.js',
				],
				'NotificationsController_settings' => [
				],

				'NotificationsController_edit_template' => [
					'vendor/ckeditor/ckeditor.js',
				],
				'NotificationsController_edit_email_template' => [
					'vendor/ckeditor/ckeditor.js',
				],
				'NotificationsController_edit_web_template' => [
					'vendor/ckeditor/ckeditor.js',
				],
				'NotificationsController_edit_sms_template' => [
					'vendor/ckeditor/ckeditor.js',
				],

				'W3CPTController_index' => [
					'vendor/moment/moment.min.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],
				'W3CPTController_index_taxo' => [
					'vendor/moment/moment.min.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],
				'W3CPTController_trash_list' => [
					'vendor/moment/moment.min.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],
				'W3CPTController_trash_taxo_list' => [
					'vendor/moment/moment.min.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],
				'W3OptionsController_theme_options' => [
					'vendor/moment/moment.min.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'vendor/jquery-asColor/jquery-asColor.min.js',
					'vendor/jquery-asGradient/jquery-asGradient.min.js',
					'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
					'vendor/nouislider/nouislider.min.js',
					'vendor/ckeditor/ckeditor.js',
					'js/jquery-ui.js',
					'js/w3options.min.js',
				],
				'WidgetsController_create' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'vendor/jquery-asColor/jquery-asColor.min.js',
					'vendor/jquery-asGradient/jquery-asGradient.min.js',
					'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
					'vendor/nouislider/nouislider.min.js',
					'js/pages-min.js',
					'js/jquery-ui.js',
					'js/magic_editor-min.js',
					'js/w3options.min.js',
				],
				'WidgetsController_index' => [
					'js/jquery-slug-min.js',
					'js/pages-min.js',
					'js/jquery-ui.js',
					'js/w3options.min.js',

				],
				'WidgetsController_edit' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'vendor/jquery-asColor/jquery-asColor.min.js',
					'vendor/jquery-asGradient/jquery-asGradient.min.js',
					'vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
					'vendor/nouislider/nouislider.min.js',
					'js/pages-min.js',
					'js/jquery-ui.js',
					'js/magic_editor-min.js',
					'js/w3options.min.js',

				]

		    ]
   		],
	]
];
