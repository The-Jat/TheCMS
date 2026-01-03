<?php

namespace Themes\frontend\lemars\includes\W3Options;
use Modules\W3Options\OptionsClass\ThemeOptionsClass;
use App\Helper\DzHelper;


if (!class_exists('PageOptionsClass'))
{
    class PageOptionsClass
    {
        public $args = array();
        public $sections = array();
        public $theme;

        /** Option Variable Declaration **/
        public $header_style_options;
        public $footer_style_options;
        public $sidebar_layout_options;
        public $page_banner_options;
        public $social_link_options;
        public $banner_type;
        /** Option Variable Declaration End **/

        function __construct() 
        {
            

            /** Option Variable assigning values **/
            $this->page_layout_options =  get_theme_layout_options();
            $this->page_banner_layout_options = get_page_banner_layout_options();
            $this->page_banner_options = get_page_banner_options();
            $this->banner_type = banner_type();
            $this->page_color_background_options =  get_theme_color_background_options();
            $this->page_image_background_options =  get_theme_image_background_options();
            $this->page_pattern_background_options =  get_theme_pattern_background_options();
            $this->header_style_options = get_header_style_options();
            $this->sidebar_layout_options = get_sidebar_layout_options();
            $this->post_banner_options = get_post_banner_options();
            $this->footer_style_options = get_footer_style_options();
            /** End Option Variable assigning values **/
            
            /* Just for demo purposes. Not needed per say. */
            $themeArr = explode('/', config('Theme.select_theme'));
            $this->theme = $themeArr[1];


            /* Create the sections and fields */
            $this->setSections();

            /* default theme options */
            if (!isset($this->args['opt_name']))
            { 
                return;
            }
        }

        /**
         * All the possible sections.
         */
        function setSections()
        {
            $this->sections[] = array(
                'title'  => __( 'Page Header' ),
                'desc'   => __( 'Header settings for the page.' ),
                'icon'   => 'fa fa-window-maximize',
                'fields' => array(
                    array(
                        'id' => 'page_header_setting',
                        'type' => 'button_set',
                        'title' => __('Page Header Settings') ,
                        'options' => array(
                            'theme_default' => __('Theme Default') ,
                            'custom' => __('Custom Setting')
                        ) ,
                        'default' => 'theme_default',
                    ),
                    array(
                        'id'           => 'page_header_style',
                        'type'         => 'image_select',
                        'title'        => __( 'Layout' ),
                        'subtitle'     => __( 'Select a layout for header.' ),
                        'options'      => $this->header_style_options,
                        'default'      => config('ThemeOptions.header_style','header_1'),
                        'depend_on' => array(
                            'page_header_setting' => array('operator' => '==',"value" => 'custom')
                        )
                    ),
                    array(
                        'id'       => 'page_header_color_mode',
                        'type'     => 'button_set',
                        'title'    => __('Header Color Mode'),
                        'subtitle' => __('Change the Header color.'),
                        'options'  => array(
                            'light'  => __('Light'),
                            'dark'  => __('Dark'),
                        ),
                        'default'  => 'light',
                        'depend_on' => array(
                            'page_header_style' => array('operator' => '==',"value" => 'header_3')
                        ),
                    )
                )
            );

            $this->sections[] = array(
                'title'  => __( 'Page Banner' ),
                'desc'   => __( 'Settings for page banner.' ),
                'icon'   => 'fas fa-tv',
                'fields' => array(
                    array(
                        'id'       => 'page_banner_setting',
                        'type'     => 'button_set',
                        'title'    => __('Page Banner Settings'),
                        'options'      => array(
                            'theme_default' => __('Theme Default'),
                            'custom'  => __('Custom Setting')
                        ),
                        'default'  => 'theme_default',
                    ),
                    array(
                        'id'       => 'page_banner_on',
                        'type'     => 'switch',
                        'title'    => __('Page Banner'),
                        'on'       => __('Enabled'),
                        'off'      => __('Disabled'),
                        'default'  => config('ThemeOptions.page_general_banner_on'),
                        'depend_on' => array(
                            'page_banner_setting' => array('operator' => '==',"value" => 'custom')
                        )
                    ),
                    array(
                        'id'       => 'page_banner_height',
                        'type'     => 'image_select',
                        'title'    => __('Page Banner Height'),
                        'subtitle' => __('Choose the height for all tag page banner. Default : Big Banner'),
                        'options'  => $this->page_banner_options,
                        'height'   => '20',
                        'default'  => config('ThemeOptions.page_general_banner_height'),
                        'depend_on' => array(
                            'page_banner_on' => array('operator' => '==',"value" => 1)
                        )
                    ),
                    array(
                        'id' => 'page_banner_custom_height',
                        'type' => 'slider',
                        'title' => __('Page Banner Custom Height'),
                        'desc' => __('Hight description. Min: 100, max: 800'),
                        "default" => '',
                        "min" => 100,
                        "max" => 800,
                        'display_value' => 'text',
                        'depend_on' => array(
                            'page_banner_height' => array('operator' => '==',"value" => 'page_banner_custom')
                        )
                    ),
                    array(
                        'id'       => 'page_banner',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => __('Page Banner Image'),
                        'subtitle' => __('Enter page banner image. It will work as default banner image for all pages'),
                        'desc' => __('Upload banner image.'),
                        'depend_on' => array(
                            'page_banner_on' => array('operator' => '==',"value" => 1)
                        )
                    ),
                    array(
                        'id' => 'page_breadcrumb',
                        'type' => 'switch',
                        'title' => __('Breadcrumb Area') ,
                        'subtitle' => __('Click on the tab to Enable / Disable the website breadcrumb.') ,
                        'desc' => __('This setting affects only on this page.') ,
                        'on' => __('Enabled') ,
                        'off' => __('Disabled') ,
                        'default' => config('ThemeOptions.show_breadcrumb') ,
                        'depend_on' => array(
                            'page_banner_on' => array('operator' => '==',"value" => 1)
                        )
                    ),
                    array(
                        'id'       => 'page_banner_hide',
                        'type'     => 'checkbox',
                        'title'    => __('Don`t use banner image for this page'),
                        'default'  => '0',
                        'desc'     => __('Check if you don`t want to use banner image'),
                        'depend_on' => array(
                            'page_banner_on' => array('operator' => '==',"value" => 1)
                        ),
                        'hint' => array(
                            'content' => 'If we don`t have suitable image then we can hide current or default banner images and show only banner container with theme default color.'
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'title'  => __( 'Page Footer' ),
                'desc'   => __( 'Settings for footer area.' ),
                'icon'   => 'fas fa-bars',
                'fields' => array(
                    array(
                        'id' => 'page_footer_setting',
                        'type' => 'button_set',
                        'title' => __('Page Footer Settings') ,
                        'options' => array(
                            'theme_default' => __('Theme Default') ,
                            'custom' => __('Custom Setting')
                        ) ,
                        'default' => 'theme_default',
                    ),
                    array(
                        'id'      => 'page_footer_on',
                        'type'    => 'switch',
                        'title'   => __('Footer'),
                        'on'      => __('Enabled'),
                        'off'     => __('Disabled'),
                        'default' => config('ThemeOptions.footer_on' ),
                        'depend_on' => array(
                            'page_footer_setting' => array('operator' => '==',"value" => 'custom')
                        ),
                    ),
                    array(
                        'id'       => 'page_footer_style',
                        'type'     => 'image_select',
                        'height'   => '80',
                        'title'    => __('Footer Template'),
                        'subtitle' => __('Choose a template for footer.'),
                        'options'  => $this->footer_style_options,
                        'default'  => config('ThemeOptions.footer_style' ),
                        'depend_on' => array(
                            'page_footer_on' => array('operator' => '==',"value" => true)
                        ),
                    )
                )
            );

            $this->sections[] = array(
                'title'  => __( 'Page Sidebar' ),
                'desc'   => __( 'Settings for sidebar area.' ),
                'icon'   => 'fas fa-server',
                'fields' => array(
                    array(
                        'id'       => 'page_show_sidebar',
                        'type'     => 'switch',
                        'title'    => __('Sidebar'),
                        'on'       => __('Enabled'),
                        'off'       => __('Disabled'),
                        'default'  => config( 'Theme-Options.general_page_sidebar_on' )
                    ),
                    array(
                        'id'       => 'page_sidebar_layout',
                        'type'     => 'image_select',
                        'title'    => __('Sidebar Layout'),
                        'subtitle' => __('Choose the layout for page. (Default : Right Side).'),
                        'options'  => $this->sidebar_layout_options,
                        'default'  => 'sidebar_right',
                        'depend_on' => array(
                            'page_show_sidebar' => array('operator' => '==',"value" => '1')
                        )
                    ),
                    array(
                        'id' => 'page_sidebar',
                        'type' => 'select',
                        'options' => DzHelper::getSidebarsList(),
                        'title' => __('Select Sidebar') ,
                        'subtitle' => __('Select sidebar.') ,
                        'default' => 'default-sidebar',
                        'depend_on' => array(
                            'page_sidebar_layout' => array('operator' => '!=',"value" => 'sidebar_full')
                        )
                    ) ,
                )
            );

        }

    }

}
