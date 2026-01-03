<?php

namespace Modules\W3Options\OptionsClass;
use App\Helper\DzHelper;

require_once 'functions.php';

class ThemeOptionsClass
{
    public $args = array();
    public $sections = array();
    public $theme;
    public $ReduxFramework;
    public $page_template_options;
    public $coming_template_options;
    public $maintenance_template_options;
    public $header_style_options;
    public $footer_style_options;
    public $theme_style_options;
    public $page_banner_layout_options;
    public $post_layouts_options;
    public $sidebar_layout_options;
    public $post_wrapper_options;
    public $post_listing_options;
    public $post_tiles_options;
    public $page_banner_options;
    public $post_banner_options;
    public $theme_layout_options;
    public $theme_color_background_options;
    public $theme_image_background_options;
    public $theme_pattern_background_options;
    public $page_loader_options;
    public $sort_by_options;
    public $link_target_options;
    public $adsence_size_options;
    public $social_link_options;
    public $banner_type;
    public $error_template_options;
    public $theme_color_options;

    function __construct()
    {

        /* Create the sections and fields */
        $this->setOptions();
        $this->setSections();

    }


    function setOptions() {
        /** Option Variable assigning values **/
        $this->coming_template_options = get_coming_template_options();
        $this->maintenance_template_options = get_maintenance_template_options();
        $this->header_style_options = get_header_style_options();
        $this->footer_style_options = get_footer_style_options();
        $this->theme_style_options = get_theme_style_options();
        $this->page_banner_layout_options = get_page_banner_layout_options();
        $this->post_layouts_options = get_post_layouts_options();
        $this->sidebar_layout_options = get_sidebar_layout_options();
        $this->post_wrapper_options = get_post_wrapper_options();
        $this->post_listing_options = get_post_listing_options();
        $this->page_banner_options = get_page_banner_options();
        $this->post_banner_options = get_post_banner_options();
        $this->theme_layout_options = get_theme_layout_options();
        $this->theme_color_background_options = get_theme_color_background_options();
        $this->theme_image_background_options = get_theme_image_background_options();
        $this->theme_pattern_background_options = get_theme_pattern_background_options();
        $this->page_loader_options = get_page_loader_options();
        $this->sort_by_options = get_sort_by_options();
        $this->link_target_options = get_link_target_options();
        $this->adsence_size_options = get_adsence_size_options();
        $this->social_link_options = get_social_link_options();
        $this->banner_type = banner_type();
        $this->error_template_options = get_error_template_options();
        $this->theme_color_options = get_theme_color_options();
        /** End Option Variable assigning values **/
    }

    /**
     * All the possible sections for W3Options.
     *
     */
    public function setSections() {
        /*--------------------------------------------------------------
        # 1. General Settings
        --------------------------------------------------------------*/
        $this->sections[] = array(
            'title'  => __('General Settings'),
            'desc'   => __('General Settings is a global setting that will affects all the pages of you website. From here you can make changes globaly. The setting will apply if there is no individual sttings.'),
            'icon'   => 'fas fa-home',
            'fields' => array(
                array(
                    'id'       => 'website_status',
                    'type'     => 'button_set',
                    'title'    => __('Website Status'),
                    'subtitle' => __('Clock on the option tabs to change the status of your website.'),
                    'desc'     => __('Select option tabs to change the status.'),
                    'options'  => array(
                        'live_mode'  => __('Live'),
                        'comingsoon_mode'  => __('Coming Soon'),
                        'maintenance_mode'  => __('Site Down For Maintenance')
                    ),
                    'default'  => 'live_mode',
                    'hint'     => array(
                        'title'   => __('Status'),
                        'content' => __('1. Live status indicate that your website is available and operational.') . '<br><br>' . __('2. Coming Soon status show your website visitors that you are working on your website for making it better.') . '<br><br>' . __('3. Maintenance mode show your website visitors that you are working on your website for making it better.')
                    )
                ),
                array(
                    'id'       => 'logo_type',
                    'type'     => 'button_set',
                    'title'    => __('Logo Type'),
                    'subtitle' => __('Choose the logo type'),
                    'desc'     => __('Click the tab to change the logo type.'),
                    'options'  => array(
                        'image_logo'  => __('Image Logo'),
                        'text_logo'  => __('Text Logo')
                    ),
                    'default'  => 'image_logo',
                    'hint'     => array(
                        'title'   => __('Choose Logo Type:'),
                        'content' => __('1. Image Logo will be the .pmg / .jpg type. This setting affects all the site pages.') .'<br><br>'. __('2. Text Logo will the text type. This setting affects all the site pages.')
                    )
                ),
                array(
                    'id'       => 'blog_page_title',
                    'type'     => 'text',
                    'title'    => __('Blog Page Title'),
                    'desc'     => __('Default blog page title.'),
                    'default'  => __('Blogs')
                ),
                array(
                    'id'       => 'page_loading_on',
                    'type'     => 'switch',
                    'title'    => __('Page Loading'),
                    'subtitle' => __('Click on the tab to Enable / Disable the page loading setting.'),
                    'desc'     => __('Once you click on disable, This setting affects all the site pages.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'preload_image',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Preloader Image'),
                    'depend_on' => array(
                        'page_loading_on' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                    'id'       => 'preload_text',
                    'type'     => 'text',
                    'url'      => true,
                    'title'    => __('Preload Text'),
                    'depend_on' => array(
                        'page_loading_on' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                    'id'       => 'show_website_search',
                    'type'     => 'switch',
                    'title'    => __('Website Search'),
                    'subtitle' => __('Click on the tab to Enable / Disable the website search setting.'),
                    'desc'     => __('Once you click on disable, This setting affects all the site pages.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'show_social_icon',
                    'type'     => 'switch',
                    'title'    => __('Social Icon'),
                    'subtitle' => __('Click on the tab to Enable / Disable the social icon setting.'),
                    'desc'     => __('Once you click on disable, This setting affects all the site pages.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'show_breadcrumb',
                    'type'     => 'switch',
                    'title'    => __('Breadcrumb Area'),
                    'subtitle' => __('Click on the tab to Enable / Disable the website breadcrumb.'),
                    'desc'     => __('Once you click on disable, This setting affects all the site pages.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'show_login_registration',
                    'type'     => 'switch',
                    'title'    => __('Login / Register'),
                    'subtitle' => __('Click on the tab to Enable / Disable the login / register button / likns.'),
                    'desc'     => __('Once you click on disable, This setting affects all the site pages.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => false
                ),
                array(
                    'id'       => 'show_sidebar',
                    'type'     => 'switch',
                    'title'    => __('Sidebar'),
                    'subtitle' => __('Click on the tab to Enable / Disable the sidebar.'),
                    'desc'     => __('Once you click on disable, This setting affects all the site pages.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'email_text',
                    'type'     => 'text',
                    'title'    => __('Email Text'),
                    'desc'     => __('Enter email text.'),
                    'default'  => __('Send us a Mail')
                ),
                array(
                    'id'       => 'email_address',
                    'type'     => 'text',
                    'title'    => __('Email Address'),
                    'desc'     => __('Enter email address.'),
                    'default'  => __('email@domain.com')
                ),
                array(
                    'id'       => 'phone_text',
                    'type'     => 'text',
                    'title'    => __('Phone Text'),
                    'desc'     => __('Enter phone text.'),
                    'default'  => __('Contact Us')
                ),
                array(
                    'id'       => 'phone_number',
                    'type'     => 'text',
                    'title'    => __('Phone Number'),
                    'desc'     => __('Enter phone number.'),
                    'default'  => __('+1 123 456 7890')
                ),
                array(
                    'id'       => 'address_text',
                    'type'     => 'text',
                    'title'    => __('Address Text'),
                    'desc'     => __('Enter address text.'),
                    'default'  => __('Address')
                ),
                array(
                    'id'       => 'address',
                    'type'     => 'text',
                    'title'    => __('Address'),
                    'desc'     => __('Enter address.'),
                    'default'  => __('785 15h Street, Office 478 Berlin, De 81566')
                ),
                array(
                    'id'       => 'opening_time_text',
                    'type'     => 'text',
                    'title'    => __('Opening Time Text'),
                    'desc'     => __('Enter opening time text.'),
                    'default'  => __('Opening Time')
                ),
                array(
                    'id'       => 'opening_time',
                    'type'     => 'text',
                    'title'    => __('Opening Time'),
                    'desc'     => __('Enter opening time.'),
                    'default'  => __('Mon-Thu: 8:00am-5:00pm Fri: 8:00am-1:00pm')
                ),
            )
        );
        

        /*--------------------------------------------------------------
        # 2. Logo Settings
        --------------------------------------------------------------*/
        $this->sections[] = array(
            'title'  => __('Logo Settings'),
            'icon'   => 'fas fa-cogs',
            'fields' => array(
                array(
                    'id'       => 'favicon',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Favicon'),
                    'subtitle' => __('Select favicon image.'),
                    'desc' => __('Upload favicon image.'),
                    'hint'     => array(
                        'title'   => __('Favicon'),
                        'content' => __('From here you can upload an image. This setting affects all the site pages.')
                    )
                ),
                array(
                    'id'       => 'logo_text',
                    'type'     => 'text',
                    'title'    => __('Logo Text'),
                    'subtitle' => __('Name your text logo.'),
                    'default'  => ''
                ),
                array(
                    'id'       => 'tag_line',
                    'type'     => 'text',
                    'title'    => __('Tag Line'),
                    'subtitle' => __('Name a tagline for the text logo.'),
                    'default'  => ''
                ),
                array(
                    'id'       => 'logo_title',
                    'type'     => 'text',
                    'title'    => __('Logo Title'),
                    'subtitle' => __('Title attribute for the logo. This attribute specifies extra information about the logo. Most browsers will show a tooltip with this text on logo hover.'),
                    'default'  => __('logo' )
                ),
                array(
                    'id'       => 'logo_alt',
                    'type'     => 'text',
                    'title'    => __('Logo Alt'),
                    'subtitle' => __('Alt attribute for the logo. This is the alternative text if the logo cannot be displayed. It`s useful for SEO and generally is the name of the site.'),
                    'default'  => ''
                ),
                array(
                   'id' => 'logo-section-start',
                   'type' => 'section',
                   'title' => __('Site Logo Setting'),
                   'indent' => true
                ),
                array(
                    'id'       => 'site_logo',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Logo'),
                    'subtitle' => __('Upload your logo (272 x 90px) .png or .jpg'),
                ),
                array(
                    'id'       => 'site_other_logo',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Other Logo'),
                    'subtitle' => __('Upload your logo (272 x 90px) .png or .jpg'),
                ),
                array(
                    'id'       => 'ratina_logo',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Ratina Logo'),
                    'subtitle' => __('Upload your retina logo (544 x 180px) .png or .jpg.'),
                    'hint'     => array(
                        'title'   => __('Details'),
                        'content' => __('1. If you do not set any retina logo, the site will load the normal logo on retina displays') . '<br><br>' . __('2. The retina logo has to have the same file format with the normal logo.')
                    )
                ),
                array(
                    'id'     => 'logo-section-end',
                    'type'   => 'section',
                    'indent' => false,
                ),
                array(
                   'id' => 'mobile-logo-section-start',
                   'type' => 'section',
                   'title' => __('Mobile Logo Setting'),
                   'subtitle' => __('You can optionally load a different logo on mobile phones and small screens. Usually the logo is smaller so that it can fit in the smart affix menu. iPhone, iPad, Samsung and a lot of phones use the retina logo. If you don`t upload any Logo Mobile by default will be used the Logo that you uploaded in the section above. This Option is recommended when your logo will not scale perfect on mobile devices.'),
                   'indent' => true
                ),
                array(
                    'id'       => 'mobile_logo',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Mobile Logo'),
                    'subtitle' => __('Upload your logo'),
                    'desc' => __('For best results logo mobile size: 140 x 48px'),
                ),
                array(
                    'id'       => 'ratina_mobile_logo',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Mobile Ratina Logo'),
                    'subtitle' => __('Upload your retina logo (double size)'),
                    'desc' => __('For best results retina logo mobile size: 280 x 96px'),
                ),
                array(
                    'id'     => 'mobile-logo-section-end',
                    'type'   => 'section',
                    'indent' => false,
                ),
            )
        );


        /*--------------------------------------------------------------
        # 3. Header Settings
        --------------------------------------------------------------*/
        $header_social_links = $header_social_defaults = array();

        foreach ($this->social_link_options as $social_link) {

            $link_value = config('ThemeOptions.social_' . $social_link['id'] . '_url');
            
            if( !empty( $link_value ) ) {
                $header_social_links[$social_link['id']] = $social_link['title'];
                $header_social_defaults[$social_link['id']] = false;
            }
        }

        $header_style_options = header_style_options();
        if(function_exists('_header_style_options')){
            $header_style_options = _header_style_options();
        }
        $header_aditional_array= array();
        $mobile_header_aditional_array = array();


        foreach($header_style_options as $header)
        {
            $header_id = $header['id']; 
            
            $header_social_defaults_1 = $header_social_defaults;

            $header_search_on = $header['param']['search'] ?? false;
            $social_link = $header['param']['social_link'] ?? false;
            $total_links = $header['param']['social_links'] ?? 0;
            $call_to_action_button = $header['param']['call_to_action_button'] ?? 0;
            $header_top_bar = $header['param']['top_bar'] ?? 0;
            $header_sidebar = $header['param']['sidebar'] ?? 0;
            $phone_number = $header['param']['phone_number'] ?? 0;
            $email_address = $header['param']['email_address'] ?? 0;
            $contact_info = $header['param']['contact_info'] ?? 0;
            $color_mode = $header['param']['color_mode'] ?? 0;
            $hamburger = $header['param']['hamburger'] ?? 0;
            $theme_button = $header['param']['theme_button'] ?? 0;
            $container_layout = $header['param']['container_layout'] ?? 0;
            
            if($total_links > 0 )
            {
                $i = 1;
                foreach($header_social_links as $key => $value)
                {
                    if($i <= $total_links)
                    {
                        $header_social_defaults_1[$key] = 1;
                    }
                    else
                    {
                        $header_social_defaults_1[$key] = 0;    
                    }
                    $i++;
                }   
            }   

            /******Header Related Fields *****/
            if ($header_top_bar > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_top_bar',
                    'type'     => 'switch',
                    'title'    => __('Top Bar'),
                    'subtitle' => __('Show or hide the Top Bar.'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_top_bar_items',
                    'type'     => 'group',
                    'title'    => __('Top Bar Items'),
                    'subtitle' => __('Header Top Bar Items.'),
                    'params' => array(
                        array(
                            "id"       => "icon",
                            "type"     => "media", 
                            "url"      => true,
                            "title"    => __('Icon'),
                            "desc"     => "",
                            "subtitle" => "",
                        ),
                        array(
                            "id"            => "title",
                            "type"          => "text",
                            "title"         => __('Title'),
                            "subtitle"      => "",
                            "desc"          => "",
                            "default"       => "",
                            "class"         => "",
                            "placeholder"   => "",
                            "autocomplete"  => "",
                            "readonly"      => "",
                        ),
                        array(
                            "id"            => "content",
                            "type"          => "text",
                            "title"         => __('Content'),
                            "subtitle"      => "",
                            "desc"          => "",
                            "default"       => "",
                            "class"         => "",
                            "placeholder"   => "",
                            "autocomplete"  => "",
                            "readonly"      => "",
                        ),
                        array(
                            "id"            => "url",
                            "type"          => "text",
                            "title"         => __('Url'),
                            "subtitle"      => "",
                            "desc"          => "",
                            "default"       => "",
                            "class"         => "",
                            "placeholder"   => "",
                            "autocomplete"  => "",
                            "readonly"      => "",
                        ),
                    ),
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => "header_1")
                    ),
                );
            }

            if ($hamburger > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_hamburger_position',
                    'type'     => 'button_set',
                    'title'    => __('Hamburger Position'),
                    'subtitle' => __('Change the Hamburger Position.'),
                    'options'  => array(
                        'left'  => __('Left'),
                        'right'  => __('Right'),
                    ),
                    'default'  => 'left',
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }
            
            if ($container_layout > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_container_layout',
                    'type'     => 'button_set',
                    'title'    => __('Container Layout'),
                    'subtitle' => __('Change the Container Layout.'),
                    'options'  => array(
                        'container'  => __('Container'),
                        'container-fluid'  => __('Full Width'),
                    ),
                    'default'  => 'container-fluid',
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }

            if ($color_mode > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_color_mode',
                    'type'     => 'button_set',
                    'title'    => __('Header Color Mode'),
                    'subtitle' => __('Change the Header color.'),
                    'options'  => array(
                        'light'  => __('Light'),
                        'dark'  => __('Dark'),
                    ),
                    'default'  => 'light',
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }

            if ($theme_button > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_theme_button',
                    'type'     => 'switch',
                    'title'    => __('Theme Button'),
                    'subtitle' => __('Show or hide the Theme Button.'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }

            if ($phone_number > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_phone',
                    'type'     => 'switch',
                    'title'    => __('Phone Number'),
                    'subtitle' => __('Show or hide the Phone Number.'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }

            if ($email_address > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_email',
                    'type'     => 'switch',
                    'title'    => __('Email Address'),
                    'subtitle' => __('Show or hide the Email Address.'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }

            if ($contact_info > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_contact_info',
                    'type'     => 'switch',
                    'title'    => __('Contact Info'),
                    'subtitle' => __('Show or hide the Contact Info.'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }
            
            if ($header_sidebar > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_sidebar_on',
                    'type'     => 'switch',
                    'title'    => __('Sidebar'),
                    'subtitle' => __('Show or hide the Sidebar.'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_sidebar',
                    'type'     => 'select',
                    'options'  => DzHelper::getSidebarsList(),
                    'data'     => 'sidebars',
                    'title'    => __( 'Select Sidebar' ),
                    'subtitle' => __('Select sidebar for header'),
                    'default'  => 'dz_default_sidebar',
                    'depend_on' => array(
                        'header_style'           => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }

            if ($header_search_on > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_search_on',
                    'type'     => 'switch',
                    'title'    => __('Search'),
                    'subtitle' => __('Show or hide the website search option.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => $header_search_on,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }

            if ($social_link > 0) {
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_social_link_on',
                    'type'     => 'switch',
                    'title'    => __('Social Link'),
                    'subtitle' => __('Show or hide the hader social link option.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => $social_link,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
                $header_aditional_array[] = array(
                    'id'       => $header_id.'_social_links',
                    'type'     => 'checkbox_multi',
                    'title'    => __( 'Choose for this Header' ),
                    'subtitle' => __( 'No validation can be done on this field type' ),
                    'desc'     => __( 'This is the description field, again good for additional info.' ),
                    //Must provide key => value pairs for multi checkbox options
                    'options'  => $header_social_links,
                    //See how std has changed? you also don't need to specify opts that are 0.
                    'default'  => $header_social_defaults_1,
                    'depend_on' => array(
                        'header_style' => array('operator' => '==',"value" => $header_id)
                    ),
                );
            }
            
            if($call_to_action_button > 0 )
            {                   
                for($i = 1; $i <= $call_to_action_button; $i++ )
                {
                    $header_aditional_array[] = array(
                        'id'       => $header_id.'_button_'.$i.'_text',
                        'type'     => 'text',
                        'title'    => __('Button ').$i. __(' Text'),
                        'default'  => '',
                        'depend_on' => array(
                            'header_style' => array('operator' => '==',"value" => $header_id)
                        ),
                    );
                    $header_aditional_array[] = array(
                        'id'       => $header_id.'_button_'.$i.'_url',
                        'type'     => 'text',
                        'title'    => __('Button ').$i.__(' URL'),
                        'default'  => '',
                        'depend_on' => array(
                            'header_style' => array('operator' => '==',"value" => $header_id)
                        ),
                    );
                    $header_aditional_array[] = array(
                        'id'       => $header_id.'_button_'.$i.'_target',
                        'type'     => 'select',
                        'title'    => __('Choose Button ').$i.__(' Target'),
                        'options'  => $this->link_target_options,
                        'default'  => '_self',
                        'depend_on' => array(
                            'header_style' => array('operator' => '==',"value" => $header_id)
                        ),
                    );  
                }   
            }

            $mobile_header_aditional_array[] = array(
                'id'       => $header_id.'_mobile_social_link_on',
                'type'     => 'switch',
                'title'    => __('Social Link'),
                'subtitle' => __('Show or hide the hader social link option.'),
                'on'       => __('Enabled'),
                'off'       => __('Disabled'),
                'default'  => $social_link,
                'depend_on' => array(
                    'header_style' => array('operator' => '==',"value" => $header_id)
                ),
            );
            $mobile_header_aditional_array[] = array(
                'id'       => $header_id.'_mobile_search_on',
                'type'     => 'switch',
                'title'    => __('Mobile Search'),
                'subtitle' => __('Show or hide the website search option on mobile view.'),
                'on'       => __('Enabled'),
                'off'       => __('Disabled'),
                'default'  => $header_search_on,
                'depend_on' => array(
                    'header_style' => array('operator' => '==',"value" => $header_id)
                ),
            );

            /******Header Related Fields *****/
        }       

        $headerDefaultOption = array(
            'title'  => __('Header Settings'),
            'desc'  => __('Describe header settings here.....................'),
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'       => 'header_style',
                    'type'     => 'image_select',
                    'title'    => __('Header Style'),
                    'subtitle' => __('Choose header style. White header is set as default header for all theme.'),
                    'options'  => $this->header_style_options,
                    'default'  => 'header_1',
                    'hint'    => array(
                        array(
                            'title'   => 'Hint Title',
                            'content' => 'This is the content of the tool-tip'
                        )
                    )
                ),
                array(
                    'id'       => 'header_sticky_on',
                    'type'     => 'switch',
                    'title'    => __('Sticky Header'),
                    'subtitle' => __('Header will be sticked when applicable.'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => false
                ),
                array(
                   'id' => 'mobile_section_start',
                   'type' => 'section',
                   'title' => __('Mobile Device Options'),
                   'indent' => false
                ),
                
            )
        );

        array_splice( $headerDefaultOption['fields'], 2, 0, $header_aditional_array );
        $mobileFieldPosition = count($headerDefaultOption['fields']);
        array_splice( $headerDefaultOption['fields'], $mobileFieldPosition , 0, $mobile_header_aditional_array );
        
        $this->sections[] = $headerDefaultOption;


        /*--------------------------------------------------------------
        # 4. Footer
        --------------------------------------------------------------*/
        
        $footer_setting_fields[] = array(
            'id'      => 'footer_on',
            'type'    => 'switch',
            'title'   => __('Footer'),
            'on'      => __('Enabled'),
            'off'     => __('Disabled'),
            'default' => true
        );

        $footer_setting_fields[] = array(
            'id'       => 'footer_style',
            'type'     => 'image_select',
            'title'    => __('Footer Template'),
            'subtitle' => __('Choose a template for footer.'),
            'options'  => $this->footer_style_options,
            'default'  => 'footer_template_1',
            'depend_on' => array(
                'footer_on' => array('operator' => '==',"value" => 1)
            ),
        );

        $footer_style_options = footer_style_options();
        if(function_exists('_footer_style_options')){
            $footer_style_options = _footer_style_options();
        }

        $footer_block = array();
        foreach($footer_style_options as $key => $value)
        {
            $footer_id =  $value['id'];
            
            $newsletter = $value['param']['newsletter'] ?? 0;
            $informative_field = $value['param']['informative_field'] ?? 0;
            $contact_buttons = $value['param']['contact_buttons'] ?? 0;
            $footer_image = $value['param']['footer_image'] ?? 0;
            $call_to_action_button = $value['param']['call_to_action_button'] ?? 0;
            $footer_title = $value['param']['footer_title'] ?? 0;
            $footer_marquee_tags = $value['param']['footer_marquee_tags'] ?? 0;

            if(@$value['param']['top_bar'] == 1)
            {
                $footer_setting_fields[] = array(
                    'id' => $footer_id . '_top_bar',
                    'type' => 'switch',
                    'title' => __('Footer Top') ,
                    'subtitle' => __('Show or hide the Footer Top.') ,
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_top_title',
                    'type'     => 'text',
                    'title'    => __('Footer Top Title'),
                    'default'  => __('Get in Touch with us'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_top_description',
                    'type'     => 'text',
                    'title'    => __('Footer Top Description'),
                    'default'  => __('Lorem Ipsum is simply dummy'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            }

            if($footer_image > 0)
            {
                $footer_setting_fields[] = array(
                    'id' => $footer_id . '_image',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Image') ,
                    'subtitle' => __('Show or hide the image.') ,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            }

            if($footer_title > 0)
            {
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_title',
                    'type'     => 'text',
                    'title'    => __('Footer Title'),
                    'default'  => __('Take your brand to the next level with Plexify'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            }
            
            if($footer_marquee_tags > 0)
            {
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_marquee_tags',
                    'type'     => 'textarea',
                    'title'    => __('Footer Marquee Tags'),
                    'desc'    => __('Enter tags separated by comma(,). Example: business, agency, portfolio'),
                    'default'  => __('Creative, Agency, Portfolio, Business, Corporate, Modern'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            }

            if($call_to_action_button > 0 )
            {                   
                for($i = 1; $i <= $call_to_action_button; $i++ )
                {
                    $footer_setting_fields[] = array(
                        'id'       => $footer_id.'_button_'.$i.'_text',
                        'type'     => 'text',
                        'title'    => __('Button ').$i. __(' Text'),
                        'default'  => '',
                        'depend_on' => array(
                            'footer_style' => array('operator' => '==',"value" => $footer_id)
                        ),
                    );
                    $footer_setting_fields[] = array(
                        'id'       => $footer_id.'_button_'.$i.'_url',
                        'type'     => 'text',
                        'title'    => __('Button ').$i.__(' URL'),
                        'default'  => '',
                        'depend_on' => array(
                            'footer_style' => array('operator' => '==',"value" => $footer_id)
                        ),
                    );
                    $footer_setting_fields[] = array(
                        'id'       => $footer_id.'_button_'.$i.'_target',
                        'type'     => 'select',
                        'title'    => __('Choose Button ').$i.__(' Target'),
                        'options'  => $this->link_target_options,
                        'default'  => '_self',
                        'depend_on' => array(
                            'footer_style' => array('operator' => '==',"value" => $footer_id)
                        ),
                    );  
                }   
            }

            if($contact_buttons > 0)
            {
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_button_text',
                    'type'     => 'text',
                    'title'    => __('Button Text'),
                    'default'  => __('Contact Us'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_button_link',
                    'type'     => 'text',
                    'title'    => __('Button Link'),
                    'default'  => __(''),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_button_text_2',
                    'type'     => 'text',
                    'title'    => __('Button Text 2'),
                    'default'  => __('Appointment'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_button_link_2',
                    'type'     => 'text',
                    'title'    => __('Button Link 2'),
                    'default'  => __(''),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            }


            if(@$value['param']['social_link'] == 1)
            {
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_social_on',
                    'type'     => 'switch',
                    'title'    => __('Enable Footer Social'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );  
            }   

            if(@$value['param']['sections'] > 0)
            {
                if (isset($footer_sections)) {
                    unset($footer_sections);
                }
                $footer_sections['All Widgets'] = DzHelper::getAllWidgetsList();
                for ($i=1; $i <= $value['param']['sections']; $i++) { 
                    $footer_sections['Section '.$i] = array();
                }

                $footer_setting_fields[] = array(
                    'id'      => $footer_id . '_sections',
                    'type'    => 'sorter',
                    'title'   => 'Footer Sections',
                    'options' => $footer_sections,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            } 

            if(@$value['param']['bottom_bar'] == 1)
            {
                $footer_setting_fields[] = array(
                    'id' => $footer_id . '_bottom_bar',
                    'type' => 'switch',
                    'title' => __('Footer Bottom'),
                    'subtitle' => __('Show or hide the Footer Bottom.') ,
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );

                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_bottom_title',
                    'type'     => 'text',
                    'title'    => __('Footer Bottom Title'),
                    'default'  => __('Important Updates Waiting for you'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );

                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_bottom_description',
                    'type'     => 'text',
                    'title'    => __('Footer Bottom Description'),
                    'default'  => __('Get our latest and best contents right into your inbox'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );

                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_bottom_button_text',
                    'type'     => 'text',
                    'title'    => __('Button Text'),
                    'default'  => __('Call Us Now'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
                
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_bottom_button_url',
                    'type'     => 'text',
                    'title'    => __('Button URL'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );

            }

            if($newsletter > 0)
            {
                $footer_setting_fields[] = array(
                    'id' => $footer_id . '_newsletter',
                    'type' => 'switch',
                    'title' => __('Newsletter'),
                    'subtitle' => __('Show or hide the Newsletter.') ,
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            }

            if($informative_field > 0)
            {
                $footer_setting_fields[] = array(
                    'id' => $footer_id . '_contact_info',
                    'type' => 'switch',
                    'title' => __('Footer Contact Info'),
                    'subtitle' => __('Show or hide the Contact Info.') ,
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_contact_info_title',
                    'type'     => 'text',
                    'title'    => __('Footer Contact Info Title'),
                    'default'  => __('Important Updates Waiting for you'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );

                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_contact_info_description',
                    'type'     => 'text',
                    'title'    => __('Footer Contact Info Description'),
                    'default'  => __('Get our latest and best contents right into your inbox'),
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            }

            if(@$value['param']['bg_image'] == 1)
            {
                $footer_setting_fields[] = array(
                    'id' => $footer_id . '_bg_image',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Footer Background Image') ,
                    'subtitle' => __('Show or hide the background image.') ,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );
            } 

            if(@$value['param']['copyright'] == 1)
            {
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_copyright_on',
                    'type'     => 'switch',
                    'title'    => __('Enable Footer Copyright'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );  
            }

            if(@$value['param']['powered_by'] == 1)
            {
                $footer_setting_fields[] = array(
                    'id'       => $footer_id.'_powered_by_on',
                    'type'     => 'switch',
                    'title'    => __('Enable Footer Powered By'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true,
                    'depend_on' => array(
                        'footer_style' => array('operator' => '==',"value" => $footer_id)
                    ),
                );  
            }

        }           

        $footer_setting_fields[] = array(
            'id'       => 'footer_copyright_text',
            'type'     => 'text',
            'title'    => __('Copyright Text'),
            'subtitle' => __('Write footer copyright text here.'),
            'default'  => __('© '.date('Y').' All Rights Reserved.'),
            'depend_on' => array(
                'footer_on' => array('operator' => '==',"value" => 1)
            ),
        );

        $footer_setting_fields[] = array(
            'id'       => 'footer_powered_by_text',
            'type'     => 'text',
            'title'    => __('Powered By Text'),
            'subtitle' => __('Write footer Powered By text here.'),
            'default'  => __('© '.date('Y').' All Rights Reserved.'),
            'depend_on' => array(
                'footer_on' => array('operator' => '==',"value" => 1)
            ),
        );
        
        $this->sections[] = array(
            'title'  => __('Footer Settings'),
            'desc'   => __('The footer uses widgets to show information. Here you can customize the number of layouts. In order to add widgets to the footer go to footer widgets section and drag widget to the footer block (s).') .'<br><br>'.__('Footer blocks are change according to footer templates.'),
            'icon'   => 'fa fa-home',
            'fields' => $footer_setting_fields
        );

        /*--------------------------------------------------------------
        # 5. Post Setting
        --------------------------------------------------------------*/
        $this->sections[] = array(
            'title'  => __('Post Settings'),
            'icon'   => 'fas fa-newspaper'
        );
        
        $this->sections[] = array(
            'title'  => __('General Settings'),
            'desc' => __('This option will work on all new post and edit post sections. On new post page we will display only Post Layout Selection , all other settings will be applicable from here.'),
            'subsection' => true,
            'icon'   => 'fa fa-cog',
            'fields' => array(
                array(
                    'id'       => 'post_general_layout',
                    'type'     => 'image_select',
                    'height'   => '100',
                    'title'    => __('Single Post Layout'),
                    'subtitle' => __('Select a layout for post page.'),
                    'desc'     => __('Click on the template icon to select.'),
                    'options'  => $this->post_layouts_options,
                    'height'  => '200px',
                    'default'  => 'post_standard',
                    'hint'     => array(
                        'title'   => __('How it Works?'),
                        'content' => __('Once you select the template from here the template will apply for default post page.')
                    )
                ),
                array(
                    'id'       => 'date_on',
                    'type'     => 'switch',
                    'title'    => __('Date'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'comment_count_on',
                    'type'     => 'switch',
                    'title'    => __('Comment Count'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'comment_view_on',
                    'type'     => 'switch',
                    'title'    => __('Comment View'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'post_view_on',
                    'type'     => 'switch',
                    'title'    => __('Post View'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'post_start_view',
                    'type'     => 'text',
                    'title'    => __('Post Start View'),
                    'default'  => '',
                    'desc'     => __('Enter only number.')
                ),
                array(
                    'id'       => 'author_box_on',
                    'type'     => 'switch',
                    'title'    => __('Author Box'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'category_on',
                    'type'     => 'switch',
                    'title'    => __('Category'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'tag_on',
                    'type'     => 'switch',
                    'title'    => __('Tag'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'pre_next_post_on',
                    'type'     => 'switch',
                    'title'    => __('Previous & Next Post'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'featured_img_on',
                    'type'     => 'switch',
                    'title'    => __('Featured Image'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'featured_img_place_holder_on',
                    'type'     => 'switch',
                    'title'    => __('Featured Image Place Holder'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'post_sharing_on',
                    'type'     => 'switch',
                    'title'    => __('Post Sharing'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'post_related_post_on',
                    'type'     => 'switch',
                    'title'    => __('Related Post'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'post_associated_post_on',
                    'type'     => 'switch',
                    'title'    => __('Associated Post'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                )
            )
        );

        $this->sections[] = array(
            'title'  => __('Post Collage/Listing'),
            'icon'   => 'fas fa-list',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'post_listing_style',
                    'type'     => 'image_select',
                    'height'    => '120',
                    'title'    => __('Post Listing Template'),
                    'subtitle' => __('Select list template for single post page.'),
                    'desc'     => __('Click on the template icon to select.'),
                    'options' => $this->post_listing_options,
                    'default'  => 'post_listing_1',
                    'hint'     => array(
                        'title'   => __('How it Works?'),
                        'content' => __('Once you select the template from here the template will apply for default post page.')
                    )
                ),
                array(
                    'id'       => 'post_title_length_type',
                    'type'     => 'button_set',
                    'title'    => __('Post Title Length Type'),
                    'options'  => array(
                        'on_letters'  => __('On Letters'),
                        'on_words'  => __('On Words')
                    ),
                    'default'  => 'on_letters'
                ),
                array(
                    'id' => 'post_title_length',
                    'type' => 'slider',
                    'title' => __('Post Title Length'),
                    'desc' => __('Length description. Min: 2, max: 300, default value: 35'),
                    "default" => 35,
                    "min" => 2,
                    "max" => 250,
                    'display_value' => 'text'
                ),
                array(
                    'id'       => 'post_excerpt_length_type',
                    'type'     => 'button_set',
                    'title'    => __('Post Excerpt Length Type'),
                    'options'  => array(
                        'on_letters'  => __('On Letters'),
                        'on_words'  => __('On Words')
                    ),
                    'default'  => 'on_letters'
                ),
                array(
                    'id' => 'post_excerpt_length',
                    'type' => 'slider',
                    'title' => __('Post Excerpt Length'),
                    'desc' => __('Length description. Min: 2, max: 300, default value: 55'),
                    "default" => 55,
                    "min" => 2,
                    "max" => 300,
                    'display_value' => 'text'
                )
            )
        );

        $this->sections[] = array(
            'title'  => __('Featured Post'),
            'icon'   => 'fas fa-newspaper',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'single_featured_post_on',
                    'type'     => 'switch',
                    'title'    => __('Featured Post'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                )
            )
        );

        $this->sections[] = array(
            'title'  => __('Related Post'),
            'icon'   => 'fas fa-newspaper',
            'desc'   => __('This is a box that appears when a user scrolls on a single post at least 400px. The box appears in the right bottom corner and it can show one or more posts related with the current one.'),
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'related_post_title',
                    'type'     => 'text',
                    'title'    => __('Title'),
                    'default'  => '',
                ),
                array(
                    'id'       => 'single_related_post_type',
                    'type'     => 'button_set',
                    'title'    => __('Related Post Type'),
                    'subtitle' => __('Choose a related post type'),
                    'desc'     => __('Click on the tab to choose the related post type.'),
                    'options'  => array(
                        'category'  => __('Category'),
                        'tag'  => __('Tag')
                    ),
                    'default'  => 'category',
                    'hint'     => array(
                        'title'   => __('How to pick the related articles?'),
                        'content' => __('1. By Category: pick posts that have at least one category in common with the current post.') . '<br><br>' . __('2. By Tag:  pick posts that have at least one tag in common with the current post.')
                    ),
                )
            )
        );


                
        /*--------------------------------------------------------------
        # 6. Page Setting
        --------------------------------------------------------------*/

        $this->sections[] = array(
            'title'  => __('Page Settings'),
            'icon'   => 'fa fa-file'
        );

        $this->sections[] = array(
            'title'  => __('General Settings'),
            'icon'   => 'fas fa-cogs',
            'desc'   => '',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'page_general_banner_on',
                    'type'     => 'switch',
                    'title'    => __('Page Banner'),
                    'on'       => __('Enabled'),
                    'off'      => __('Disabled'),
                    'default'  => true
                ),
                array(
                   'id' => 'general-img-banner-section-start',
                   'type' => 'section',
                   'title' => __('Image Banner Setting'),
                   'indent' => true,
                   'depend_on' => array(
                        'page_general_banner_on' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                    'id'       => 'page_general_banner_height',
                    'type'     => 'image_select',
                    'title'    => __('Page Banner Height'),
                    'subtitle' => __('Choose the height for all tag page banner. Default : Big Banner'),
                    'height'   => '80',
                    'options'  => $this->page_banner_options,
                    'default'  => 'page_banner_medium',
                    'depend_on' => array(
                        'page_general_banner_on' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                    'id' => 'page_general_banner_custom_height',
                    'type' => 'slider',
                    'title' => __('Page Banner Custom Height'),
                    'desc' => __('Hight description. Min: 100, max: 800'),
                    "default" => '',
                    "min" => 100,
                    "max" => 800,
                    'display_value' => 'text',
                    'depend_on' => array(
                        'page_general_banner_height' => array('operator' => '==',"value" => 'page_banner_custom')
                    ),
                ),
                array(
                    'id'       => 'page_general_banner',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('Page Banner Image'),
                    'subtitle' => __('Enter page banner image. It will work as default banner image for all pages'),
                    'desc' => __('Upload banner image.'),
                    'depend_on' => array(
                        'page_general_banner_on' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                    'id'       => 'general_page_banner_hide',
                    'type'     => 'checkbox',
                    'title'    => __('Don`t use banner image for this page'),
                    'default'  => '0',
                    'desc'     => __('Check if you don`t want to use banner image'),
                    'depend_on' => array(
                        'page_general_banner_on' => array('operator' => '==',"value" => 1)
                    ),
                    'hint' => array(
                        'content' => 'If we don`t have suitable image then we can hide current or default banner images and show only banner container with theme default color.'
                    )
                ),
                array(
                    'id'     => 'general-img-banner-section-end',
                    'type'   => 'section',
                    'indent' => false,
                    'depend_on' => array(
                        'page_general_banner_on' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                   'id' => 'general-sidebar-section-start',
                   'type' => 'section',
                   'title' => __('Sidebar Setting'),
                   'indent' => true
                ),
                array(
                    'id'       => 'page_general_show_sidebar',
                    'type'     => 'switch',
                    'title'    => __('Sidebar'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => config('ThemeOptions.show_sidebar')
                ),
                array(
                    'id'       => 'page_general_sidebar_layout',
                    'type'     => 'image_select',
                    'title'    => __('Sidebar Layout'),
                    'height'   => '80',
                    'subtitle' => __('Choose the layout for page. (Default : Right Side).'),
                    'options'  => $this->sidebar_layout_options,
                    'default'  => 'sidebar_right',
                    'depend_on' => array(
                        'page_general_show_sidebar' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                    'id'       => 'page_general_sidebar',
                    'type'     => 'select',
                    'options'  => DzHelper::getSidebarsList(),
                    'data'     => 'sidebars',
                    'title'    => __( 'Select Sidebar' ),
                    'subtitle' => __('Select sidebar for all pages'),
                    'default'  => 'dz_default_sidebar',
                    'depend_on' => array(
                        'page_general_sidebar_layout' => array('operator' => '!=',"value" => 'sidebar_full')
                    ),
                ),
                array(
                    'id'     => 'general-sidebar-section-end',
                    'type'   => 'section',
                    'indent' => false,
                ),
                array(
                    'id'       => 'page_general_paging',
                    'type'     => 'button_set',
                    'title'    => __('Pagination '),
                    'options'  => array(
                        'default'  => __('Default'),
                        'load_more'  => __('Load More'),
                        'infinite_scroll'  => __('Infinite Scroll')
                    ),
                    'default'  => 'default',
                    'force_output' => true
                ),
                array(
                    'id'       => 'page_general_sorting_on',
                    'type'     => 'switch',
                    'title'    => __('Sorting'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'page_general_sorting',
                    'type'     => 'select',
                    'title'    => __('Select Sorting'),
                    'subtitle'    => __('Select Sorting'),
                    'desc'    => __('Select Sorting'),
                    'options'  => $this->sort_by_options,
                    'default'  => 'created_at__asc',
                    'force_output' => true,
                    'depend_on' => array(
                        'page_general_sorting_on' => array('operator' => '==',"value" => 1)
                    ),
                ),
                array(
                    'id'       => 'page_general_comment_on',
                    'type'     => 'switch',
                    'title'    => __('Comment'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                )
            )
        );
        
        $default_pages_data = array(                
            'page_author' => array(
                'top_desc' => 'The author template is shown when a user clicks on the author in the front end of the site.',
                'id' => 'author',
                'title' => 'Author',
                'icon' => 'fa fa-user'
            ),
            'page_category' => array(
                'top_desc' => 'When a user requests a page or post that doesn`t exists, WordPress will use this template.',
                'id' => 'category',
                'title' => 'Category',
                'icon' => 'far fa-list-alt'
            ),
            'page_search' => array(
                'top_desc' => 'Set the default layout for all the categories.',
                'id' => 'search',
                'title' => 'Search',
                'icon' => 'fa fa-search'
            ),
            'page_archive' => array(
                'top_desc' => 'This template is used by WordPress to generate the archives. By default WordPress generates daily, monthly and yearly archives.',
                'id' => 'archive',
                'title' => 'Archive',
                'icon' => 'fa fa-archive'
            ),
            'page_tag' => array(
                'top_desc' => 'Set the default layout for all the categories.',
                'id' => 'tag',
                'title' => 'Tag',
                'icon' => 'fa fa-tags'
            ),
        );

        foreach ($default_pages_data as $key => $page_data) {
            
            $pg_desc = $page_data['top_desc'];
            $pg_id   = $page_data['id'];
            $pg_name = $page_data['title'];
            $pg_icon = $page_data['icon'];

            if ($key == 'page_404') {
                $page_templates = $this->error_template_options;
            }
            elseif ($key == 'page_cmsoon') {
                $page_templates = $this->coming_template_options;
            }
            elseif ($key == 'page_maintenance') {
                $page_templates = $this->maintenance_template_options;
            }
            
            $this->sections[] = array(
                'title'  =>  $pg_name . __(' Page'),
                'icon'   => $pg_icon,
                'desc'   => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => $pg_id . '_page_title',
                        'type'     => 'text',
                        'title'    => __('Page Title'),
                        'default'  => $pg_name . __(' : '),
                        'force_output' => true
                    ),
                    array(
                        'id'       => $pg_id . '_page_banner_on',
                        'type'     => 'switch',
                        'title'    => __('Page Banner'),
                        'on'       => __('Enabled'),
                        'off'       => __('Disabled'),
                        'default'  => true
                    ),
                    array(
                       'id' => $pg_id . '-img-banner-section-start',
                       'type' => 'section',
                       'title' => __('Image Banner Setting'),
                       'indent' => true,
                       'depend_on' => array(
                            $pg_id . '_page_banner_on' => array('operator' => '==',"value" => 1)
                        ),
                    ),
                    array(
                        'id'       => $pg_id . '_page_banner_height',
                        'type'     => 'image_select',
                        'title'    => __('Page Banner Height'),
                        'subtitle' => __('Choose the height for page banner. Default : Big Banner'),
                        'height'   => '80',
                        'options'  => $this->page_banner_options,
                        'default'  => 'page_banner_medium',
                        'depend_on' => array(
                            $pg_id . '_page_banner_on' => array('operator' => '==',"value" => 1)
                        ),
                    ),
                    array(
                        'id' => $pg_id . '_page_banner_custom_height',
                        'type' => 'slider',
                        'title' => __('Page Banner Custom Height'),
                        'desc' => __('Hight description. Min: 100, max: 800'),
                        "default" => '',
                        "min" => 100,
                        "max" => 800,
                        'display_value' => 'text',
                        'depend_on' => array(
                            $pg_id . '_page_banner_height' => array('operator' => '==',"value" => 'page_banner_custom')
                        ),
                    ),
                    array(
                        'id'       => $pg_id . '_page_banner',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => __('Page Banner Image'),
                        'subtitle' => __('Enter page banner image. It will work as default banner image for the page.'),
                        'desc' => __('Upload banner image.'),
                        'depend_on' => array(
                            $pg_id . '_page_banner_on' => array('operator' => '==',"value" => 1)
                        ),
                    ),
                    array(
                        'id'       => $pg_id . '_page_banner_hide',
                        'type'     => 'checkbox',
                        'title'    => __('Don`t use banner image for this page'),
                        'default'  => '0',
                        'desc'     => __('Check if you don`t want to use banner image'),
                        'depend_on' => array(
                            $pg_id . '_page_banner_on' => array('operator' => '==',"value" => 1)
                        ),
                        'hint' => array(
                            'content' => 'If we don`t have suitable image then we can hide current or default banner images and show only banner container with theme default color.'
                        )
                    ),
                    array(
                        'id'     => $pg_id . '-img-banner-section-end',
                        'type'   => 'section',
                        'indent' => false,
                    ),
                    array(
                       'id' => $pg_id . '-sidebar-section-start',
                       'type' => 'section',
                       'title' => __('Sidebar Setting'),
                       'indent' => true
                    ),
                    array(
                        'id'       => $pg_id . '_page_show_sidebar',
                        'type'     => 'switch',
                        'title'    => __('Sidebar'),
                        'on'       => __('Enabled'),
                        'off'       => __('Disabled'),
                        'default'  => config('ThemeOptions.page_general_show_sidebar')
                    ),
                    array(
                        'id'       => $pg_id . '_page_sidebar_layout',
                        'type'     => 'image_select',
                        'title'    => __('Sidebar Layout'),
                        'height'    => '80',
                        'subtitle' => __('Choose the layout for the page. (Default : Right Side).'),
                        'options'  => $this->sidebar_layout_options,
                        'default'  => 'sidebar_right',
                        'depend_on' => array(
                            $pg_id . '_page_show_sidebar' => array('operator' => '==',"value" => 1)
                        ),
                    ),
                    array(
                        'id'       => $pg_id . '_page_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'options'  => DzHelper::getSidebarsList(),
                        'title'    => __( 'Select Sidebar' ),
                        'subtitle' => __('Select sidebar for the page.'),
                        'default'  => 'dz_default_sidebar',
                        'depend_on' => array(
                            $pg_id . '_page_sidebar_layout' => array('operator' => '!=',"value" => 'sidebar_full')
                        ),
                    ),
                    array(
                        'id'     => $pg_id . '-sidebar-section-end',
                        'type'   => 'section',
                        'indent' => false,
                    ),
                    array(
                        'id'       => $pg_id . '_page_paging',
                        'type'     => 'button_set',
                        'title'    => __('Pagination '),
                        'options'  => array(
                            'default'  => __('Default'),
                            'load_more'  => __('Load More'),
                            'infinite_scroll'  => __('Infinite Scroll')
                        ),
                        'default'  => 'default',
                        'force_output' => true
                    ),
                    array(
                        'id'       => $pg_id . '_page_sorting_on',
                        'type'     => 'switch',
                        'title'    => __('Sorting'),
                        'on'       => __('Enabled'),
                        'off'       => __('Disabled'),
                        'default'  => true
                    ),
                    array(
                        'id'       => $pg_id . '_page_sorting',
                        'type'     => 'select',
                        'title'    => __('Select Sorting'),
                        'subtitle'    => __('Select Sorting'),
                        'desc'    => __('Select Sorting'),
                        'options'  => $this->sort_by_options,
                        'default'  => 'created_at__asc',
                        'force_output' => true,
                        'depend_on' => array(
                            $pg_id . '_page_sorting_on' => array('operator' => '==',"value" => 1)
                        ),
                    ),
                    array(
                        'id'       => $pg_id . '_page_comment_on',
                        'type'     => 'switch',
                        'title'    => __('Comment'),
                        'on'       => __('Enabled'),
                        'off'       => __('Disabled'),
                        'default'  => true
                    )
                )
            );
        }

        $this->sections[] = array(
            'title' => __('404 Page') ,
            'icon' => 'fas fa-exclamation-triangle',
            'desc' => '',
            'subsection' => true,
            'fields' => array(
                array(
                    'id' => 'error_page_title',
                    'type' => 'text',
                    'title' => __('Page Title') ,
                    'default' => __('404') ,
                    'force_output' => true
                ) ,
                array(
                    'id' => 'error_page_template',
                    'type' => 'image_select',
                    'height' => '80',
                    'title' => __('404 Template') ,
                    'subtitle' => __('Select a template for the page.') ,
                    'options' =>  $this->error_template_options,
                    'default' => 'error_style_1'
                ) ,
                array(
                    'id'       => 'error_404_image',
                    'type'     => 'media',
                    'url'      => true,
                    'title'    => __('404 Page Image'),
                ) ,
                array(
                    'id' => 'error_page_text',
                    'type' => 'textarea',
                    'title' => __('404 Page Text') ,
                    'default' => __('We are sorry. But the page you are looking for cannot be found.')
                ) ,
                array(
                    'id' => 'error_page_button_text',
                    'type' => 'text',
                    'title' => __('404 Page Button Text') ,
                    'default' => __('Back to Home')
                ) ,

            )
        );

        $this->sections[] = array(
            'title' => __('Comming Soon') ,
            'icon' => 'far fa-hand-paper',
            'desc' => '',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'coming_soon_template',
                    'type'     => 'image_select',
                    'title'    => __('Coming Soon Template'),
                    'subtitle' => __('Choose the template for Coming Soon page. (Default : 1).'),
                    'desc'     => __('Click on the icon to change the template.'),
                    'options'  => $this->coming_template_options,
                    'default'  => 'coming_style_1',
                    'hint'     => array(
                        'title'   => __('Hint Title'),
                        'content' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.')
                    )
                ),
                array(
                    'id' => 'comingsoon_launch_date',
                    'type' => 'date',
                    'title' => __('Coming soon Date') ,
                ) ,
                array(
                    'id' => 'comingsoon_page_title',
                    'type' => 'text',
                    'title' => __('Comingsoon Soon Page Title') ,
                    'desc' => __('Default Comingsoon Soon page title.') ,

                    'default' => __('We Are Coming'). '<span class="text-primary">'.__('Soon !').'</span>',
                ) ,
                array(
                    'id' => 'comingsoon_page_desc',
                    'type' => 'text',
                    'title' => __('Comingsoon Soon Page Description') ,
                    'desc' => __('Default Comingsoon Soon page description.') ,
                    'default' => __('We`ll be here soon with our new awesome site, subscribe to be notified.'),
                ),
                array(
                    'id' => 'comingsoon_bg',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Comingsoon Soon Background Image') ,
                    'default' => array(
                        'url' => asset('/themes/frontend/bodyshape/images/pattern/bg1.svg')
                    ) ,
                ) ,
                array(
                    'id' => 'comingsoon_button_on',
                    'type' => 'switch',
                    'title' => __('Comingsoon Soon Button') ,
                    'subtitle' => __('Show or hide the button.') ,
                    'on' => __('Enabled') ,
                    'off' => __('Disabled') ,
                    'default' => false,
                ),
                array(
                    'id' => 'comingsoon_button_text',
                    'type' => 'text',
                    'title' => __('Comingsoon Soon Button Text') ,
                    'desc' => __('Enter Comingsoon Soon Page Button Text') ,
                    'default' => '',
                ) ,
                array(
                    'id' => 'comingsoon_button_url',
                    'type' => 'text',
                    'title' => __('Comingsoon Soon Button Url') ,
                    'desc' => __('Enter Comingsoon Soon Button Url') ,
                    'default' => '',
                ) ,
            )
        );

        $this->sections[] = array(
            'title' => __('Maintenance') ,
            'icon' => 'fa fa-wrench',
            'desc' => '',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'maintenance_template',
                    'type'     => 'image_select',
                    'title'    => __('Maintenance Template'),
                    'subtitle' => __('Choose the template for Maintenance page. (Default : 1).'),
                    'desc'     => __('Click on the icon to change the template.'),
                    'options'  => $this->maintenance_template_options,
                    'default'  => 'maintenance_style_1',
                    'hint'     => array(
                        'title'   => __('Hint Title'),
                        'content' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.')
                    )
                ),
                array(
                    'id' => 'maintenance_icon',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Maintenance Icon') ,
                ) ,
                array(
                    'id' => 'maintenance_bg',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Maintenance Page Background Image') ,
                ) ,
                array(
                    'id' => 'maintenance_title',
                    'type' => 'textarea',
                    'title' => __('Maintenance Page Title') ,
                    'default' => __('Site Is Down') . ' <br/>' . __('For Maintenance') ,
                ) ,
                array(
                    'id' => 'maintenance_desc',
                    'type' => 'textarea',
                    'title' => __('Maintenance Page Description') ,
                    'default' => __('This is the Technical Problems Page.') . ' <br/>' . __('Or any other page.') ,
                ) ,
            )
        );

        /*--------------------------------------------------------------
        # 11. CPT ( Custom Post Type ) Setting
        --------------------------------------------------------------*/
        if (DzHelper::get_post_types()->count() > 0) {
            
            $this->sections[] = array(
                'title'  => __('CPT & Texonomy'),
                'icon'   => 'fa fa-qrcode'
            );

            foreach(DzHelper::get_post_types() as $cpt) {
                $cpt_name = $cpt->title;
                $cpt_id = $cpt->slug;
                $dz_cpt_icon = $cpt->getBlogMeta($cpt->id,'cpt_icon_slug') ?? 'flaticon-381-push-pin';
                $cpt_templates = [];

                

                $this->sections[] = array(
                    'title'   => __(ucfirst($cpt_name)),
                    'heading' => __(ucfirst($cpt_name).' Setting'),
                    'icon'    => $dz_cpt_icon,
                    'subsection' => true,
                    'fields' => array(
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_page_title',
                            'type'     => 'text',
                            'title'    => __('Title Prefix'),
                            'desc' => 'E.g.- '.ucfirst($cpt_name).': ',
                        ),
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
                            'id'       => 'cpt_' . $cpt_id . '_layout',
                            'type'     => 'image_select',
                            'height'    => '100',
                            'title'    => __('Single '.ucfirst($cpt_name).' Layout'),
                            'subtitle' => __('Choose ')
                            . strtolower($cpt_name) .
                            __(' detail page layout style.'),
                            'desc' =>
                                __('Click on the image icon to choose ')
                                . strtolower($cpt_name) .
                                __(' detail page layout.'),
                            'options'  => get_cpt_layouts_options($cpt_id),
                            'default'  => 'style_1',
                            'hint'     => array(
                                'title'   => __('How it Works?'),
                                'content' =>
                                    __('1. This layout is applicable for single ') .
                                    __( strtolower($cpt_name)) .
                                    __(' page (detail page).')
                            )
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_banner_on',
                            'type'     => 'switch',
                            'title'    => __('Page Banner'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true
                        ),
                        array(
                           'id' => 'cpt_' . $cpt_id . '-img-banner-section-start',
                           'type' => 'section',
                           'title' => __('Image Banner Setting'),
                           'indent' => true,
                           'depend_on' => array(
                                'cpt_' . $cpt_id . '_banner_on' => array('operator' => '==',"value" => 1)
                            ),
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_banner_height',
                            'type'     => 'image_select',
                            'title'    => __('Page Banner Height'),
                            'subtitle' => __('Choose the height for all tag page banner. Default : Big Banner'),
                            'height'   => '40',
                            'options'  => $this->page_banner_options,
                            'default'  => 'page_banner_medium',
                            'depend_on' => array(
                                'cpt_' . $cpt_id . '_banner_on' => array('operator' => '==',"value" => 1)
                            ),
                        ),
                        array(
                            'id' => 'cpt_' . $cpt_id . '_banner_custom_height',
                            'type' => 'slider',
                            'title' => __('Page Banner Custom Height'),
                            'desc' => __('Hight description. Min: 100, max: 800'),
                            "default" => '',
                            "min" => 100,
                            "max" => 800,
                            'display_value' => 'text',
                            'depend_on' => array(
                                'cpt_' . $cpt_id . '_banner_height' => array('operator' => '==',"value" => 'page_banner_custom')
                            ),
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_banner',
                            'type'     => 'media',
                            'url'      => true,
                            'title'    => __('Page Banner Image'),
                            'subtitle' => __('Enter page banner image. It will work as default banner image for all pages'),
                            'desc' => __('Upload banner image.'),
                            'depend_on' => array(
                                'cpt_' . $cpt_id . '_banner_on' => array('operator' => '==',"value" => 1)
                            ),
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id .  '_banner_hide',
                            'type'     => 'checkbox',
                            'title'    => __('Don`t use banner image for this page'),
                            'default'  => '0',
                            'desc'     => __('Check if you don`t want to use banner image'),
                            'depend_on' => array(
                                'cpt_' . $cpt_id . '_banner_on' => array('operator' => '==',"value" => 1)
                            ),
                            'hint' => array(
                                'content' => 'If we don`t have suitable image then we can hide current or default banner images and show only banner container with theme default color.'
                            )
                        ),
                        array(
                            'id'     => 'cpt_' . $cpt_id . '-img-banner-section-end',
                            'type'   => 'section',
                            'indent' => false,
                        ),
                        array(
                           'id' => 'cpt_' . $cpt_id . '-sidebar-section-start',
                           'type' => 'section',
                           'title' => __('Sidebar Setting'),
                           'indent' => true
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_show_sidebar',
                            'type'     => 'switch',
                            'title'    => __('Sidebar'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_sidebar_layout',
                            'type'     => 'image_select',
                            'title'    => __('Sidebar Layout'),
                            'subtitle' => __('Choose the layout for page. (Default : Right Side).'),
                            'options'  => $this->sidebar_layout_options,
                            'default'  => 'sidebar_right',
                            'required' => array( 0 => 'cpt_' . $cpt_id . '_show_sidebar', 1 => 'equals', 2 => '1' )
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_sidebar',
                            'type'     => 'select',
                            'options'  => DzHelper::getSidebarsList(),
                            'data'     => 'sidebars',
                            'title'    => __( 'Select Sidebar' ),
                            'subtitle' => __('Select sidebar for '.ucfirst($cpt_name) ),
                            'default'  => 'dz_default_sidebar',
                            'depend_on' => array(
                                'cpt_' . $cpt_id . '_sidebar_layout' => array('operator' => '!=',"value" => 'sidebar_full')
                            ),
                        ),
                        array(
                            'id'     => 'cpt_' . $cpt_id . '-sidebar-section-end',
                            'type'   => 'section',
                            'indent' => false,
                        ),
                        array(
                           'id' => 'cpt_' . $cpt_id . '-texonomy-section-start',
                           'type' => 'section',
                           'title' => __(ucfirst($cpt_name). ' Features'),
                           'subtitle' => __('Here you can Enable / Disable Term Meta i. e. Featured Image'),
                           'indent' => true
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_featured_image_on',
                            'type'     => 'switch',
                            'title'    => __('Featured Image'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true
                        ),
                        array(
                            'id'      => 'cpt_' . $cpt_id . '_featured_post_on',
                            'type'    => 'switch',
                            'title'   => __('Featured Post'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true                              
                        ),
                        array(
                            'id'      => 'cpt_' . $cpt_id . '_related_post_on',
                            'type'    => 'switch',
                            'title'   => __('Related Post'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true                              
                        ),
                        array(
                            'id'      => 'cpt_' . $cpt_id . '_associated_post_on',
                            'type'    => 'switch',
                            'title'   => __('Associated Post'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true                              
                        ),
                        array(
                            'id'     => 'cpt_' . $cpt_id . '-texonomy-section-end',
                            'type'   => 'section',
                            'indent' => false,
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_listing_style',
                            'type'     => 'image_select',
                            'height'    => '80',
                            'title'    => __( ucfirst($cpt_name) . ' Listing Style'),
                            'subtitle' => __('Select page layout.'),
                            'options'  => $this->post_listing_options,
                            'default'  => 'post_listing_1'
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_paging',
                            'type'     => 'button_set',
                            'title'    => __('Pagination '),
                            'options'  => array(
                                'default'  => __('Default'),
                                'load_more'  => __('Load More'),
                                'infinite_scroll'  => __('Infinite Scroll')
                            ),
                            'default'  => 'default',
                            'force_output' => true
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_sorting_on',
                            'type'     => 'switch',
                            'title'    => __('Sorting'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_sorting',
                            'type'     => 'select',
                            'title'    => __('Select Sorting'),
                            'options'  => $this->sort_by_options,
                            'default'  => 'date_asc',
                            'force_output' => true,
                            'depend_on' => array(
                                'cpt_' . $cpt_id . '_sorting_on' => array('operator' => '==',"value" => 1)
                            ),
                        ),
                        array(
                            'id'       => 'cpt_' . $cpt_id . '_comment_on',
                            'type'     => 'switch',
                            'title'    => __('Comment'),
                            'on'       => __('Enabled'),
                            'off'       => __('Disabled'),
                            'default'  => true
                        )
                    )
                );
            }

        }


        $theme_setting_fields[] = array(
            'id'       => 'theme_style',
            'type'     => 'image_select',
            'title'    => __('Theme Color'),
            'subtitle' => __('Choose a color for theme.'),
            'options'  => $this->theme_style_options,
            'height'   => 80,
            'default'  => 'skin-1',
        );

        $theme_setting_fields[] = array(
            'id'       => 'theme_enable_for_page',
            'type'     => 'switch',
            'title'    => __('Enable this option for pages also'),
            'on'       => __('Enabled'),
            'off'       => __('Disabled'),
            'default'  => false
        );

        $this->sections[] = array(
            'title'   => __('Theme Settings'),
            'icon'    => 'fas fa-swatchbook',
            'fields'  => $theme_setting_fields
        );



        /*--------------------------------------------------------------
        # 11. Social Setting
        --------------------------------------------------------------*/
        $this->sections[] = array(
            'title'   => __('Social Setting'),
            'icon'    => 'fab fa-twitter',
        );
        
        $socialLinkFiels[] = array(
            'id'       => 'social_link_target',
            'type'     => 'select',
            'title'    => __('Choose Social Link Target'),
            'options'  => $this->link_target_options,
            'default'  => '_self'
        );

        foreach ($this->social_link_options as $social_link) {
        
            $sl_id = $social_link['id'];
            $sl_title = $social_link['title'];

            $socialLinkFiels[] = array(
                'id'      => 'social_' . $sl_id . '_url',
                'type'    => 'text',
                'title'   => $sl_title . __(' URL'),
                'subtitle'   => __('Link to : ') . $sl_title,
                'default' => '',
            );
        }

        $this->sections[] = array(
            'title'  => __('Social Link'),
            'icon'   => 'fab fa-facebook',
            'subsection' => true,
            'fields' => $socialLinkFiels
        );

        $social_link_list = $social_link_default = array();
        $i = 1;
        foreach ($this->social_link_options as $social_link) {

            $social_link_list[$social_link['id']] = $social_link['title'];

            if($i <= 3 ) {
                $social_link_default[$social_link['id']] = true;
            }
            else {
                $social_link_default[$social_link['id']] = false;
            }
            $i++;
        }


         /*--------------------------------------------------------------
        # 11. Social Setting
        --------------------------------------------------------------*/
        $this->sections[] = array(
            'title'  => __('Social Sharing'),
            'icon'   => 'fab fa-facebook',
            'subsection' => true,
            'fields' => array(
                array(
                    'id'       => 'social_shaing_on_post',
                    'type'     => 'switch',
                    'title'    => __('Enable Social Shaing On Post'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'social_shaing_on_page',
                    'type'     => 'switch',
                    'title'    => __('Enable Social Shaing On Page'),
                    'on'       => __('Enabled'),
                    'off'       => __('Disabled'),
                    'default'  => true
                ),
                array(
                    'id'       => 'sortable',
                    'type'     => 'sortable',
                    'title'    => __('Social Sharing'),
                    'subtitle' => __('Select active social share links and sort them with drag and drop.'),
                    'mode'     => 'checkbox_multi',
                    'options'  => $social_link_list,
                    'default' => $social_link_default
                )
            )
        );
    }

    /*
    * Parameter = $post_type 
    */
    public function addSections($post_type,$options=array()) {
        $this->sections[$post_type][] = $options;
    }

    /*
    * 
    */
    public function getSections($post_type=null) {
        
        /* if not get any post type then return all options */
        if (empty($post_type)) {
            $this->setOptions();
            $this->setSections();

            return $this->sections;
        }
        else{
            if (!empty($this->sections[$post_type])) {
                return $this->sections[$post_type];
            }
            return false;
        }
    }
}
