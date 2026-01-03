<?php

namespace Themes\frontend\lemars\includes\W3Options;
use Modules\W3Options\OptionsClass\ThemeOptionsClass;
use App\Helper\DzHelper;
use App\Http\Traits\DzMeSettings;


if (!class_exists('BlogOptionsClass'))
{
    class BlogOptionsClass extends ThemeOptionsClass
    {
        use DzMeSettings;
        public $args = array();
        public $sections = array();
        public $theme;

        /** Option Variable Declaration **/
        public $header_style_options;
        public $post_layouts_options;
        public $sidebar_layout_options;
        public $banner_type;
        public $page_banner_options;
        public $page_banner_layout_options;
        public $footer_style_options;
        /** Option Variable Declaration End **/

        function __construct()
        {

            $this->header_style_options = get_header_style_options();
            $this->post_layouts_options = get_post_layouts_options();
            $this->sidebar_layout_options = get_sidebar_layout_options();
            $this->banner_type = banner_type();
            $this->page_banner_options = get_page_banner_options();
            $this->page_banner_layout_options = get_page_banner_layout_options();
            $this->footer_style_options = get_footer_style_options();

            /* Just for demo purposes. Not needed per say. */
            $themeArr = explode('/', config('Theme.select_theme'));
            $this->theme = $themeArr[1];
            
            /* Create the sections and fields */
            $this->setBlogSections();

        }

        public function setBlogSections(){
            

            $this->addSections('post', array(
                'title' => __('General') ,
                'icon' => 'fas fa-newspaper',
                'fields' => array(
                    array(
                        'id' => 'featured_post',
                        'type' => 'checkbox',
                        'title' => __('Featured Post?') ,
                        'desc' => __('Check if you want to make this post as featured post') ,
                        'default' => ''
                    ) ,
                    array(
                        'id' => 'post_layout',
                        'type' => 'image_select',
                        'title' => __('Layout') ,
                        'subtitle' => __('Select a template.') ,
                        'desc' => __('Click on the template icon to select.') ,
                        'options' => $this->post_layouts_options,
                        'default' => config('ThemeOptions.post_general_layout') ,
                        'hint' => array(
                            'title' => __('How it Works?') ,
                            'content' => __('Once you select the template from here, the template will apply for this page only.')
                        )
                    ),
                    array(
                        'id' => 'post_type_gallery1',
                        'type' => 'gallery',
                        'title' => __('Gallery') ,
                        'subtitle' => __('Select the gallery images') ,
                        'desc' => __('For better layout, Image size width greater than 1000 and height greater than 600') ,
                        'default' => '',
                        'depend_on' => array(
                            'post_layout' => array('operator' => '==',"value" => 'post_slider_1')
                        ),
                    ) ,
                    array(
                        'id' => 'post_type_gallery2',
                        'type' => 'gallery',
                        'title' => __('Gallery') ,
                        'subtitle' => __('Select the gallery images') ,
                        'desc' => __('For better layout, Image size width greater than 1000 and height greater than 600') ,
                        'default' => '',
                        'depend_on' => array(
                            'post_layout' => array('operator' => '==',"value" => 'post_slider_2')
                        ),
                    ) ,
                    array(
                        'id' => 'post_type_link',
                        'type' => 'text',
                        'title' => __('External Link') ,
                        'default' => '',
                        'validate' => 'url',
                        'depend_on' => array(
                            'post_layout' => array('operator' => '==',"value" => 'post_link')
                        ),
                    ) ,
                    array(
                        'id' => 'post_type_quote_author',
                        'type' => 'text',
                        'title' => __('Author Name') ,
                        'default' => __('Author Name') ,
                        'depend_on' => array(
                            'post_layout' => array('operator' => '==',"value" => 'post_quote')
                        ),
                    ) ,
                    array(
                        'id' => 'post_type_quote_text',
                        'type' => 'textarea',
                        'title' => __('Quote Text') ,
                        'default' => __('Quote Text') ,
                        'depend_on' => array(
                            'post_layout' => array('operator' => '==',"value" => 'post_quote')
                        ),
                    ) ,
                    array(
                        'id' => 'post_type_audio',
                        'type' => 'text',
                        'title' => __('Sound Cloud Link') ,
                        'default' => '',
                        'validate' => 'url',
                        'depend_on' => array(
                            'post_layout' => array('operator' => '==',"value" => 'post_audio')
                        ),
                    ) ,
                    array(
                        'id' => 'post_type_video',
                        'type' => 'text',
                        'title' => __('Video Link') ,
                        'default' => '',
                        'validate' => 'url',
                        'depend_on' => array(
                            'post_layout' => array('operator' => '==',"value" => 'post_video')
                        ),
                    ) ,
                    array(
                        'id' => 'featured_image',
                        'type' => 'switch',
                        'title' => __('Show Feature Image') ,
                        'on' => __('Enabled') ,
                        'off' => __('Disabled') ,
                        'default' => 1
                    ) ,
                    array(
                        'id' => 'post_pagination',
                        'type' => 'switch',
                        'title' => __('Show Post Pagination') ,
                        'on' => __('Enabled') ,
                        'off' => __('Disabled') ,
                        'default' => 0
                    ) ,
                    array(
                        'id' => 'post_page_background',
                        'type' => 'button_set',
                        'title' => __('Page Body Color'),
                        'options' => array(
                            'light' => __('Light'),
                            'dark' => __('Dark'),
                        ) ,
                        'default' => 'light',
                    ),
                )
            ));

            $this->addSections('post', array(
                'title' => __('Post Header') ,
                'desc' => __('Header settings for the post.') ,
                'icon' => 'fa fa-window-maximize',
                'fields' => array(
                    array(
                        'id' => 'post_header_setting',
                        'type' => 'button_set',
                        'title' => __('Post Header Settings') ,
                        'options' => array(
                            'theme_default' => __('Theme Default') ,
                            'custom' => __('Custom Setting')
                        ) ,
                        'default' => 'theme_default',
                    ),
                    array(
                        'id' => 'post_header_style',
                        'type' => 'image_select',
                        'title' => __('Header Style') ,
                        'subtitle' => __('Choose header style. White header is set as default header for this post.') ,
                        'options' => $this->header_style_options,
                        'default' => config('ThemeOptions.header_style','header_1') ,
                        'force_output' => true,
                        'depend_on' => array(
                            'post_header_setting' => array('operator' => '==',"value" => 'custom')
                        ),
                    ) ,
                )
            ));

            $this->addSections('post', array(
                'title' => __('Post Footer') ,
                'desc' => __('Settings for footer area.') ,
                'icon' => 'fas fa-home',
                'fields' => array(
                    array(
                        'id' => 'post_footer_setting',
                        'type' => 'button_set',
                        'title' => __('Post Footer Settings') ,
                        'options' => array(
                            'theme_default' => __('Theme Default') ,
                            'custom' => __('Custom Setting')
                        ) ,
                        'default' => 'theme_default',
                    ),
                    array(
                        'id'      => 'post_footer_on',
                        'type'    => 'switch',
                        'title'   => __('Footer'),
                        'on'      => __('Enabled'),
                        'off'     => __('Disabled'),
                        'default' => config('ThemeOptions.footer_on' ),
                        'depend_on' => array(
                            'post_footer_setting' => array('operator' => '==',"value" => 'custom')
                        ),
                    ),
                    array(
                        'id'       => 'post_footer_style',
                        'type'     => 'image_select',
                        'height'   => '80',
                        'title'    => __('Footer Template'),
                        'subtitle' => __('Choose a template for footer.'),
                        'options'  => $this->footer_style_options,
                        'default'  => config('ThemeOptions.footer_style' ),
                        'depend_on' => array(
                            'post_footer_on' => array('operator' => '==',"value" => 1)
                        ),
                    )
                )
            ));

            $this->addSections('post', array(
                'title' => __('Post Sidebar') ,
                'desc' => __('Sidebar settings for the Post.') ,
                'icon' => 'fas fa-server',
                'fields' => array(
                    array(
                        'id' => 'post_show_sidebar',
                        'type' => 'switch',
                        'title' => __('Sidebar') ,
                        'desc' => __('Show / hide sidebar from this posts detail page.') ,
                        'on' => __('Enabled') ,
                        'off' => __('Disabled') ,
                        'default' => config('ThemeOptions.show_sidebar') ,
                    ) ,
                    array(
                        'id' => 'post_sidebar_layout',
                        'type' => 'image_select',
                        'title' => __('Sidebar Layout') ,
                        'subtitle' => __('Choose the layout for page. (Default : Right Side).') ,
                        'options' => $this->sidebar_layout_options,
                        'default' => 'sidebar_right',
                        'depend_on' => array(
                            'post_show_sidebar' => array('operator' => '==',"value" => '1')
                        ),
                    ) ,
                    array(
                        'id' => 'post_sidebar',
                        'type' => 'select',
                        'options' => DzHelper::getSidebarsList(),
                        'title' => __('Select Sidebar') ,
                        'subtitle' => __('Select sidebar.') ,
                        'default' => 'dz_default_sidebar',
                        'depend_on' => array(
                            'post_sidebar_layout' => array('operator' => '!=',"value" => 'sidebar_full')
                        ),
                    ) ,
                )
            ));

            foreach(DzHelper::get_post_types() as $cpt) {
                $cpt_name = \Str::singular($cpt->title);
                $cpt_id = $cpt->slug;

                $this->addSections($cpt_id, array(
                    'title' => __('General') ,
                    'desc' => __('General settings for the '.$cpt_name.'.') ,
                    'icon' => 'fas fa-newspaper',
                    'fields' => array(
                        array(
                            'id'      => 'cpt_' . $cpt_id . '_featured_post',
                            'type'    => 'checkbox',
                            'title'   => __('Featured Post?'),
                            'desc' => __('Check if you want to make this post as featured post'),
                            'default' => ''
                        ),
                        array(
                            'id' => 'cpt_' . $cpt_id . '_featured_image',
                            'type' => 'switch',
                            'title' => __('Show Feature Image') ,
                            'on' => __('Enabled') ,
                            'off' => __('Disabled') ,
                            'default' => 1
                        ) ,
                        array(
                            'id' => 'cpt_' . $cpt_id . '_editor_type',
                            'type' => 'button_set',
                            'title' => __('Editor Type'),
                            'options' => array(
                                'text_editor' => __('Text Editor') ,
                                'magic_editor' => __('Magic Editor')
                            ) ,
                            'default' => 'text_editor',
                        ),
                        array(
                            'id' => 'cpt_' . $cpt_id . '_page_background',
                            'type' => 'button_set',
                            'title' => __('Page Body Color'),
                            'options' => array(
                                'light' => __('Light'),
                                'dark' => __('Dark'),
                            ) ,
                            'default' => 'light',
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_layout',
                            'type'     => 'image_select',
                            'height'    => '100',
                            'title'    => __(ucfirst($cpt_name).' Layout'),
                            'subtitle' => __('Choose ')
                            . strtolower($cpt_name) .
                            __(' detail page layout style.'),
                            'desc' =>
                                __('Click on the image icon to choose ')
                                . strtolower($cpt_name) .
                                __(' detail page layout.'),
                            'options'  => get_cpt_layouts_options($cpt_id),
                            'default'  => config('ThemeOptions.cpt_' . $cpt_id . '_layout','style_1'),
                            'hint'     => array(
                                'title'   => __('How it Works?'),
                                'content' =>
                                    __('1. This layout is applicable for single ') .
                                    __( strtolower($cpt_name)) .
                                    __(' page (detail page).')
                            )
                        ),
                    )
                ));

                $this->addSections($cpt_id, array(
                    'title' => __($cpt_name.' Header') ,
                    'desc' => __('Header settings for the '.$cpt_name.'.') ,
                    'icon' => 'fa fa-window-maximize',
                    'fields' => array(
                        array(
                            'id' => 'cpt_'.$cpt_id.'_header_setting',
                            'type' => 'button_set',
                            'title' => __('Header Settings') ,
                            'options' => array(
                                'theme_default' => __('Theme Default') ,
                                'custom' => __('Custom Setting')
                            ) ,
                            'default' => 'theme_default',
                        ),
                        array(
                            'id' => 'cpt_'.$cpt_id.'_header_style',
                            'type' => 'image_select',
                            'title' => __('Header Style') ,
                            'subtitle' => __('Choose header style. White header is set as default header for this '.$cpt_name.'.') ,
                            'options' => $this->header_style_options,
                            'default' => config('ThemeOptions.header_style','header_1') ,
                            'depend_on' => array(
                                'cpt_'.$cpt_id.'_header_setting' => array('operator' => '==',"value" => 'custom')
                            ),
                        ) ,
                        array(
                            'id'       => 'cpt_'.$cpt_id.'_header_color_mode',
                            'type'     => 'button_set',
                            'title'    => __('Header Color Mode'),
                            'subtitle' => __('Change the Header color.'),
                            'options'  => array(
                                'light'  => __('Light'),
                                'dark'  => __('Dark'),
                            ),
                            'default'  => 'light',
                            'depend_on' => array(
                                'cpt_'.$cpt_id.'_header_style' => array('operator' => '==',"value" => 'header_3')
                            ),
                        )
                    )
                ));


                $this->addSections($cpt_id, array(
                    'title' => __($cpt_name.' Footer') ,
                    'desc' => __('Footer settings for the '.$cpt_name.'.') ,
                    'icon' => 'fas fa-home',
                    'fields' => array(
                        array(
                            'id' => 'cpt_'.$cpt_id.'_footer_setting',
                            'type' => 'button_set',
                            'title' => __('Footer Settings') ,
                            'options' => array(
                                'theme_default' => __('Theme Default') ,
                                'custom' => __('Custom Setting')
                            ) ,
                            'default' => 'theme_default',
                        ),
                        array(
                            'id'      => 'cpt_'.$cpt_id.'_footer_on',
                            'type'    => 'switch',
                            'title'   => __('common.footer'),
                            'on'      => __('Enabled'),
                            'off'     => __('Disabled'),
                            'default' => config('ThemeOptions.footer_on' ),
                            'depend_on' => array(
                                'cpt_'.$cpt_id.'_footer_setting' => array('operator' => '==',"value" => 'custom')
                            ),
                        ),
                        array(
                            'id'       => 'cpt_'.$cpt_id.'_footer_style',
                            'type'     => 'image_select',
                            'height'   => '80',
                            'title'    => __('Footer Template'),
                            'subtitle' => __('Choose a template for footer.'),
                            'options'  => $this->footer_style_options,
                            'default'  => config('ThemeOptions.footer_style'),
                            'depend_on' => array(
                                'cpt_'.$cpt_id.'_footer_on' => array('operator' => '==',"value" => 1)
                            ),
                        )
                    )
                ));

                $this->addSections($cpt_id, array(
                    'title' => __($cpt_name.' Sidebar') ,
                    'desc' => __('Sidebar settings for the '.$cpt_name.'.') ,
                    'icon' => 'fas fa-server',
                    'fields' => array(
                        array(
                            'id'      => 'cpt_'.$cpt_id.'_show_sidebar',
                            'type'    => 'switch',
                            'title'   => __('Sidebar'),
                            'on'      => __('Enabled'),
                            'off'     => __('Disabled'),
                            'default' => "on",
                        ),
                        array(
                            'id'       => 'cpt_'.$cpt_id.'_sidebar_layout',
                            'type'     => 'image_select',
                            'title'    => __('Sidebar Layout'),
                            'subtitle' => __('Choose the layout for page. (Default : Left Side).'),
                            'options'  => $this->sidebar_layout_options,
                            'default'  => 'sidebar_left',
                            'depend_on' => array(
                                'cpt_'.$cpt_id.'_show_sidebar' => array('operator' => '==',"value" => '1')
                            )
                        ),
                        array(
                            'id'        => 'cpt_'.$cpt_id.'_sidebar',
                            'type'      => 'select',
                            'options'   => DzHelper::getSidebarsList(),
                            'title'     => __('Select Sidebar') ,
                            'subtitle'  => __('Select sidebar.') ,
                            'default'   => 'default-sidebar',
                            'depend_on' => array(
                                'cpt_'.$cpt_id.'_sidebar_layout' => array('operator' => '!=',"value" => 'sidebar_full')
                            )
                        ),
                    )
                ));
            }
        }
    }   
}
