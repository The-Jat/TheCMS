<?php
require_once 'theme-options-data.php';
$DataFile = base_path('themes/'.config('Theme.select_theme').'/includes/W3Options/theme-options-data.php');
if (file_exists($DataFile)) {
    require_once $DataFile;
}


if (!function_exists('pr')) {
    function pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

if(!function_exists('get_coming_template_options')){
    function get_coming_template_options(){
        $result = array();
        $page_template_options = page_template_options();

        if(function_exists('_page_template_options')){
            $page_template_options = _page_template_options();
        }

        $temp = $page_template_options['coming'];
        
        foreach($temp as $key => $value)
        {
            $result[$value['id']] = $value['img'];
        }   
        return $result;
    }
}

if(!function_exists('get_maintenance_template_options')){
    function get_maintenance_template_options(){
        $result = array();
        $page_template_options = page_template_options();

        if(function_exists('_page_template_options')){
            $page_template_options = _page_template_options();
        }
        
        $temp = $page_template_options['maintenance'];
        
        foreach($temp as $key => $value)
        {
            $result[$value['id']] = $value['img'];
        }   
        return $result;
    }
}

if(!function_exists('get_error_template_options')){
    function get_error_template_options(){
        $result = array();
        $page_template_options = page_template_options();

        if(function_exists('_page_template_options')){
            $page_template_options = _page_template_options();
        }
        
        $temp = $page_template_options['error'];
        
        foreach($temp as $key => $value)
        {
            $result[$value['id']] = $value['img'];
        }   
        return $result;
    }
}

if(!function_exists('get_header_style_options')){
    function get_header_style_options(){
        $result = array();
        $header_style_options = header_style_options();
        
        if(function_exists('_header_style_options')){
            $header_style_options = _header_style_options();
        }

        foreach($header_style_options as $key => $value)
        {
            $result[$value['id']] = $value['img_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_footer_style_options')){
    function get_footer_style_options(){
        $result = array();
        $footer_style_options = footer_style_options();
        
        if(function_exists('_footer_style_options')){
            $footer_style_options = _footer_style_options();
        }

        foreach($footer_style_options as $key => $value)
        {
            $result[$value['id']] = $value['img_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_theme_style_options')){
    function get_theme_style_options(){
        $result = array();
        $theme_style_options = theme_style_options();
        
        if(function_exists('_theme_style_options')){
            $theme_style_options = _theme_style_options();
        }

        foreach($theme_style_options as $key => $value)
        {
            $result[$value['id']] = $value['img_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_page_banner_layout_options')){
    function get_page_banner_layout_options(){
        $result = array();
        $page_banner_layout_options = page_banner_layout_options();
        
        if(function_exists('_page_banner_layout_options')){
            $page_banner_layout_options = _page_banner_layout_options();
        }

        foreach($page_banner_layout_options as $key => $value)
        {
            $result[$value['id']] = $value['img_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_sidebar_layout_options')){
    function get_sidebar_layout_options(){
        $result = array();
        $sidebar_layout_options = sidebar_layout_options();

        if(function_exists('_sidebar_layout_options')){
            $sidebar_layout_options = array_merge($sidebar_layout_options,_sidebar_layout_options());
        }
                
        foreach($sidebar_layout_options as $key => $value)
        {
            $result[$value['id']] = $value['sidebar_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_post_layouts_options')){
    function get_post_layouts_options(){
        $result = array();
        $post_layouts_options = post_layouts_options();
        
        if(function_exists('_post_layouts_options')){
            $post_layouts_options = array_merge($post_layouts_options,_post_layouts_options());
        }
                
        foreach($post_layouts_options as $key => $value)
        {
            $result[$value['id']] = $value['layout_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_cpt_layouts_options')){
    function get_cpt_layouts_options($cpt_id){
        $result = array();
        $post_layouts_options = array();
        
        if(function_exists("{$cpt_id}_layouts_options")){
            $post_layouts_options = array_merge($post_layouts_options,call_user_func("{$cpt_id}_layouts_options"));
        }

        if(function_exists("_{$cpt_id}_layouts_options")){
            $post_layouts_options = array_merge($post_layouts_options,call_user_func("_{$cpt_id}_layouts_options"));
        }
                
        foreach($post_layouts_options as $key => $value)
        {
            $result[$value['id']] = $value['layout_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_post_wrapper_options')){
    function get_post_wrapper_options(){
        $result = array();
        $post_wrapper_options = post_wrapper_options();
                
        foreach($post_wrapper_options as $key => $value)
        {
            $result[$value['id']] = $value['img_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_post_listing_options')){
    function get_post_listing_options(){
        $result = array();
        $post_listing_options = post_listing_options();

        if(function_exists('_post_listing_options')){
            $post_listing_options = array_merge($post_listing_options,_post_listing_options());
        }
                
        foreach($post_listing_options as $key => $value)
        {
            $result[$value['id']] = $value['listing_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_page_banner_options')){
    function get_page_banner_options(){
        $result = array();
        $page_banner_options = page_banner_options();

        if(function_exists('_page_banner_options')){
            $page_banner_options = array_merge($page_banner_options,_page_banner_options());
        }
                
        foreach($page_banner_options as $key => $value)
        {
            $result[$value['id']] = $value['banner_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_post_banner_options')){
    function get_post_banner_options(){
        $result = array();
        $post_banner_options = post_banner_options();

        if(function_exists('_post_banner_options')){
            $post_banner_options = array_merge($post_banner_options,_post_banner_options());
        }
                
        foreach($post_banner_options as $key => $value)
        {
            $result[$value['id']] = $value['post_banner_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_theme_layout_options')){
    function get_theme_layout_options(){
        $result = array();
        $theme_layout_options = theme_layout_options();

        if(function_exists('_theme_layout_options')){
            $theme_layout_options = array_merge($theme_layout_options,_theme_layout_options());
        }
                
        foreach($theme_layout_options as $key => $value)
        {
            $result[$value['id']] = $value['img_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_theme_color_background_options')){
    function get_theme_color_background_options(){
        $result = array();
        $theme_color_background_options = theme_color_background_options();
        
        if(function_exists('_theme_color_background_options')){
            $theme_color_background_options = array_merge($theme_color_background_options,_theme_color_background_options());
        }

        foreach($theme_color_background_options as $key => $value)
        {
            $result[$value['id']] = $value['img_param'];
        }   
        return $result;
    }
}

if(!function_exists('get_theme_image_background_options')){
    function get_theme_image_background_options(){
        $result = array();
        $theme_image_background_options = theme_image_background_options();

        if(function_exists('_theme_image_background_options')){
            $theme_image_background_options = array_merge($theme_image_background_options,_theme_image_background_options());
        }
                
        foreach($theme_image_background_options as $key => $value)
        {
            $result[$value['id']] = $value['img'];
        }   
        return $result;
    }
}

if(!function_exists('get_theme_pattern_background_options')){
    function get_theme_pattern_background_options(){
        $result = array();
        $theme_pattern_background_options = theme_pattern_background_options();

        if(function_exists('_theme_pattern_background_options')){
            $theme_pattern_background_options = array_merge($theme_pattern_background_options,_theme_pattern_background_options());
        }
                
        foreach($theme_pattern_background_options as $key => $value)
        {
            $result[$value['id']] = $value['img'];
        }   
        return $result;
    }
}

if(!function_exists('get_theme_color_options')){
    function get_theme_color_options(){
        $result = array();
        $theme_color_options = theme_color_options();
        
        if(function_exists('_theme_color_options')){
            $theme_color_options = array_merge($theme_color_options,_theme_color_options());
        }

        foreach($theme_color_options as $key => $value)
        {
            $result[$value['id']] = $value['img'];
        }   
        return $result;
    }
}

if(!function_exists('get_page_loader_options')){
    function get_page_loader_options(){
        $result = array();
        $page_loader_options = page_loader_options();

        if(function_exists('_page_loader_options')){
            $page_loader_options = array_merge($page_loader_options,_page_loader_options());
        }
                
        foreach($page_loader_options as $key => $value)
        {
            $result[$value['id']] = $value['img'];
        }   
        return $result;
    }
}

if(!function_exists('get_sort_by_options')){
    function get_sort_by_options(){
        $sort_by_options = sort_by_options();
        return $sort_by_options;
    }
}

if(!function_exists('get_link_target_options')){
    function get_link_target_options(){
        $link_target_options = link_target_options();
        return $link_target_options;
    }
}

if(!function_exists('get_adsence_size_options')){
    function get_adsence_size_options(){
        $adsence_size_options = adsence_size_options();
        return $adsence_size_options;
    }
}

if(!function_exists('get_social_link_options')){
    function get_social_link_options(){
        $social_link_options = social_link_options();
        return $social_link_options;
    }
}


if(!function_exists('get_fontawesome_icon'))
{
    
    function get_fontawesome_icon(){
        $icon_arr = array('fa fa-address-book','fa fa-address-book-o','fa fa-address-card','fa fa-address-card-o','fa fa-adjust','fa fa-adn','fa fa-align-center','fa fa-align-justify','fa fa-align-left','fa fa-align-right','fa fa-amazon','fa fa-ambulance','fa fa-american-sign-language-interpreting','fa fa-anchor','fa fa-android','fa fa-angellist','fa fa-angle-double-down','fa fa-angle-double-left','fa fa-angle-double-right','fa fa-angle-double-up','fa fa-angle-down','fa fa-angle-left','fa fa-angle-right','fa fa-angle-up','fa fa-apple','fa fa-archive','fa fa-area-chart','fa fa-arrow-circle-down','fa fa-arrow-circle-left','fa fa-arrow-circle-o-down','fa fa-arrow-circle-o-left','fa fa-arrow-circle-o-right','fa fa-arrow-circle-o-up','fa fa-arrow-circle-right','fa fa-arrow-circle-up','fa fa-arrow-down','fa fa-arrow-left','fa fa-arrow-right','fa fa-arrow-up','fa fa-arrows','fa fa-arrows-alt','fa fa-arrows-h','fa fa-arrows-v','fa fa-asl-interpreting','fa fa-assistive-listening-systems','fa fa-asterisk','fa fa-at','fa fa-audio-description','fa fa-automobile','fa fa-backward','fa fa-balance-scale','fa fa-ban','fa fa-bandcamp','fa fa-bank','fa fa-bar-chart','fa fa-bar-chart-o','fa fa-barcode','fa fa-bars','fa fa-bath','fa fa-bathtub','fa fa-battery','fa fa-battery-0','fa fa-battery-1','fa fa-battery-2','fa fa-battery-3','fa fa-battery-4','fa fa-battery-empty','fa fa-battery-full','fa fa-battery-half','fa fa-battery-quarter','fa fa-battery-three-quarters','fa fa-bed','fa fa-beer','fa fa-behance','fa fa-behance-square','fa fa-bell','fa fa-bell-o','fa fa-bell-slash','fa fa-bell-slash-o','fa fa-bicycle','fa fa-binoculars','fa fa-birthday-cake','fa fa-bitbucket','fa fa-bitbucket-square','fa fa-bitcoin','fa fa-black-tie','fa fa-blind','fa fa-bluetooth','fa fa-bluetooth-b','fa fa-bold','fa fa-bolt','fa fa-bomb','fa fa-book','fa fa-bookmark','fa fa-bookmark-o','fa fa-braille','fa fa-briefcase','fa fa-btc','fa fa-bug','fa fa-building','fa fa-building-o','fa fa-bullhorn','fa fa-bullseye','fa fa-bus','fa fa-buysellads','fa fa-cab','fa fa-calculator','fa fa-calendar','fa fa-calendar-check-o','fa fa-calendar-minus-o','fa fa-calendar-o','fa fa-calendar-plus-o','fa fa-calendar-times-o','fa fa-camera','fa fa-camera-retro','fa fa-car','fa fa-caret-down','fa fa-caret-left','fa fa-caret-right','fa fa-caret-square-o-down','fa fa-caret-square-o-left','fa fa-caret-square-o-right','fa fa-caret-square-o-up','fa fa-caret-up','fa fa-cart-arrow-down','fa fa-cart-plus','fa fa-cc','fa fa-cc-amex','fa fa-cc-diners-club','fa fa-cc-discover','fa fa-cc-jcb','fa fa-cc-mastercard','fa fa-cc-paypal','fa fa-cc-stripe','fa fa-cc-visa','fa fa-certificate','fa fa-chain','fa fa-chain-broken','fa fa-check','fa fa-check-circle','fa fa-check-circle-o','fa fa-check-square','fa fa-check-square-o','fa fa-chevron-circle-down','fa fa-chevron-circle-left','fa fa-chevron-circle-right','fa fa-chevron-circle-up','fa fa-chevron-down','fa fa-chevron-left','fa fa-chevron-right','fa fa-chevron-up','fa fa-child','fa fa-chrome','fa fa-circle','fa fa-circle-o','fa fa-circle-o-notch','fa fa-circle-thin','fa fa-clipboard','fa fa-clock-o','fa fa-clone','fa fa-close','fa fa-cloud','fa fa-cloud-download','fa fa-cloud-upload','fa fa-cny','fa fa-code','fa fa-code-fork','fa fa-codepen','fa fa-codiepie','fa fa-coffee','fa fa-cog','fa fa-cogs','fa fa-columns','fa fa-comment','fa fa-comment-o','fa fa-commenting','fa fa-commenting-o','fa fa-comments','fa fa-comments-o','fa fa-compass','fa fa-compress','fa fa-connectdevelop','fa fa-contao','fa fa-copy','fa fa-copyright','fa fa-creative-commons','fa fa-credit-card','fa fa-credit-card-alt','fa fa-crop','fa fa-crosshairs','fa fa-css3','fa fa-cube','fa fa-cubes','fa fa-cut','fa fa-cutlery','fa fa-dashboard','fa fa-dashcube','fa fa-database','fa fa-deaf','fa fa-deafness','fa fa-dedent','fa fa-delicious','fa fa-desktop','fa fa-deviantart','fa fa-diamond','fa fa-digg','fa fa-dollar','fa fa-dot-circle-o','fa fa-download','fa fa-dribbble','fa fa-drivers-license','fa fa-drivers-license-o','fa fa-dropbox','fa fa-drupal','fa fa-edge','fa fa-edit','fa fa-eercast','fa fa-eject','fa fa-ellipsis-h','fa fa-ellipsis-v','fa fa-empire','fa fa-envelope','fa fa-envelope-o','fa fa-envelope-open','fa fa-envelope-open-o','fa fa-envelope-square','fa fa-envira','fa fa-eraser','fa fa-etsy','fa fa-eur','fa fa-euro','fa fa-exchange','fa fa-exclamation','fa fa-exclamation-circle','fa fa-exclamation-triangle','fa fa-expand','fa fa-expeditedssl','fa fa-external-link','fa fa-external-link-square','fa fa-eye','fa fa-eye-slash','fa fa-eyedropper','fa fa-fa','fa fa-facebook','fa fa-facebook-f','fa fa-facebook-official','fa fa-facebook-square','fa fa-fast-backward','fa fa-fast-forward','fa fa-fax','fa fa-feed','fa fa-female','fa fa-fighter-jet','fa fa-file','fa fa-file-archive-o','fa fa-file-audio-o','fa fa-file-code-o','fa fa-file-excel-o','fa fa-file-image-o','fa fa-file-movie-o','fa fa-file-o','fa fa-file-pdf-o','fa fa-file-photo-o','fa fa-file-picture-o','fa fa-file-powerpoint-o','fa fa-file-sound-o','fa fa-file-text','fa fa-file-text-o','fa fa-file-video-o','fa fa-file-word-o','fa fa-file-zip-o','fa fa-files-o','fa fa-film','fa fa-filter','fa fa-fire','fa fa-fire-extinguisher','fa fa-firefox','fa fa-first-order','fa fa-flag','fa fa-flag-checkered','fa fa-flag-o','fa fa-flash','fa fa-flask','fa fa-flickr','fa fa-floppy-o','fa fa-folder','fa fa-folder-o','fa fa-folder-open','fa fa-folder-open-o','fa fa-font','fa fa-font-awesome','fa fa-fonticons','fa fa-fort-awesome','fa fa-forumbee','fa fa-forward','fa fa-foursquare','fa fa-free-code-camp','fa fa-frown-o','fa fa-futbol-o','fa fa-gamepad','fa fa-gavel','fa fa-gbp','fa fa-ge','fa fa-gear','fa fa-gears','fa fa-genderless','fa fa-get-pocket','fa fa-gg','fa fa-gg-circle','fa fa-gift','fa fa-git','fa fa-git-square','fa fa-github','fa fa-github-alt','fa fa-github-square','fa fa-gitlab','fa fa-gittip','fa fa-glass','fa fa-glide','fa fa-glide-g','fa fa-globe','fa fa-google','fa fa-google-plus','fa fa-google-plus-circle','fa fa-google-plus-official','fa fa-google-plus-square','fa fa-google-wallet','fa fa-graduation-cap','fa fa-gratipay','fa fa-grav','fa fa-group','fa fa-h-square','fa fa-hacker-news','fa fa-hand-grab-o','fa fa-hand-lizard-o','fa fa-hand-o-down','fa fa-hand-o-left','fa fa-hand-o-right','fa fa-hand-o-up','fa fa-hand-paper-o','fa fa-hand-peace-o','fa fa-hand-pointer-o','fa fa-hand-rock-o','fa fa-hand-scissors-o','fa fa-hand-spock-o','fa fa-hand-stop-o','fa fa-handshake-o','fa fa-hard-of-hearing','fa fa-hashtag','fa fa-hdd-o','fa fa-header','fa fa-headphones','fa fa-heart','fa fa-heart-o','fa fa-heartbeat','fa fa-history','fa fa-home','fa fa-hospital-o','fa fa-hotel','fa fa-hourglass','fa fa-hourglass-1','fa fa-hourglass-2','fa fa-hourglass-3','fa fa-hourglass-end','fa fa-hourglass-half','fa fa-hourglass-o','fa fa-hourglass-start','fa fa-houzz','fa fa-html5','fa fa-i-cursor','fa fa-id-badge','fa fa-id-card','fa fa-id-card-o','fa fa-ils','fa fa-image','fa fa-imdb','fa fa-inbox','fa fa-indent','fa fa-industry','fa fa-info','fa fa-info-circle','fa fa-inr','fa fa-instagram','fa fa-institution','fa fa-internet-explorer','fa fa-intersex','fa fa-ioxhost','fa fa-italic','fa fa-joomla','fa fa-jpy','fa fa-jsfiddle','fa fa-key','fa fa-keyboard-o','fa fa-krw','fa fa-language','fa fa-laptop','fa fa-lastfm','fa fa-lastfm-square','fa fa-leaf','fa fa-leanpub','fa fa-legal','fa fa-lemon-o','fa fa-level-down','fa fa-level-up','fa fa-life-bouy','fa fa-life-buoy','fa fa-life-ring','fa fa-life-saver','fa fa-lightbulb-o','fa fa-line-chart','fa fa-link','fa fa-linkedin','fa fa-linkedin-square','fa fa-linode','fa fa-linux','fa fa-list','fa fa-list-alt','fa fa-list-ol','fa fa-list-ul','fa fa-location-arrow','fa fa-lock','fa fa-long-arrow-down','fa fa-long-arrow-left','fa fa-long-arrow-right','fa fa-long-arrow-up','fa fa-low-vision','fa fa-magic','fa fa-magnet','fa fa-mail-forward','fa fa-mail-reply','fa fa-mail-reply-all','fa fa-male','fa fa-map','fa fa-map-marker','fa fa-map-o','fa fa-map-pin','fa fa-map-signs','fa fa-mars','fa fa-mars-double','fa fa-mars-stroke','fa fa-mars-stroke-h','fa fa-mars-stroke-v','fa fa-maxcdn','fa fa-meanpath','fa fa-medium','fa fa-medkit','fa fa-meetup','fa fa-meh-o','fa fa-mercury','fa fa-microchip','fa fa-microphone','fa fa-microphone-slash','fa fa-minus','fa fa-minus-circle','fa fa-minus-square','fa fa-minus-square-o','fa fa-mixcloud','fa fa-mobile','fa fa-mobile-phone','fa fa-modx','fa fa-money','fa fa-moon-o','fa fa-mortar-board','fa fa-motorcycle','fa fa-mouse-pointer','fa fa-music','fa fa-navicon','fa fa-neuter','fa fa-newspaper-o','fa fa-object-group','fa fa-object-ungroup','fa fa-odnoklassniki','fa fa-odnoklassniki-square','fa fa-opencart','fa fa-openid','fa fa-opera','fa fa-optin-monster','fa fa-outdent','fa fa-pagelines','fa fa-paint-brush','fa fa-paper-plane','fa fa-paper-plane-o','fa fa-paperclip','fa fa-paragraph','fa fa-paste','fa fa-pause','fa fa-pause-circle','fa fa-pause-circle-o','fa fa-paw','fa fa-paypal','fa fa-pencil','fa fa-pencil-square','fa fa-pencil-square-o','fa fa-percent','fa fa-phone','fa fa-phone-square','fa fa-photo','fa fa-picture-o','fa fa-pie-chart','fa fa-pied-piper','fa fa-pied-piper-alt','fa fa-pied-piper-pp','fa fa-pinterest','fa fa-pinterest-p','fa fa-pinterest-square','fa fa-plane','fa fa-play','fa fa-play-circle','fa fa-play-circle-o','fa fa-plug','fa fa-plus','fa fa-plus-circle','fa fa-plus-square','fa fa-plus-square-o','fa fa-podcast','fa fa-power-off','fa fa-print','fa fa-product-hunt','fa fa-puzzle-piece','fa fa-qq','fa fa-qrcode','fa fa-question','fa fa-question-circle','fa fa-question-circle-o','fa fa-quora','fa fa-quote-left','fa fa-quote-right','fa fa-ra','fa fa-random','fa fa-ravelry','fa fa-rebel','fa fa-recycle','fa fa-reddit','fa fa-reddit-alien','fa fa-reddit-square','fa fa-refresh','fa fa-registered','fa fa-remove','fa fa-renren','fa fa-reorder','fa fa-repeat','fa fa-reply','fa fa-reply-all','fa fa-resistance','fa fa-retweet','fa fa-rmb','fa fa-road','fa fa-rocket','fa fa-rotate-left','fa fa-rotate-right','fa fa-rouble','fa fa-rss','fa fa-rss-square','fa fa-rub','fa fa-ruble','fa fa-rupee','fa fa-s15','fa fa-safari','fa fa-save','fa fa-scissors','fa fa-scribd','fa fa-search','fa fa-search-minus','fa fa-search-plus','fa fa-sellsy','fa fa-send','fa fa-send-o','fa fa-server','fa fa-share','fa fa-share-alt','fa fa-share-alt-square','fa fa-share-square','fa fa-share-square-o','fa fa-shekel','fa fa-sheqel','fa fa-shield','fa fa-ship','fa fa-shirtsinbulk','fa fa-shopping-bag','fa fa-shopping-basket','fa fa-shopping-cart','fa fa-shower','fa fa-sign-in','fa fa-sign-language','fa fa-sign-out','fa fa-signal','fa fa-signing','fa fa-simplybuilt','fa fa-sitemap','fa fa-skyatlas','fa fa-skype','fa fa-slack','fa fa-sliders','fa fa-slideshare','fa fa-smile-o','fa fa-snapchat','fa fa-snapchat-ghost','fa fa-snapchat-square','fa fa-snowflake-o','fa fa-soccer-ball-o','fa fa-sort','fa fa-sort-alpha-asc','fa fa-sort-alpha-desc','fa fa-sort-amount-asc','fa fa-sort-amount-desc','fa fa-sort-asc','fa fa-sort-desc','fa fa-sort-down','fa fa-sort-numeric-asc','fa fa-sort-numeric-desc','fa fa-sort-up','fa fa-soundcloud','fa fa-space-shuttle','fa fa-spinner','fa fa-spoon','fa fa-spotify','fa fa-square','fa fa-square-o','fa fa-stack-exchange','fa fa-stack-overflow','fa fa-star','fa fa-star-half','fa fa-star-half-empty','fa fa-star-half-full','fa fa-star-half-o','fa fa-star-o','fa fa-steam','fa fa-steam-square','fa fa-step-backward','fa fa-step-forward','fa fa-stethoscope','fa fa-sticky-note','fa fa-sticky-note-o','fa fa-stop','fa fa-stop-circle','fa fa-stop-circle-o','fa fa-street-view','fa fa-strikethrough','fa fa-stumbleupon','fa fa-stumbleupon-circle','fa fa-subscript','fa fa-subway','fa fa-suitcase','fa fa-sun-o','fa fa-superpowers','fa fa-superscript','fa fa-support','fa fa-table','fa fa-tablet','fa fa-tachometer','fa fa-tag','fa fa-tags','fa fa-tasks','fa fa-taxi','fa fa-telegram','fa fa-television','fa fa-tencent-weibo','fa fa-terminal','fa fa-text-height','fa fa-text-width','fa fa-th','fa fa-th-large','fa fa-th-list','fa fa-themeisle','fa fa-thermometer','fa fa-thermometer-0','fa fa-thermometer-1','fa fa-thermometer-2','fa fa-thermometer-3','fa fa-thermometer-4','fa fa-thermometer-empty','fa fa-thermometer-full','fa fa-thermometer-half','fa fa-thermometer-quarter','fa fa-thermometer-three-quarters','fa fa-thumb-tack','fa fa-thumbs-down','fa fa-thumbs-o-down','fa fa-thumbs-o-up','fa fa-thumbs-up','fa fa-ticket','fa fa-times','fa fa-times-circle','fa fa-times-circle-o','fa fa-times-rectangle','fa fa-times-rectangle-o','fa fa-tint','fa fa-toggle-down','fa fa-toggle-left','fa fa-toggle-off','fa fa-toggle-on','fa fa-toggle-right','fa fa-toggle-up','fa fa-trademark','fa fa-train','fa fa-transgender','fa fa-transgender-alt','fa fa-trash','fa fa-trash-o','fa fa-tree','fa fa-trello','fa fa-tripadvisor','fa fa-trophy','fa fa-truck','fa fa-try','fa fa-tty','fa fa-tumblr','fa fa-tumblr-square','fa fa-turkish-lira','fa fa-tv','fa fa-twitch','fa fa-twitter','fa fa-twitter-square','fa fa-umbrella','fa fa-underline','fa fa-undo','fa fa-universal-access','fa fa-university','fa fa-unlink','fa fa-unlock','fa fa-unlock-alt','fa fa-unsorted','fa fa-upload','fa fa-usb','fa fa-usd','fa fa-user','fa fa-user-circle','fa fa-user-circle-o','fa fa-user-md','fa fa-user-o','fa fa-user-plus','fa fa-user-secret','fa fa-user-times','fa fa-users','fa fa-vcard','fa fa-vcard-o','fa fa-venus','fa fa-venus-double','fa fa-venus-mars','fa fa-viacoin','fa fa-viadeo','fa fa-viadeo-square','fa fa-video-camera','fa fa-vimeo','fa fa-vimeo-square','fa fa-vine','fa fa-vk','fa fa-volume-control-phone','fa fa-volume-down','fa fa-volume-off','fa fa-volume-up','fa fa-warning','fa fa-wechat','fa fa-weibo','fa fa-weixin','fa fa-whatsapp','fa fa-wheelchair','fa fa-wheelchair-alt','fa fa-wifi','fa fa-wikipedia-w','fa fa-window-close','fa fa-window-close-o','fa fa-window-maximize','fa fa-window-minimize','fa fa-window-restore','fa fa-windows','fa fa-won','fa fa-wordpress','fa fa-wpbeginner','fa fa-wpexplorer','fa fa-wpforms','fa fa-wrench','fa fa-xing','fa fa-xing-square','fa fa-y-combinator','fa fa-y-combinator-square','fa fa-yahoo','fa fa-yc','fa fa-yc-square','fa fa-yelp','fa fa-yen','fa fa-yoast','fa fa-youtube','fa fa-youtube-play','fa fa-youtube-square');
        
        $icons = array();
        foreach($icon_arr as $icon){
            $icons[$icon] = ucwords(str_replace('-',' ',str_replace('fa fa-','',$icon)));
        }
        
        return $icons;
    }
}

if(!function_exists('get_flaticon_icon'))
{
    
    function get_flaticon_icon(){
        $flaticon = array ('flaticon-play','flaticon-athletics','flaticon-exercise','flaticon-man','flaticon-exercise-1','flaticon-kettlebell','flaticon-lifting','flaticon-gym','flaticon-exercise-2','flaticon-fitness','flaticon-calendar','flaticon-medal','flaticon-user','flaticon-left-quotes-sign','flaticon-phone-call','flaticon-home','flaticon-page','flaticon-text-document','flaticon-heart','flaticon-headphones','flaticon-blogging','flaticon-blog','flaticon-contact-center','flaticon-email,flaticon-email-1','flaticon-envelope','flaticon-dumbbell','flaticon-kettlebell-1','flaticon-gym-1','flaticon-gym-2','flaticon-stationary-bike','flaticon-exercise-3','flaticon-gym-3','flaticon-skipping-rope','flaticon-supplement-bottle','flaticon-kettlebell-2','flaticon-gym-machine','flaticon-gym-equipment','flaticon-settings','flaticon-menu','flaticon-menu-1','flaticon-loupe','flaticon-notification-bell','flaticon-settings-1','flaticon-star','flaticon-close','flaticon-share','flaticon-down-arrow','flaticon-verify','flaticon-check-mark','flaticon-paper-plane');
        
    $icons = array();
        foreach($flaticon as $icon){
            $icons[$icon] = ucwords(str_replace('-',' ',str_replace('flaticon-','',$icon)));
        }
    
        return $icons;
    }
}

if(!function_exists('get_themify_icon'))
{
    
    function get_themify_icon(){
        $themify = array (
             'ti-wand','ti-volume','ti-user' ,'ti-unlock' ,'ti-unlink' ,'ti-trash' ,'ti-thought' ,'ti-target' ,'ti-tag' ,'ti-tablet' ,'ti-star' ,'ti-spray' ,'ti-signal' ,'ti-shopping-cart' ,'ti-shopping-cart-full' ,'ti-settings' ,'ti-search' ,'ti-zoom-in' ,'ti-zoom-out' ,'ti-cut' ,'ti-ruler' ,'ti-ruler-pencil' ,'ti-ruler-alt' ,'ti-bookmark' ,'ti-bookmark-alt' ,'ti-reload' ,'ti-plus' ,'ti-pin' ,'ti-pencil' ,'ti-pencil-alt' ,'ti-paint-roller' ,'ti-paint-bucket' ,'ti-na' ,'ti-mobile' ,'ti-minus' ,'ti-medall' ,'ti-medall-alt' ,'ti-marker' ,'ti-marker-alt' ,'ti-arrow-up' ,'ti-arrow-right' ,'ti-arrow-left' ,'ti-arrow-down' ,'ti-lock' ,'ti-location-arrow' ,'ti-link' ,'ti-layout' ,'ti-layers' ,'ti-layers-alt' ,'ti-key' ,'ti-import' ,'ti-image' ,'ti-heart' ,'ti-heart-broken' ,'ti-hand-stop' ,'ti-hand-open' ,'ti-hand-drag' ,'ti-folder' ,'ti-flag' ,'ti-flag-alt' ,'ti-flag-alt-2' ,'ti-eye' ,'ti-export' ,'ti-exchange-vertical' ,'ti-desktop' ,'ti-cup' ,'ti-crown' ,'ti-comments' ,'ti-comment' ,'ti-comment-alt' ,'ti-close' ,'ti-clip' ,'ti-angle-up' ,'ti-angle-right' ,'ti-angle-left' ,'ti-angle-down' ,'ti-check' ,'ti-check-box' ,'ti-camera' ,'ti-announcement' ,'ti-brush' ,'ti-briefcase' ,'ti-bolt' ,'ti-bolt-alt' ,'ti-blackboard' ,'ti-bag' ,'ti-move' ,'ti-arrows-vertical' ,'ti-arrows-horizontal' ,'ti-fullscreen' ,'ti-arrow-top-right' ,'ti-arrow-top-left' ,'ti-arrow-circle-up' ,'ti-arrow-circle-right' ,'ti-arrow-circle-left' ,'ti-arrow-circle-down' ,'ti-angle-double-up' ,'ti-angle-double-right' ,'ti-angle-double-left' ,'ti-angle-double-down' ,'ti-zip' ,'ti-world' ,'ti-wheelchair' ,'ti-view-list' ,'ti-view-list-alt' ,'ti-view-grid' ,'ti-uppercase' ,'ti-upload' ,'ti-underline' ,'ti-truck' ,'ti-timer' ,'ti-ticket' ,'ti-thumb-up' ,'ti-thumb-down' ,'ti-text' ,'ti-stats-up' ,'ti-stats-down' ,'ti-split-v' ,'ti-split-h' ,'ti-smallcap' ,'ti-shine' ,'ti-shift-right' ,'ti-shift-left' ,'ti-shield' ,'ti-notepad' ,'ti-server' ,'ti-quote-right' ,'ti-quote-left' ,'ti-pulse' ,'ti-printer' ,'ti-power-off' ,'ti-plug' ,'ti-pie-chart' ,'ti-paragraph' ,'ti-panel' ,'ti-package' ,'ti-music' ,'ti-music-alt' ,'ti-mouse' ,'ti-mouse-alt' ,'ti-money' ,'ti-microphone' ,'ti-menu' ,'ti-menu-alt' ,'ti-map' ,'ti-map-alt' ,'ti-loop' ,'ti-location-pin' ,'ti-list' ,'ti-light-bulb' ,'ti-italic' ,'ti-info' ,'ti-infinite' ,'ti-id-badge' ,'ti-hummer' ,'ti-home' ,'ti-help' ,'ti-headphone' ,'ti-harddrives' ,'ti-harddrive' ,'ti-gift' ,'ti-game' ,'ti-filter' ,'ti-files' ,'ti-file' ,'ti-eraser' ,'ti-envelope' ,'ti-download' ,'ti-direction' ,'ti-direction-alt' ,'ti-dashboard' ,'ti-control-stop' ,'ti-control-shuffle' ,'ti-control-play' ,'ti-control-pause' ,'ti-control-forward' ,'ti-control-backward' ,'ti-cloud' ,'ti-cloud-up' ,'ti-cloud-down' ,'ti-clipboard' ,'ti-car' ,'ti-calendar' ,'ti-book' ,'ti-bell' ,'ti-basketball' ,'ti-bar-chart' ,'ti-bar-chart-alt' ,'ti-back-right' ,'ti-back-left' ,'ti-arrows-corner' ,'ti-archive' ,'ti-anchor' ,'ti-align-right' ,'ti-align-left' ,'ti-align-justify' ,'ti-align-center' ,'ti-alert' ,'ti-alarm-clock' ,'ti-agenda' ,'ti-write' ,'ti-window' ,'ti-widgetized' ,'ti-widget' ,'ti-widget-alt' ,'ti-wallet' ,'ti-video-clapper' ,'ti-video-camera' ,'ti-vector' ,'ti-themify-logo' ,'ti-themify-favicon' ,'ti-themify-favicon-alt' ,'ti-support' ,'ti-stamp' ,'ti-split-v-alt' ,'ti-slice' ,'ti-shortcode' ,'ti-shift-right-alt' ,'ti-shift-left-alt' ,'ti-ruler-alt-2' ,'ti-receipt' ,'ti-pin2' ,'ti-pin-alt' ,'ti-pencil-alt2' ,'ti-palette' ,'ti-more' ,'ti-more-alt' ,'ti-microphone-alt' ,'ti-magnet' ,'ti-line-double' ,'ti-line-dotted' ,'ti-line-dashed' ,'ti-layout-width-full' ,'ti-layout-width-default' ,'ti-layout-width-default-alt' ,'ti-layout-tab' ,'ti-layout-tab-window' ,'ti-layout-tab-v' ,'ti-layout-tab-min' ,'ti-layout-slider' ,'ti-layout-slider-alt' ,'ti-layout-sidebar-right' ,'ti-layout-sidebar-none' ,'ti-layout-sidebar-left' ,'ti-layout-placeholder' ,'ti-layout-menu' ,'ti-layout-menu-v' ,'ti-layout-menu-separated' ,'ti-layout-menu-full' ,'ti-layout-media-right-alt' ,'ti-layout-media-right' ,'ti-layout-media-overlay' ,'ti-layout-media-overlay-alt' ,'ti-layout-media-overlay-alt-2' ,'ti-layout-media-left-alt' ,'ti-layout-media-left' ,'ti-layout-media-center-alt' ,'ti-layout-media-center' ,'ti-layout-list-thumb' ,'ti-layout-list-thumb-alt' ,'ti-layout-list-post' ,'ti-layout-list-large-image' ,'ti-layout-line-solid' ,'ti-layout-grid4' ,'ti-layout-grid3' ,'ti-layout-grid2' ,'ti-layout-grid2-thumb' ,'ti-layout-cta-right' ,'ti-layout-cta-left' ,'ti-layout-cta-center' ,'ti-layout-cta-btn-right' ,'ti-layout-cta-btn-left' ,'ti-layout-column4' ,'ti-layout-column3' ,'ti-layout-column2' ,'ti-layout-accordion-separated' ,'ti-layout-accordion-merged' ,'ti-layout-accordion-list' ,'ti-ink-pen' ,'ti-info-alt' ,'ti-help-alt' ,'ti-headphone-alt' ,'ti-hand-point-up' ,'ti-hand-point-right' ,'ti-hand-point-left' ,'ti-hand-point-down' ,'ti-gallery' ,'ti-face-smile' ,'ti-face-sad' ,'ti-credit-card' ,'ti-control-skip-forward','ti-control-skip-backward' ,'ti-control-record' ,'ti-control-eject','ti-comments-smiley' ,'ti-brush-alt' ,'ti-youtube' ,'ti-vimeo' ,'ti-twitter' ,'ti-time' ,'ti-tumblr' ,'ti-skype' ,'ti-share' ,'ti-share-alt' ,'ti-rocket' ,'ti-pinterest' ,'ti-new-window' ,'ti-microsoft' ,'ti-list-ol' ,'ti-linkedin' ,'ti-layout-sidebar-2' ,'ti-layout-grid4-alt' ,'ti-layout-grid3-alt' ,'ti-layout-grid2-alt' ,'ti-layout-column4-alt' ,'ti-layout-column3-alt' ,'ti-layout-column2-alt' ,'ti-instagram' ,'ti-google' ,'ti-github' ,'ti-flickr' ,'ti-facebook' ,'ti-dropbox' ,'ti-dribbble' ,'ti-apple' ,'ti-android' ,'ti-save' ,'ti-save-alt' ,'ti-yahoo' ,'ti-wordpress' ,'ti-vimeo-alt' ,'ti-twitter-alt' ,'ti-tumblr-alt' ,'ti-trello' ,'ti-stack-overflow' ,'ti-soundcloud' ,'ti-sharethis' ,'ti-sharethis-alt' ,'ti-reddit' ,'ti-pinterest-alt' ,'ti-microsoft-alt' ,'ti-linux' ,'ti-jsfiddle' ,'ti-joomla' ,'ti-html5' ,'ti-flickr-alt' ,'ti-email' ,'ti-drupal' ,'ti-dropbox-alt' ,'ti-css3' ,'ti-rss' ,'ti-rss-alt' ,
        );
        
        $icons = array();
        foreach($themify as $icon){
            $icons[$icon] = ucwords(str_replace('-',' ',str_replace('ti-','',$icon)));
        }
    
        return $icons;
    }
}
/* -------- Newly Added --------  */

/* Used on footer and header area */
function get_social_icons($show_position = 'all', $default_class = '',$header_social_key = '', $show_icon_name = false)
{
    $output = '';
    $updated_social_links = array();
    $header_style = config('ThemeOptions.header_style', 'header_1'); // return header style id
    $target = config('ThemeOptions.social_link_target','_self');
    $social_link_options = social_link_options();

    if ($show_position == 'header') {
        /*reCheck function and rebuild it for fast performance */
        if (is_array($header_social_key)) {
            $header_social_links = $header_social_key;
        }else{
            $header_social_links = config('ThemeOptions.'.$header_style.'_social_links', '');
        }
        $header_show_links = [];


        if (!empty($header_social_links)) {
            foreach ($header_social_links as $value) {
                $header_show_links[] = $value;
            }
        }
        if (!empty($social_link_options)) {
            foreach ($social_link_options as $social_key => $social_link) {
                if (in_array($social_link['id'], $header_show_links)) {
                    $updated_social_links[$social_key] = $social_link;
                }
            }
        }

        $social_link_options = $updated_social_links;
    }

    if (is_array($header_social_key)) {
        if (!empty($social_link_options)) {
            foreach ($social_link_options as $social_key => $social_link) {
                if (in_array($social_link['id'], $header_social_key)) {
                    $updated_social_links[$social_key] = $social_link;
                }
            }
            $social_link_options = $updated_social_links;
        }
    }

    foreach ($social_link_options as $social_link) {

        $id = $social_link['id'];
        $sl_id = 'social_' . $id . '_url';

        $sl_title = $social_link['title'];

        $social_url = config('ThemeOptions.' . $sl_id);
        if (filter_var($social_url, FILTER_VALIDATE_URL) && !empty($social_url)) {
            $id = ($id == 'facebook') ? 'facebook-f' : $id;
            if($show_icon_name)
            {
                $output .= '<li><a target="' . ($target) . '" href="' . ($social_url) . '" >' . $sl_title . '</a></li>' . "\n";
            }else{
                $output .= '<li><a target="' . ($target) . '" href="' . ($social_url) . '"  class="' . ($default_class . ' fab fa-' . $id) . '"></a></li>' . "\n";
            }
        }
    }

    return $output;
}