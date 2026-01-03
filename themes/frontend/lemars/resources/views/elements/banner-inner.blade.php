@if($currentViewName != 'single')    
    @php
        $header_style = isset($w3cms_option['header_style'])?$w3cms_option['header_style']:'header_1';
        $template_name = 'page_general';
        if ($currentViewName == 'page') {
            $page_options = ThemeOption::GetPageOptionById($page->id);
        }

        $page_banner_setting    = !empty($page_options['page_banner_setting'])?$page_options['page_banner_setting']:'theme_default';
        $title_prefix           = '';

        if($currentViewName == 'author'){
            $template_name  = 'author_page';
            $title_prefix   = __('Author :');
        }
        else if($currentViewName == 'search'){
            $template_name  = 'search_page';
            $title_prefix   = __('Search :');
        }
        else if($currentViewName == 'category'){
            $template_name  = 'category_page';
            $title_prefix   = __('Category :');
        }
        else if($currentViewName == 'tag'){
            $template_name  = 'tag_page';
            $title_prefix   = __('Tag :');
        }
        else if($currentViewName == 'archive'){
            $template_name  = 'archive_page';
            $title_prefix   = __('Archive :');
        }

        $page_banner_title = $page_banner_sub_title = '';

        if($page_banner_setting == 'custom')
        {
            $show_banner        = $page_options['page_banner_on'] ?? null;
            
            $banner_type        = $page_options['page_banner_type'] ?? null;
            $custom_height      = $page_options['page_banner_custom_height'] ?? null;
            $banner_image       = $page_options['page_banner'] ?? null;
            $banner_image       = !empty($banner_image) ? asset('storage/page-options/'.$banner_image) : theme_asset('images/banner/pic4.jpg');

            $banner_hide            = $page_options['page_banner_hide'] ?? null;
            $page_banner_title      = $page_options['page_banner_title'] ?? null;
            $page_banner_sub_title  = $page_options['page_banner_sub_title'] ?? null;
            $show_breadcrumb    = $page_options['page_breadcrumb'] ?? null;
        }
        else
        {
            $title_prefix       = config('ThemeOptions.'.$template_name.'_title',$title_prefix);
            $show_banner        = config('ThemeOptions.'.$template_name.'_banner_on',true);
            
            $banner_type        = config('ThemeOptions.'.$template_name.'_banner_type','image');
            $custom_height      = config('ThemeOptions.'.$template_name.'_banner_custom_height','100');
            $banner_image       = config('ThemeOptions.'.$template_name.'_banner');
            $banner_image       = !empty($banner_image) ? asset('storage/theme-options/'.$banner_image) : theme_asset('images/banner/pic4.jpg');
            $show_breadcrumb    = config('ThemeOptions.show_breadcrumb',true);
            $banner_hide        = config('ThemeOptions.'.$template_name.'_banner_hide');
        }

        $page_heading_classes = 'dlab-bnr-inr-entry text-white';
        $banner_class = (empty($banner_image)) ?'bnr-no-img ':'';


        if($banner_height == 'page_banner_big') {
            $banner_class .= 'dlab-bnr-inr-md';
            $page_heading_classes = ' dlab-bnr-inr-entry text-white align-b';
        }
        else if($banner_height == 'page_banner_medium'){
            $banner_class .= 'dlab-bnr-inr-sm';
        }


        $bnr_style = "style=";

        if(empty($banner_hide) && !empty($banner_image)) {
            $bnr_style .= 'background-image:url('.$banner_image.');';
        }
        if($banner_height == 'page_banner_custom'){
            $bnr_style .= 'height:'.$custom_height.'px;';
        }

    @endphp

    @if ($show_banner != 0)

        <div class="dlab-bnr-inr overlay-black-middle {{ $banner_class }}" {{$bnr_style}}>
            <div class="container">
                <div class="{{$page_heading_classes}}">

                    @if ($header_style == 'header_3' && !empty($page_banner_sub_title))
                    <p>{{ DzHelper::theme_lang($page_banner_sub_title) }}</p>
                    @endif
                    <h1>
                       {{ DzHelper::theme_lang(!empty($page_banner_title) ? $page_banner_title : $title_prefix.' '.$pageTitle) }}
                    </h1>

                    @if ($show_breadcrumb)
                    <!-- Breadcrumb row -->
                    <div class="breadcrumb-row">
                        <ul class="list-inline">
                            <li><a href="{{ url('/') }}"><i class="ti-home"></i> {{ DzHelper::theme_lang('Home') }} </a>
                            <li>{{ DzHelper::theme_lang(!empty($page_banner_title) ? $page_banner_title : $title_prefix.' '.$pageTitle) }}</li>
                        </ul>
                    </div>
                    <!-- Breadcrumb row END -->
                    @endif

                    @if ($banner_height == 'page_banner_big')
                    <span class="line"></span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endif
