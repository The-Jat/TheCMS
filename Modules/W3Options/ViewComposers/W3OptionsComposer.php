<?php

namespace Modules\W3Options\ViewComposers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helper\DzHelper;
use Hexadog\ThemesManager\Facades\ThemesManager;
use Modules\W3Options\OptionsClass\ThemeOptionsClass;

class W3OptionsComposer extends ThemeOptionsClass
{
    /**
     * For Getting Theme Options in Front Site Views.
     */
    public function compose(View $view, Request $request)
    {
        if( !defined( 'DEFAULT_LOGO' ) ) {define('DEFAULT_LOGO', theme_asset('/').'images/logo.png');}
        

        $action = optional($request->route())->getAction();
        $controller = $action ? explode('@', class_basename($action['controller']))[0] : '';
        $dzRes = array();
        $testStr = "";
        $viewName = $view->getName();
        
        // Added Contains conditions for not runs twice for included Files
        if (($controller == 'HomeController' ) || in_array($viewName, ['errors.coming_soon','errors.503','errors::404'])) {

            
        
            $page = optional($view)->page;
            $blog = optional($view)->blog;
            $user = optional($view)->user;
            $cpt_list = !empty(DzHelper::get_post_types()) ? DzHelper::get_post_types()->pluck('slug')->toArray() : [];
            
            if ($viewName == 'errors::404') {
                $viewName = '404';
            }
            
            $dzRes['theme_style'] = config('ThemeOptions.theme_style', 'skin-1');
            $dzRes['website_status'] = config('ThemeOptions.website_status', 'live_mode');
            
            /* Comingsoon Page Settings */
            if (is_file(storage_path('app/public/theme-options/'.config('ThemeOptions.comingsoon_bg')))) {
                $dzRes['comingsoon_bg'] = asset('storage/theme-options/'.config('ThemeOptions.comingsoon_bg'));
            }else {
                $dzRes['comingsoon_bg'] = theme_asset('images/w3options/comingsoon/comingsoon-bg.jpg');
            }
            $dzRes['coming_soon_template'] = config('ThemeOptions.coming_soon_template','coming_style_1');
            $dzRes['comingsoon_launch_date'] = config('ThemeOptions.comingsoon_launch_date',date('Y-m-d', strtotime('+1 day')));
            $dzRes['comingsoon_page_title'] = config('ThemeOptions.comingsoon_page_title');
            $dzRes['comingsoon_page_desc'] = config('ThemeOptions.comingsoon_page_desc');
            $dzRes['comingsoon_button_url'] = config('ThemeOptions.comingsoon_button_url');
            $dzRes['comingsoon_button_text'] = config('ThemeOptions.comingsoon_button_text','Get In Touch');
            $dzRes['comingsoon_button_on'] = config('ThemeOptions.comingsoon_button_on');
            /* Comingsoon Page Settings End*/

            /* Maintenence Page Settings */
            if (config('ThemeOptions.maintenance_bg') && storage_path('app/public/theme-options/'.config('ThemeOptions.maintenance_bg'))) {
                $dzRes['maintenance_bg'] = asset('storage/theme-options/'.config('ThemeOptions.maintenance_bg'));
            }else {
                $dzRes['maintenance_bg'] = theme_asset('images/w3options/maintenance/maintenance-bg.jpg');
            }
            if (is_file(storage_path('app/public/theme-options/'.config('ThemeOptions.maintenance_icon')))) {
                $dzRes['maintenence_icon'] = asset('storage/theme-options/'.config('ThemeOptions.maintenance_icon'));
            }else {
                $dzRes['maintenence_icon'] = theme_asset('images/w3options/maintenance/maintenance-icon.png');
            }
            $dzRes['maintenance_title'] = config('ThemeOptions.maintenance_title');
            $dzRes['maintenance_desc'] = config('ThemeOptions.maintenance_desc');
            $dzRes['maintenance_template'] = config('ThemeOptions.maintenance_template','maintenance_style_1');
            $dzRes['maintenence_vlc'] = theme_asset('images/w3options/maintenance/vlc.png');
            /* Maintenence Page Settings END */

            /* stuff : header.php  */
            if (config('ThemeOptions.favicon') && \Storage::exists('public/theme-options/'.config('ThemeOptions.favicon'))) {
                $dzRes['site_favicon'] = asset('storage/theme-options/'.config('ThemeOptions.favicon'));
            }
            else{
                $dzRes['site_favicon'] = asset('images/favicon.png');
            }

            /* preloading image */
            $dzRes['page_loading_on'] = config('ThemeOptions.page_loading_on');
            $dzRes['page_loader_type'] = config('ThemeOptions.page_loader_type');

            if($dzRes['page_loading_on'] == 1)
            {
                if($dzRes['page_loader_type'] == 'loading_image')
                {
                    if(!empty(config('ThemeOptions.custom_page_loader_image'))) {
                        $dzRes['preloader'] = config('ThemeOptions.custom_page_loader_image');
                    }
                    else {
                        $page_loader_image = config('ThemeOptions.page_loader_image', '');
                        $dzRes['preloader'] = theme_asset('images/loading-images/'.$page_loader_image.'.svg');
                    }
                }   
                elseif($dzRes['page_loader_type'] == 'advanced_loader')
                {
                    $dzRes['preloader'] = config('ThemeOptions.advanced_page_loader_image', '');
                }   
            }

            /* header Global Settings settings */
            $dzRes['header_style'] = config('ThemeOptions.header_style', 'header_1'); 
            $dzRes['header_color_mode'] = config('ThemeOptions.'.$dzRes['header_style'].'_color_mode', 'light'); 
            /* End header settings */

            /* Footer Settings Starts */
            $dzRes['footer_on'] = config('ThemeOptions.footer_on', true);
            $dzRes['footer_style'] = config('ThemeOptions.footer_style', 'footer_template_1');

            $dzRes['footer_social_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_social_on');
            $dzRes['footer_bg_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_bg_image');
            $dzRes['footer_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_image');
            $dzRes['footer_title'] = config('ThemeOptions.'.$dzRes['footer_style'].'_title', 'Footer Title');
            $dzRes['footer_marquee_tags'] = config('ThemeOptions.'.$dzRes['footer_style'].'_marquee_tags');
            $dzRes['footer_newsletter'] = config('ThemeOptions.'.$dzRes['footer_style'].'_newsletter');
            $dzRes['footer_sections'] = config('ThemeOptions.'.$dzRes['footer_style'].'_sections');
            $dzRes['footer_copyright_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_copyright_on');
            $dzRes['copyright_title'] = config('ThemeOptions.footer_copyright_text','© 2024 All Rights Reserved.');
            
            /* End Footer Settings Starts */

            /* logo setting , adition logo settings for 'site_other_logo' for kelsey theme */
            $dzRes['logo_type'] = config('ThemeOptions.logo_type', 'image');
            $dzRes['logo_text'] = config('ThemeOptions.logo_text');
            $dzRes['logo_title'] = config('ThemeOptions.logo_title', ThemesManager::current()->getName());
            $dzRes['logo_tag'] = config('ThemeOptions.logo_tag', 'Personal Blog');

            $dzRes['logo_alt'] = config('ThemeOptions.logo_alt', ThemesManager::current()->getName());

            if(config('ThemeOptions.logo_type') && config('ThemeOptions.logo_type') == 'image_logo')
            {
                if (is_file(storage_path('app/public/theme-options/'.config('ThemeOptions.site_logo')))) {
                    $dzRes['logo'] = asset('storage/theme-options/'.config('ThemeOptions.site_logo'));
                }else {
                    $dzRes['logo'] = theme_asset('images/logo.png');
                }
            }
            elseif(config('ThemeOptions.logo_type') && config('ThemeOptions.logo_type') == 'text_logo') {
                $dzRes['logo_text'] = $dzRes['logo_text'] ?? ThemesManager::current()->getName();
                $dzRes['logo_title'] = config('ThemeOptions.logo_title', ThemesManager::current()->getName());
            }
            else {
                $dzRes['logo'] = theme_asset('images/logo.png');
            }

            if (is_file(storage_path('app/public/theme-options/'.config('ThemeOptions.site_logo')))) {
                $dzRes['site_logo'] = asset('storage/theme-options/'.config('ThemeOptions.site_logo'));
            }else {
                $dzRes['site_logo'] = theme_asset('images/logo-dark.png');
            }

            if (is_file(storage_path('app/public/theme-options/'.config('ThemeOptions.site_other_logo')))) {
                $dzRes['site_other_logo'] = asset('storage/theme-options/'.config('ThemeOptions.site_other_logo'));
            }else {
                $dzRes['site_other_logo'] = theme_asset('images/logo-white.png');
            }

            $dzRes['ratina_logo'] = config('ThemeOptions.ratina_logo') ? asset('storage/theme-options/'.config('ThemeOptions.ratina_logo')) : '';
            $dzRes['mobile_logo'] = config('ThemeOptions.mobile_logo') ? asset('storage/theme-options/'.config('ThemeOptions.mobile_logo')) : '';
            $dzRes['ratina_mobile_logo'] = config('ThemeOptions.ratina_mobile_logo') ? asset('storage/theme-options/'.config('ThemeOptions.ratina_mobile_logo')) : '';
            /* End logo setting  */

            /*************************************************************************************************/

            /* stuff : common post stuff  */
            $dzRes['theme_date_format'] = config('ThemeOptions.theme_date_format');

            /* Post general setting */
            $dzRes['post_layout']           = config('ThemeOptions.post_general_layout','post_standard');
            $dzRes['category_on']           = config('ThemeOptions.category_on',true);
            $dzRes['tag_on']                = config('ThemeOptions.tag_on',true);
            $dzRes['pre_next_post_on']      = config('ThemeOptions.pre_next_post_on',true);
            $dzRes['post_sharing_on']       = config('ThemeOptions.post_sharing_on',true);
            $dzRes['related_post_on']       = config('ThemeOptions.post_related_post_on',true);
            $dzRes['date_on']               = config('ThemeOptions.date_on',true);
            $dzRes['blog_view_on']          = config('ThemeOptions.post_view_on',true);
            $dzRes['blog_start_view']       = config('ThemeOptions.post_start_view',0);
            $dzRes['featured_img_on']          = config('ThemeOptions.featured_img_on',true); 
            $dzRes['comment_count_on']      = config('ThemeOptions.comment_count_on',true);
            $dzRes['comment_view_on']       = config('ThemeOptions.comment_view_on',1);
            $dzRes['post_listing_style']    = config('ThemeOptions.post_listing_style','post_listing_2');
            $dzRes['post_title_length_type']   = config('ThemeOptions.post_title_length_type','on_letters');
            $dzRes['post_title_length']     = config('ThemeOptions.post_title_length',30);
            $dzRes['post_excerpt_length_type'] = config('ThemeOptions.post_excerpt_length_type','on_letters');
            $dzRes['post_excerpt_length']   = config('ThemeOptions.post_excerpt_length',60);
            /* Post general setting end */

            /* Page banner setting */
            $dzRes['show_banner'] = config('ThemeOptions.page_general_banner_on',true);
            $dzRes['banner_type'] = config('ThemeOptions.page_general_banner_type','image');
            $dzRes['banner_height'] = config('ThemeOptions.page_general_banner_height','page_banner_medium');
            $dzRes['banner_custom_height'] = config('ThemeOptions.page_general_banner_custom_height', '100');
            $dzRes['banner_image'] = config('ThemeOptions.page_general_banner') ? asset('storage/theme-options/'.config('ThemeOptions.page_general_banner')) : theme_asset('images/banner/bnr1.jpg');
            $dzRes['dont_use_banner_image'] = config('ThemeOptions.general_page_banner_hide', '');
            $dzRes['show_breadcrumb'] = config('ThemeOptions.show_breadcrumb', true);
            $dzRes['banner_layout'] = config('ThemeOptions.page_general_banner_layout', 'banner_layout_1');
            $dzRes['page_title'] = '';
            /* End Page banner setting */

            /* Sidebar and there layout */
            $dzRes['sidebar'] = '';
            $dzRes['show_sidebar'] = config('ThemeOptions.page_general_show_sidebar');

            if($dzRes['show_sidebar'] == true) {
                $dzRes['layout'] = config('ThemeOptions.page_general_sidebar_layout', 'sidebar_right');
                $dzRes['sidebar'] = config('ThemeOptions.page_general_sidebar', 'blog-sidebar');
            }else{
                $dzRes['layout'] = 'sidebar_full';
            }
            /* End Sidebar and there layout */

            $pagination = config('ThemeOptions.page_general_paging', 'default');
            $dzRes['disable_ajax_pagination'] = ($pagination == 'load_more') ? $pagination : '';
            /* Post general setting end */
            /*************************************************************************************************/

            $HomePagetemp = $dzRes;     
            
            /* page.blade.php */
            if($viewName == 'page') {

                $page_level_keys = array(
                    'page_header_setting',
                    'page_header_style',
                    'page_header_color_mode',
                    'page_banner_setting',
                    'page_banner_on',
                    'page_banner_layout',
                    'page_banner',
                    'page_banner_height',
                    'page_banner_custom_height',
                    'page_banner_hide',
                    'page_breadcrumb',
                    'page_footer_setting',
                    'page_footer_on',
                    'page_footer_style',
                    'page_show_sidebar',
                    'page_sidebar_layout',
                    'page_sidebar',
                    'page_menu',
                    'page_theme_style',
                    'set_theme_color_for_inner_page',
                );

                foreach($page_level_keys as $value)
                {
                    $page_settings[$value] =  \ThemeOption::GetPageOptionById(optional($page)->id, $value);
                }   

                $dzRes['theme_style']    = $page_settings['page_theme_style'] ?? $dzRes['theme_style'];

                /* Header & Logo Setting */
                $page_header_setting    = $page_settings['page_header_setting'] ?? 'theme_default';
                if ($page_header_setting == 'custom') {
                    $dzRes['header_style'] = $page_settings['page_header_style'] ?? $dzRes['header_style'];   
                    $dzRes['header_color_mode'] = $page_settings['page_header_color_mode'] ?? $dzRes['header_color_mode'];
                }
                /* End Header & Logo Setting */
                
                
                /* Page banner setting */
                $page_banner_setting    = $page_settings['page_banner_setting'] ?? 'theme_default';
                if ($page_banner_setting == 'custom') {
                    $dzRes['show_banner'] = $page_settings['page_banner_on'] ?? $dzRes['show_banner'];
                    $dzRes['banner_image'] = !empty($page_settings['page_banner']) ? asset('storage/page-options/'.$page_settings['page_banner']) : $dzRes['banner_image'];
                    $dzRes['banner_height'] = $page_settings['page_banner_height'] ?? $dzRes['banner_height'];
                    $dzRes['banner_custom_height'] = $page_settings['page_banner_custom_height'] ?? $dzRes['banner_custom_height'];
                    $dzRes['banner_layout'] = $page_settings['page_banner_layout'] ?? $dzRes['banner_layout'];
                    $dzRes['dont_use_banner_image'] = $page_settings['page_banner_hide'] ?? $dzRes['dont_use_banner_image'];
                    $dzRes['show_breadcrumb'] = $page_settings['page_breadcrumb'] ?? $dzRes['show_breadcrumb'];
                }

                if($dzRes['dont_use_banner_image'] == 1){
                    $dzRes['banner_image'] = ''; 
                }
                /* End page banner setting */
                
                /* Sidebar and there layout */
                $dzRes['show_sidebar'] = isset($page_settings['page_show_sidebar']) ? $page_settings['page_show_sidebar'] : $dzRes['show_sidebar'];
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = $page_settings['page_sidebar_layout'] ?? $dzRes['layout'];
                    $dzRes['sidebar'] = $page_settings['page_sidebar'] ?? $dzRes['sidebar'];
                }
                /* End Sidebar and there layout */

                /* Post Footer Setting */
                $page_footer_setting    = $page_settings['page_footer_setting'] ?? 'theme_default';
                if ($page_footer_setting == 'custom') {
                    $dzRes['footer_on'] = $page_settings['page_footer_on'] ?? $dzRes['footer_on'];
                    $dzRes['footer_style'] = $page_settings['page_footer_style'] ?? $dzRes['footer_style'];
                    $dzRes['footer_social_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_social_on');
                    $dzRes['footer_bg_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_bg_image');
                    $dzRes['footer_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_image');
                    $dzRes['footer_title'] = config('ThemeOptions.'.$dzRes['footer_style'].'_title');
                    $dzRes['footer_marquee_tags'] = config('ThemeOptions.'.$dzRes['footer_style'].'_marquee_tags');
                    $dzRes['footer_newsletter'] = config('ThemeOptions.'.$dzRes['footer_style'].'_newsletter');
                    $dzRes['footer_sections'] = config('ThemeOptions.'.$dzRes['footer_style'].'_sections');
                    $dzRes['footer_copyright_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_copyright_on');
                }
                
            }

            /* single.blade.php */
            if($viewName == 'single') {

                $page_level_keys = array(
                    'featured_post',
                    'featured_image',
                    'post_header_setting',
                    'post_header_style',
                    'post_header_color_mode',
                    'post_banner',
                    'post_banner_on',
                    'post_banner_setting',
                    'post_banner_height',
                    'post_banner_custom_height',
                    'post_banner_hide',
                    'post_banner_layout',
                    'post_breadcrumb',
                    'post_footer_setting',
                    'post_footer_on',
                    'post_footer_style',


                    'post_layout',
                    'post_type_gallery1',
                    'post_type_gallery2',
                    'post_type_link',
                    'post_type_video',
                    'post_type_audio',
                    'post_show_sidebar',
                    'post_sidebar_layout',
                    'post_sidebar'
                );
                foreach($page_level_keys as $value)
                {
                    $page_settings[$value] =  \ThemeOption::GetBlogOptionById(optional($blog)->id, $value);
                }

                /* Post Header Setting */
                $post_header_setting    = $page_settings['post_header_setting'] ?? 'theme_default';
                if ($post_header_setting == 'custom') {
                    $dzRes['header_style'] = $page_settings['post_header_style'] ?? $dzRes['header_style'];
                    $dzRes['header_color_mode'] = $page_settings['post_header_color_mode'] ?? $dzRes['header_color_mode'];
                }

                /* Post Banner Setting */
                $post_banner_setting    = $page_settings['post_banner_setting'] ?? 'theme_default';
                if ($post_banner_setting == 'custom') {
                    $dzRes['show_banner'] = isset($page_settings['post_banner_on']) ? $page_settings['post_banner_on'] : $dzRes['show_banner'];
                    $dzRes['banner_image'] = !empty($page_settings['post_banner']) ? asset('storage/blog-options/'.$page_settings['post_banner']) : $dzRes['banner_image'];
                    $dzRes['banner_height'] = $page_settings['post_banner_height'] ?? $dzRes['banner_height'];
                    $dzRes['banner_custom_height'] = $page_settings['post_banner_custom_height'] ?? $dzRes['banner_custom_height'];
                    $dzRes['show_breadcrumb'] = $page_settings['post_breadcrumb'] ?? $dzRes['show_breadcrumb'];
                    $dzRes['banner_layout'] = $page_settings['post_banner_layout'] ?? $dzRes['banner_layout'];
                    $dzRes['dont_use_banner_image'] = $page_settings['post_banner_hide'] ?? $dzRes['dont_use_banner_image'];

                }
                
                if($dzRes['dont_use_banner_image'] == 1){
                    $dzRes['banner_image'] = '';
                }

                /* Post Footer Setting */
                $post_footer_setting    = $page_settings['post_footer_setting'] ?? 'theme_default';
                if ($post_footer_setting == 'custom') {
                    $dzRes['footer_on'] = $page_settings['post_footer_on'] ?? $dzRes['footer_on'];
                    $dzRes['footer_style'] = $page_settings['post_footer_style'] ?? $dzRes['footer_style'];
                     $dzRes['footer_social_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_social_on');
                    $dzRes['footer_bg_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_bg_image');
                    $dzRes['footer_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_image');
                    $dzRes['footer_title'] = config('ThemeOptions.'.$dzRes['footer_style'].'_title');
                    $dzRes['footer_marquee_tags'] = config('ThemeOptions.'.$dzRes['footer_style'].'_marquee_tags');
                    $dzRes['footer_newsletter'] = config('ThemeOptions.'.$dzRes['footer_style'].'_newsletter');
                    $dzRes['footer_sections'] = config('ThemeOptions.'.$dzRes['footer_style'].'_sections');
                    $dzRes['footer_copyright_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_copyright_on');
                }

                $dzRes['is_featured_post'] = $page_settings['featured_post'] ?? '';
                $dzRes['related_post_title'] = config('ThemeOptions.related_post_title', __('Related Blog'));
                $dzRes['featured_image'] = $page_settings['featured_image'] ?? $dzRes['featured_img_on'];

                /* Single Post Layout settings from post level */
                $dzRes['post_layout'] = $page_settings['post_layout'] ?? $dzRes['post_layout'];
                if($dzRes['post_layout'] == 'slider_post_1') {
                    $dzRes['post_gallary_setting'] = $page_settings['post_type_gallery1'] ?? '';
                }
                if($dzRes['post_layout'] == 'slider_post_2') {
                    $dzRes['post_gallary_setting'] = $page_settings['post_type_gallery2'] ?? '';
                }
                $dzRes['external_link'] = $page_settings['post_type_link'] ?? '';
                $dzRes['youtube_link'] = $page_settings['post_type_video'] ?? '';
                $dzRes['audio_link'] = $page_settings['post_type_audio'] ?? '';
                
                // Single post sidebar settings from post level.
                $dzRes['show_sidebar'] = $page_settings['post_show_sidebar'] ?? $dzRes['show_sidebar'];
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = $page_settings['post_sidebar_layout'] ??  $dzRes['layout'];
                    $dzRes['sidebar'] = $page_settings['post_sidebar'] ??  $dzRes['sidebar'];
                }

            }

            /* single cpt blade manage */
            if (str_contains($viewName, 'single') && !empty($cpt_list) && in_array(optional($blog)->post_type, $cpt_list)) {
                $post_type = !empty(optional($blog)->post_type) || optional($blog)->post_type != 'blog' ? optional($blog)->post_type : 'post'; 
                
                $page_level_keys = array(
                    'cpt_'.$post_type.'_featured_post',
                    'cpt_'.$post_type.'_featured_image',
                    'cpt_'.$post_type.'_header_setting',
                    'cpt_'.$post_type.'_header_style',
                    'cpt_'.$post_type.'_header_color_mode',
                    'cpt_'.$post_type.'_banner',
                    'cpt_'.$post_type.'_banner_on',
                    'cpt_'.$post_type.'_banner_setting',
                    'cpt_'.$post_type.'_banner_height',
                    'cpt_'.$post_type.'_banner_custom_height',
                    'cpt_'.$post_type.'_banner_hide',
                    'cpt_'.$post_type.'_banner_layout',
                    'cpt_'.$post_type.'_breadcrumb',
                    'cpt_'.$post_type.'_footer_setting',
                    'cpt_'.$post_type.'_footer_on',
                    'cpt_'.$post_type.'_footer_style',


                    'cpt_'.$post_type.'_editor_type',
                    'cpt_'.$post_type.'_layout',
                    'cpt_'.$post_type.'_show_sidebar',
                    'cpt_'.$post_type.'_sidebar_layout',
                    'cpt_'.$post_type.'_sidebar'
                );
                foreach($page_level_keys as $value)
                {
                    $page_settings[$value] =  \ThemeOption::GetBlogOptionById(optional($blog)->id, $value);
                }

                /* Post General Setting */
                $dzRes['page_title'] = config('ThemeOptions.cpt_'.$post_type.'_page_title');
                $dzRes['is_featured_post'] = $page_settings['cpt_'.$post_type.'_featured_post'] ?? '';
                $dzRes['cpt_'.$post_type.'_layout'] = $page_settings['cpt_'.$post_type.'_layout'] ?? config('ThemeOptions.cpt_'.$post_type.'_layout','style_1');
                $dzRes['cpt_'.$post_type.'_editor_type'] = $page_settings['cpt_'.$post_type.'_editor_type'] ?? config('ThemeOptions.cpt_'.$post_type.'_editor_type','text_editor');
                $dzRes['featured_img_on'] = config('ThemeOptions.cpt_'.$post_type.'_featured_image_on') ?? $dzRes['featured_img_on'];
                $dzRes['featured_image'] = $page_settings['cpt_'.$post_type.'_featured_image'] ?? $dzRes['featured_img_on'];

                /* Post Header Setting */
                $post_header_setting    = $page_settings['cpt_'.$post_type.'_header_setting'] ?? 'theme_default';
                if ($post_header_setting == 'custom') {
                    $dzRes['header_style'] = $page_settings['cpt_'.$post_type.'_header_style'] ?? $dzRes['header_style'];
                    $dzRes['header_color_mode'] = $page_settings['cpt_'.$post_type.'_header_color_mode'] ?? $dzRes['header_color_mode'];
                }

                /* Post Banner Setting */
                $post_banner_setting    = $page_settings['cpt_'.$post_type.'_banner_setting'] ?? 'theme_default';
                $cpt_show_banner = config('ThemeOptions.cpt_'.$post_type.'_banner_on');
                $dzRes['show_banner'] = isset($cpt_show_banner) ? $cpt_show_banner : $dzRes['show_banner'];
                $dzRes['banner_image'] = !empty(config('ThemeOptions.cpt_'.$post_type.'_banner')) ? asset('storage/blog-options/'.config('ThemeOptions.cpt_'.$post_type.'_banner')) : $dzRes['banner_image'];
                $dzRes['banner_height'] = config('ThemeOptions.cpt_'.$post_type.'_banner_height',$dzRes['banner_height']);
                $dzRes['banner_custom_height'] = config('ThemeOptions.cpt_'.$post_type.'_banner_custom_height',$dzRes['banner_custom_height']);
                $dzRes['show_breadcrumb'] = config('ThemeOptions.cpt_'.$post_type.'_breadcrumb',$dzRes['show_breadcrumb']);
                $dzRes['banner_layout'] = config('ThemeOptions.cpt_'.$post_type.'_breadcrumb',$dzRes['banner_layout']);
                $dzRes['dont_use_banner_image'] = config('ThemeOptions.cpt_'.$post_type.'_banner_hide',$dzRes['dont_use_banner_image']);

                if ($post_banner_setting == 'custom') {

                    $dzRes['show_banner'] = isset($page_settings['cpt_'.$post_type.'_banner_on']) ? $page_settings['cpt_'.$post_type.'_banner_on'] : $dzRes['show_banner'];
                    $dzRes['banner_image'] = !empty($page_settings['cpt_'.$post_type.'_banner']) ? asset('storage/blog-options/'.$page_settings['cpt_'.$post_type.'_banner']) : $dzRes['banner_image'];
                    $dzRes['banner_height'] = $page_settings['cpt_'.$post_type.'_banner_height'] ?? $dzRes['banner_height'];
                    $dzRes['banner_custom_height'] = $page_settings['cpt_'.$post_type.'_banner_custom_height'] ?? $dzRes['banner_custom_height'];
                    $dzRes['show_breadcrumb'] = $page_settings['cpt_'.$post_type.'_breadcrumb'] ?? $dzRes['show_breadcrumb'];
                    $dzRes['banner_layout'] = $page_settings['cpt_'.$post_type.'_banner_layout'] ?? $dzRes['banner_layout'];
                    $dzRes['dont_use_banner_image'] = $page_settings['cpt_'.$post_type.'_banner_hide'] ?? $dzRes['dont_use_banner_image'];
                }
                
                if($dzRes['dont_use_banner_image'] == 1){
                    $dzRes['banner_image'] = '';
                }

                $dzRes['cpt_layout'] = $page_settings['cpt_'.$post_type.'_layout'] ?? config('ThemeOptions.cpt_'.$post_type.'_layout','style_1');

                /* Post Footer Setting */
                $post_footer_setting    = $page_settings['cpt_'.$post_type.'_footer_setting'] ?? 'theme_default';
                if ($post_footer_setting == 'custom') {
                    $dzRes['footer_on'] = $page_settings['cpt_'.$post_type.'_footer_on'] ?? $dzRes['footer_on'];
                    $dzRes['footer_style'] = $page_settings['cpt_'.$post_type.'_footer_style'] ?? $dzRes['footer_style'];
                    $dzRes['footer_social_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_social_on');
                    $dzRes['footer_bg_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_bg_image');
                    $dzRes['footer_image'] = config('ThemeOptions.'.$dzRes['footer_style'].'_image');
                    $dzRes['footer_title'] = config('ThemeOptions.'.$dzRes['footer_style'].'_title');
                    $dzRes['footer_marquee_tags'] = config('ThemeOptions.'.$dzRes['footer_style'].'_marquee_tags');
                    $dzRes['footer_newsletter'] = config('ThemeOptions.'.$dzRes['footer_style'].'_newsletter');
                    $dzRes['footer_sections'] = config('ThemeOptions.'.$dzRes['footer_style'].'_sections');
                    $dzRes['footer_copyright_on'] = config('ThemeOptions.'.$dzRes['footer_style'].'_copyright_on');
                }
                
                // Single post sidebar settings from post level.
                $dzRes['show_sidebar'] = $page_settings['cpt_'.$post_type.'_show_sidebar'] ?? config('ThemeOptions.cpt_'.$post_type.'_show_sidebar',$dzRes['show_sidebar']);
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = $page_settings['cpt_'.$post_type.'_sidebar_layout'] ?? config('ThemeOptions.cpt_'.$post_type.'_sidebar_layout',$dzRes['layout']);
                    $dzRes['sidebar'] = $page_settings['cpt_'.$post_type.'_sidebar'] ??  config('ThemeOptions.cpt_'.$post_type.'_sidebar',$dzRes['sidebar']);
                }
            }

            /* archive.php */
            if($viewName == 'archive') {

                $testStr .= "This is archive page---";
                $dzRes['page_title'] = config('ThemeOptions.archive_page_title', __('Archive : '));
                
                /* Page banner setting */
                $dzRes['show_banner'] = config('ThemeOptions.archive_page_banner_on', $dzRes['show_banner']);
                $dzRes['banner_height'] = config('ThemeOptions.archive_page_banner_height', $dzRes['banner_height']);
                $dzRes['dont_use_banner_image'] = config('ThemeOptions.archive_page_banner_hide', '0');
                
                $dzRes['banner_custom_height'] = config('ThemeOptions.archive_page_banner_custom_height', $dzRes['banner_custom_height']);

                if($dzRes['dont_use_banner_image'] == 0){   
                    $dzRes['banner_image'] = config('ThemeOptions.archive_page_banner') ? asset('storage/theme-options/'.config('ThemeOptions.archive_page_banner')) : $dzRes['banner_image'];
                }
                else{
                    $dzRes['banner_image'] = "";
                }
                /* End Page banner setting */
                        
                /* Sidebar and there layout */
                $dzRes['show_sidebar'] = config('ThemeOptions.archive_page_show_sidebar',$dzRes['show_sidebar']);
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = config('ThemeOptions.archive_page_sidebar_layout', $dzRes['layout']);
                    $dzRes['sidebar'] = config('ThemeOptions.archive_page_sidebar', $dzRes['sidebar']);
                }
                /* End Sidebar and there layout */

                $pagination = config('ThemeOptions.archive_page_paging', $dzRes['disable_ajax_pagination']);
                $dzRes['disable_ajax_pagination'] = ($pagination == 'load_more') ? $pagination : '';
            }

            /* tag.blade.php */
            if($viewName == 'tag') {

                $testStr .= "This is tag page---";
                $dzRes['page_title'] = config('ThemeOptions.tag_page_title', __('Tag : '));

                /* Tag banner setting */
                $dzRes['show_banner'] = config('ThemeOptions.tag_page_banner_on', $dzRes['show_banner']);
                $dzRes['banner_height'] = config('ThemeOptions.tag_page_banner_height', $dzRes['banner_height']);
                $dzRes['dont_use_banner_image'] = config('ThemeOptions.tag_page_banner_hide', '0');
                
                $dzRes['banner_custom_height'] = config('ThemeOptions.tag_page_banner_custom_height', $dzRes['banner_custom_height']);

                if($dzRes['dont_use_banner_image'] == 0){
                    $dzRes['banner_image'] = config('ThemeOptions.tag_page_banner') ? asset('storage/theme-options/'.config('ThemeOptions.tag_page_banner')) : $dzRes['banner_image'];
                }
                else{
                    $dzRes['banner_image'] = "";
                }
                /* End Tag banner setting */
                
                /* Sidebar and there layout */
                $dzRes['show_sidebar'] = config('ThemeOptions.tag_page_show_sidebar', $dzRes['show_sidebar']);
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = config('ThemeOptions.tag_page_sidebar_layout', $dzRes['layout']);
                    $dzRes['sidebar'] = config('ThemeOptions.tag_page_sidebar', $dzRes['sidebar']);
                }
                /* End Sidebar and there layout */

                $pagination = config('ThemeOptions.tag_page_paging', $dzRes['disable_ajax_pagination']);
                $dzRes['disable_ajax_pagination'] = ($pagination == 'load_more') ? $pagination : '';
            }

            /* author.blade.php */
            if($viewName == 'author') {

                $testStr .= "This is Author page";
                $dzRes['page_title'] = config('ThemeOptions.author_page_title', __('Author : '));
                $dzRes['page_title'] = $dzRes['page_title'] . optional($user)->full_name;

                /* Tag banner setting */

                $dzRes['show_banner'] = config('ThemeOptions.author_page_banner_on', $dzRes['show_banner']);

                $dzRes['banner_height'] = config('ThemeOptions.author_page_banner_height', $dzRes['banner_height']);
                $dzRes['dont_use_banner_image'] = config('ThemeOptions.author_page_banner_hide', '0');
                
                $dzRes['banner_custom_height'] = config('ThemeOptions.author_page_banner_custom_height', $dzRes['banner_custom_height']);

                if($dzRes['dont_use_banner_image'] == 0){   
                    $dzRes['banner_image'] = config('ThemeOptions.author_page_banner') ? asset('storage/theme-options/'.config('ThemeOptions.author_page_banner')) : $dzRes['banner_image'];
                }
                else{
                    $dzRes['banner_image'] = "";
                }
                /* End Tag banner setting */
                
                $dzRes['show_banner'] = config('ThemeOptions.author_page_banner_on', $dzRes['show_banner']);
                if($dzRes['show_banner'] == true) {
                    $dzRes['banner_height'] = config('ThemeOptions.author_page_banner_height', $dzRes['banner_height']);
                    $dzRes['banner_image'] = config('ThemeOptions.author_page_banner') ? asset('storage/theme-options/'.config('ThemeOptions.author_page_banner')) : $dzRes['banner_image'];
                    $dzRes['dont_use_banner_image'] = config('ThemeOptions.author_page_banner_hide', '0');
                }

                /* Sidebar and there layout */
                $dzRes['show_sidebar'] = config('ThemeOptions.author_page_show_sidebar',$dzRes['show_sidebar']);
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = config('ThemeOptions.author_page_sidebar_layout', $dzRes['layout']);
                    $dzRes['sidebar'] = config('ThemeOptions.author_page_sidebar', $dzRes['sidebar']);
                }
                /* End Sidebar and there layout */

                $pagination = config('ThemeOptions.author_page_paging', $dzRes['disable_ajax_pagination']);
                $dzRes['disable_ajax_pagination'] = ($pagination == 'load_more') ? $pagination : '';
            }   

            /* search.php */
            if($viewName == 'search') {

                $testStr .= "This is Search Page";
                $dzRes['page_title'] = config('ThemeOptions.search_page_title', __('Search : '));

                /* Search banner setting */
                $dzRes['show_banner'] = config('ThemeOptions.search_page_banner_on', $dzRes['show_banner']);
                $dzRes['banner_height'] = config('ThemeOptions.search_page_banner_height', $dzRes['banner_height']);
                $dzRes['dont_use_banner_image'] = config('ThemeOptions.search_page_banner_hide', '0');
                
                $dzRes['banner_custom_height'] = config('ThemeOptions.search_page_banner_custom_height', $dzRes['banner_custom_height']);

                if($dzRes['dont_use_banner_image'] == 0){   
                    $dzRes['banner_image'] = config('ThemeOptions.search_page_banner') ? asset('storage/theme-options/'.config('ThemeOptions.search_page_banner')) : $dzRes['banner_image'];
                }
                else{
                    $dzRes['banner_image'] = "";
                }
                /* End Search banner setting */

                /* Sidebar and there layout */
                $dzRes['show_sidebar'] = config('ThemeOptions.search_page_show_sidebar', $dzRes['show_sidebar']);
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = config('ThemeOptions.search_page_sidebar_layout', $dzRes['layout']);
                    $dzRes['sidebar'] = config('ThemeOptions.search_page_sidebar', $dzRes['sidebar']);
                }
                /* End Sidebar and there layout */

                $pagination = config('ThemeOptions.search_page_paging', $dzRes['disable_ajax_pagination']);
                $dzRes['disable_ajax_pagination'] = ($pagination == 'load_more') ? $pagination : '';
            }

            /* 404.blade.php */
            if($viewName == '404') {

                if (is_file(storage_path('app/public/theme-options/'.config('ThemeOptions.error_404_image')))) {
                    $dzRes['error_404_image'] = asset('storage/theme-options/'.config('ThemeOptions.error_404_image'));
                }else {
                    $dzRes['error_404_image'] = theme_asset('images/w3options/error-404-bg.svg');
                }
                
                $dzRes['error_page_title'] = config('ThemeOptions.error_page_title', __('404') ); 
                $dzRes['error_page_template'] = config('ThemeOptions.error_page_template', 'error_style_1' ); 
                $dzRes['error_page_text'] = config('ThemeOptions.error_page_text', __('The Link You Folowed Probably Broken, or the page has been removed...'));
                $dzRes['error_page_button_text'] = config('ThemeOptions.error_page_button_text', __('Back to Home'));
            }

            /* category.php */
            if($viewName == 'category') {

                $testStr .= "This is Category page";
                $dzRes['page_title'] = config('ThemeOptions.category_page_title', __('Category : '));
                    
                /* Search banner setting */
                $dzRes['show_banner'] = config('ThemeOptions.category_page_banner_on', $dzRes['show_banner']);
                $dzRes['banner_height'] = config('ThemeOptions.category_page_banner_height', $dzRes['banner_height']);
                $dzRes['dont_use_banner_image'] = config('ThemeOptions.category_page_banner_hide', '0');
                
                $dzRes['banner_custom_height'] = config('ThemeOptions.category_page_banner_custom_height', $dzRes['banner_custom_height']);

                if($dzRes['dont_use_banner_image'] == 0){
                    $dzRes['banner_image'] = config('ThemeOptions.category_page_banner') ? asset('storage/theme-options/'.config('ThemeOptions.category_page_banner')) : $dzRes['banner_image'];
                }
                else{
                    $dzRes['banner_image'] = "";
                }
                /* End Search banner setting */
                        
                /* Sidebar and there layout */
                $dzRes['show_sidebar'] = config('ThemeOptions.category_page_show_sidebar',$dzRes['show_sidebar']);
                if($dzRes['show_sidebar'] == true) {
                    $dzRes['layout'] = config('ThemeOptions.category_page_sidebar_layout', $dzRes['layout']);
                    $dzRes['sidebar'] = config('ThemeOptions.category_page_sidebar', $dzRes['sidebar']);
                }
                /* End Sidebar and there layout */

                $pagination = config('ThemeOptions.category_page_paging', $dzRes['disable_ajax_pagination']);
                $dzRes['disable_ajax_pagination'] = ($pagination == 'load_more') ? $pagination : '';
                /* all other variable will manage on category page from db. */
            }

            /* header settings */
            $dzRes['header_login_on'] = config('ThemeOptions.header_login_on', '');
            $dzRes['header_register_on'] = config('ThemeOptions.header_register_on', '');
            $dzRes['show_login_registration'] = config('ThemeOptions.show_login_registration');
            $dzRes['header_sticky_on'] = config('ThemeOptions.header_sticky_on', '');
            $dzRes['header_sticky_class'] = ($dzRes['header_sticky_on'] == 1) ? 'sticky-header' : '';

            $dzRes['header_search_on'] = config('ThemeOptions.'. $dzRes['header_style'].'_search_on', '');
            $dzRes['header_search_button_title'] = config('ThemeOptions.'. $dzRes['header_style'].'_search_button_title','');
            $dzRes['header_social_link_on'] = config('ThemeOptions.'. $dzRes['header_style'].'_social_link_on', '');
            $dzRes['header_social_links'] = config('ThemeOptions.'. $dzRes['header_style'].'_social_links', '');
             $dzRes['header_contact_info'] = config('ThemeOptions.'. $dzRes['header_style'].'_contact_info', '');
            $dzRes['header_hamburger_position'] = config('ThemeOptions.'. $dzRes['header_style'].'_hamburger_position', 'left');
            $dzRes['header_theme_button'] = config('ThemeOptions.'. $dzRes['header_style'].'_theme_button', '');
            $dzRes['header_container_layout'] = config('ThemeOptions.'. $dzRes['header_style'].'_container_layout', 'container-fluid');

            $header_style_options = header_style_options();
            foreach($header_style_options as $header)
            {
                $call_to_action_button = $header['param']['call_to_action_button'] ?? 0;
                if($call_to_action_button > 0 )
                {                   
                    for($i = 1; $i <= $call_to_action_button; $i++ )
                    {
                        $dzRes['header_button_'.$i.'_text'] = config('ThemeOptions.'.$dzRes['header_style'].'_button_'.$i.'_text', '');
                        $dzRes['header_button_'.$i.'_url'] = config('ThemeOptions.'.$dzRes['header_style'].'_button_'.$i.'_url', ''); 
                        $dzRes['header_button_'.$i.'_target'] = config('ThemeOptions.'.$dzRes['header_style'].'_button_'.$i.'_target', '');
                    }
                }
            }

            $dzRes['mobile_header_login_on'] = config('ThemeOptions.mobile_header_login_on', '');
            $dzRes['mobile_header_register_on'] = config('ThemeOptions.mobile_header_register_on', '');
            $dzRes['mobile_header_social_link_on'] = config('ThemeOptions.'.$dzRes['header_style'].'_mobile_social_link_on', '');
            $dzRes['mobile_search_on'] = config('ThemeOptions.'.$dzRes['header_style'].'_mobile_search_on', '');

            $dzRes['site_email'] = config('ThemeOptions.site_email','');
            $dzRes['social_link_target'] = config('ThemeOptions.social_link_target','');
            $dzRes['show_social_icon'] = config('ThemeOptions.show_social_icon',false);
            $dzRes['email_text'] = config('ThemeOptions.email_text','');
            $dzRes['email_address'] = config('ThemeOptions.email_address','');
            $dzRes['phone_text'] = config('ThemeOptions.phone_text','');
            $dzRes['phone_number'] = config('ThemeOptions.phone_number','');
            $dzRes['address_text'] = config('ThemeOptions.address_text','');
            $dzRes['address'] = config('ThemeOptions.address','');
            $dzRes['social_shaing_on_post'] = config('ThemeOptions.social_shaing_on_post');
            /* End header settings */

            $dzRes['layout'] = (!$dzRes['show_sidebar'])?'sidebar_full':$dzRes['layout'];
            
            
            /*  Set All Option Values to dzRes Variable 
            *   and get it in every view of front to extract the dzRes array.
            */
            $w3cms_option = $dzRes;

            $view->with('w3cms_option', $w3cms_option);
        }
    }
}
