<div class="default-el">
    <div class="{{ (isset($args['content_type']) && ($args['content_type'] == 'blog' || $args['content_type'] == 'cpt'))? 'container' : '' }} ">
        @if (isset($args['content_type']) && !empty($args['content_type']))
        <div class="swiper swiper-container {{ $args['base'] }}" >

            <div class="swiper-wrapper">
                @if (isset($args['swiper_images']) && !empty($args['swiper_images']) && $args['content_type'] == 'upload')
                    @php
                        if (isset($args['swiper_images']) && !empty($args['swiper_images'])) {
                            $images = explode(",", $args['swiper_images']);
                        }
                    @endphp
                    @foreach ($images as $image)
                        <div class="swiper-slide" style="height: {{ isset($args['slider_height']) ? $args['slider_height'] : '100vh' }};">
                            <div class="swiper-zoom-container" >
                                <div class="w-100 h-100 ">
                                    <img src="{{ asset('/storage/page-images/magic-editor/'.$image) }}" alt="">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @elseif ($args['content_type'] == 'blog')
                    @php
                        $blogs = HelpDesk::elementPostsByArgs($args);
                    @endphp
                    @forelse($blogs as $blog)
                    <div class="swiper-slide" >
                        <div class="dz-card default-el-1 ">
                            <div class="dz-media">
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                                    @if(optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                        <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                    @else
                                        <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                    @endif
                                </a>
                            </div>
                            <div class="dz-info">
                                <div class="dz-meta">
                                    <ul>
                                        <li class="post-author">
                                            <a href="javascript:void(0);">
                                                <img src="{{ HelpDesk::user_img($blog->user->profile) }}" alt="">{{ $blog->user->name }}</a>
                                        </li>
                                        <li class="post-date"><a href="javascript:void(0);">  {{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</a></li>
                                        <li class="post-comment"><a href="javascript:void(0);">{{ $blog->blog_comments_count}} {{ __('comments') }}</a></li>
                                    </ul>
                                </div>
                                <h4 class="dz-title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 40, ' ...') }}</a></h4>
                                <p>{{ Str::limit($blog->excerpt, 70, ' ...') }}</p>
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="read-more-btn bg-primary ">{{ __('Read More') }}</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                @elseif (isset($args['category_ids']) && !empty($args['category_ids']) && $args['content_type'] == 'category')
                    @php
                        $categories = HelpDesk::elementCategoriesByArgs($args);
                    @endphp
                    @forelse($categories as $category)
                    <div class="swiper-slide" >
                        <div class="category-box" >
                            <div class="category-media">    
                                @if(optional($category)->image && Storage::exists('public/category-images/'.$category->image))
                                    <img src="{{ asset('storage/category-images/'.$category->image) }}" alt="">
                                @else
                                    <img src="{{ asset('images/noimage.jpg') }}" alt="">
                                @endif
                            </div>
                            <div class="category-info">
                                <a href="{{ DzHelper::laraBlogCategoryLink($category->id) }}" class="category-title">{{  $category->title  }}</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse


                @elseif (isset($args['item_ids']) && !empty($args['item_ids']) && $args['content_type'] == 'cpt')
                    @php
                        $ids = explode(',', $args['item_ids']);
                        $blogs = \Modules\W3CPT\Entities\Blog::whereIn('id', $ids)->where('status', 1)->get();
                    @endphp
                    @forelse($blogs as $blog)
                    <div class="swiper-slide" >
                        <div class="dz-card default-el-1 ">
                            <div class="dz-media">
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                                    @if(optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                        <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                    @else
                                        <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                                    @endif
                                </a>
                            </div>
                            <div class="dz-info">
                                <div class="dz-meta">
                                    <ul>
                                        <li class="post-author">
                                            <a href="javascript:void(0);">
                                                <img src="{{ HelpDesk::user_img($blog->user->profile) }}" alt="">{{ $blog->user->name }}</a>
                                        </li>
                                        <li class="post-date"><a href="javascript:void(0);">  {{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</a></li>
                                        <li class="post-comment"><a href="javascript:void(0);">{{ $blog->blog_comments_count}} {{ __('comments') }}</a></li>
                                    </ul>
                                </div>
                                <h4 class="dz-title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 40, ' ...') }}</a></h4>
                                <p>{{ Str::limit($blog->excerpt, 80, ' ...') }}</p>
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="read-more-btn bg-primary ">{{ __('Read More') }}</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                @endif

            </div>
        </div>
        @endif
    </div>
        @if (isset($args['navigation']) && ($args['navigation'] == true))
            <div class="{{ $args['base'] }}-prev swiper-button-prev text-primary"></div>
            <div class="{{ $args['base'] }}-next swiper-button-next text-primary"></div>
        @endif
        @if (isset($args['pagination']) && $args['pagination'] != '')
            <div class="swiper-pagination justify-content-center"></div>
        @endif
        @if (isset($args['scrollbar']) && $args['scrollbar'] == true)
            <div class="swiper-scrollbar"></div>
        @endif
</div>

    @if (isset($args['thumb_slider']) && ($args['thumb_slider'] == true) && $args['content_type'] == 'upload')
    <div thumbsSlider="" class="swiper swiper-container thumb-swiper mt-2">
        <div class="swiper-wrapper">
            @if (isset($args['swiper_images']) && !empty($args['swiper_images']))
                @php
                    $images = explode(",", $args['swiper_images']);
                @endphp
                @foreach ($images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('/storage/page-images/magic-editor/'.$image) }}" />
                        </div>
                @endforeach
            @else
                
            @endif
        </div>
    </div>
    @endif

@push('inline-swiper')
    <script>
        'use strict';

        var swiper_class = '{{ $args['base'] }}';
        var pagination_type = '{{ isset($args['pagination']) ? $args['pagination'] : 'bullets' }}';
        var dynamic_bullets = {{ isset($args['dynamic_bullets']) ? $args['dynamic_bullets'] : 'false' }};
        var space_between = {{ isset($args['space_between']) ? $args['space_between'] : 0 }};
        var loop = {{ isset($args['loop']) ? $args['loop'] : 'false' }};
        var keyboard_control = {{ isset($args['keyboard_control']) ? $args['keyboard_control'] : 'false' }};
        var auto_play = {{ isset($args['auto_play']) ? $args['auto_play'] : 'false' }};
        var autoplay_delay = {{ isset($args['autoplay_delay']) ? $args['autoplay_delay'] : 1500 }};
        var direction = '{{ isset($args['direction']) ? $args['direction'] : 'horizontal' }}';
        var slides_per_view = {{ isset($args['slides_per_view']) ? $args['slides_per_view'] : 3 }};
        var centered_slides = {{ isset($args['centered_slides']) ? $args['centered_slides'] : 'false' }};
        var free_mode = {{ isset($args['free_mode']) ? $args['free_mode'] : 'false' }};
        var parallax = {{ isset($args['parallax']) ? $args['parallax'] : 'false' }};
        var slider_speed = {{ isset($args['speed']) ? $args['speed'] : 1000 }};
        var effect = '{{ isset($args['effect']) ? $args['effect'] : '' }}';
        var thumb_slider = {{ isset($args['thumb_slider']) ? $args['thumb_slider'] : 'false' }};
        var thumb_slider_view = {{ isset($args['thumb_slider_view']) ? $args['thumb_slider_view'] : 4 }};

        var thumbSwiper = new Swiper(".thumb-swiper", {
            spaceBetween: 10,
            slidesPerView: thumb_slider_view,
            loop: true,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var thumb_swiper = (typeof thumb_slider != "undefined" && thumb_slider == true) ? { swiper: thumbSwiper } : false;
        var autoplay_enable = ((typeof auto_play != "undefined") ? { delay: autoplay_delay } : false);

        var break_points = {};

        @if(isset($args['breakpoint1']))
            break_points[0] = {
                slidesPerView: {{ $args['breakpoint1'] }},
                spaceBetween: space_between,
            };
        @endif
        @if(isset($args['breakpoint2']))
            break_points[575] = {
                slidesPerView: {{ $args['breakpoint2'] }},
                spaceBetween: space_between,
            };
        @endif
        @if(isset($args['breakpoint3']))
            break_points[767] = {
                slidesPerView: {{ $args['breakpoint3'] }},
                spaceBetween: space_between,
            };
        @endif
        @if(isset($args['breakpoint4']))
            break_points[991] = {
                slidesPerView: {{ $args['breakpoint4'] }},
                spaceBetween: space_between,
            };
        @endif

        var swiperMain = new Swiper('.'+swiper_class, {
            speed: slider_speed,
            effect: effect,
            direction: direction,
            centeredSlides: centered_slides,
            spaceBetween: space_between,
            slidesPerView: slides_per_view,
            loop:loop,
            autoHeight: false,
            parallax: parallax,
            keyboard: keyboard_control,
            autoplay: autoplay_enable,
            freeMode: free_mode,
            scrollbar: {
                el: ".swiper-scrollbar",
                hide: true,
            },
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: dynamic_bullets,
                clickable: true,
                type: pagination_type,
            },
            breakpoints: break_points,
            navigation: {
                nextEl: "."+swiper_class+"-next",
                prevEl: "."+swiper_class+"-prev",
            },
            thumbs: thumb_swiper,
        });
    </script>
@endpush
