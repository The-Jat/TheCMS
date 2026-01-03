@php
    $blogs = HelpDesk::elementPostsByArgs($args);
@endphp
<!-- inner page banner -->
<div class="banner-image style-1 dlab-bnr-inr dlab-bnr-inr-lg overlay-black-light relative">
    <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image']) }}" alt="{{ DzHelper::theme_lang('Image') }}">
</div>
<!-- Trending -->
<div class="section-full trend-panel style-1">
    <div class="container">
        <div class="trend-panel-space">
            <div class="post-slide-show no-radius m-b0">
                <div class="swiper swiper-container {{ $args['base'] }} ">
                    <div class="swiper-wrapper">
                        @forelse($blogs as $blog)
                        <div class="swiper-slide">
                            <div class="category-box-outline m-b30">
                                <div class="category-box dz-overlay dz-trending-post">
                                    <div class="category-media">
                                        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
                                    </div>
                                    <div class="category-info">
                                        <div class="category-style">
                                            <a>{{ DzHelper::theme_lang(isset($blog->blog_categories[0]['title']) ? $blog->blog_categories[0]['title'] : '') }}</a>
                                        </div>
                                        <h4>
                                            <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                                                {{ isset($blog->title) ? Str::limit(DzHelper::theme_lang($blog->title), 24, ' ...') : '' }}
                                            </a>
                                        </h4>
                                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="category-title">{{ DzHelper::theme_lang('Read More') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('inline-swiper')
    <script>
        'use strict';
        var swiper_class = '{{ $args['base'] }}';
        var space_between = {{ isset($args['space_between']) ? $args['space_between'] : 0 }};
        var loop = {{ isset($args['loop']) ? $args['loop'] : 'false' }};
        var keyboard_control = {{ isset($args['keyboard_control']) ? $args['keyboard_control'] : 'false' }};
        var auto_play = {{ isset($args['auto_play']) ? $args['auto_play'] : 'false' }};
        var autoplay_delay = {{ isset($args['autoplay_delay']) ? $args['autoplay_delay'] : 1500 }};
        var slides_per_view = {{ isset($args['slides_per_view']) ? $args['slides_per_view'] : 1 }};
        var centered_slides = {{ isset($args['centered_slides']) ? $args['centered_slides'] : 'false' }};
        var free_mode = {{ isset($args['free_mode']) ? $args['free_mode'] : 'false' }};
        var slider_speed = {{ isset($args['speed']) ? $args['speed'] : 1000 }};
        var effect = '{{ isset($args['effect']) ? $args['effect'] : '' }}';
        var grabCursor = '{{ isset($args['grabCursor']) ? $args['grabCursor'] : 'false' }}';

        var autoplay_enable = ((typeof auto_play != "undefined") ? { delay: autoplay_delay } : false);
        var breakpoint1 = {{ isset($args['breakpoint1']) ? $args['breakpoint1'] : 1 }};
        var breakpoint2 = {{ isset($args['breakpoint2']) ? $args['breakpoint2'] : 2 }};
        var breakpoint3 = {{ isset($args['breakpoint3']) ? $args['breakpoint3'] : 2 }};
        var breakpoint4 = {{ isset($args['breakpoint4']) ? $args['breakpoint4'] : 3 }};
        var break_points = {};

        break_points[575] = {
            slidesPerView: breakpoint1,
        };
        break_points[768] = {
            slidesPerView: breakpoint2,
        };
        break_points[992] = {
            slidesPerView: breakpoint3,
        };
        break_points[1200] = {
            slidesPerView: breakpoint4,
        };

        var swiperMain = new Swiper('.'+swiper_class, {
            speed: slider_speed,
            effect: effect,
            centeredSlides: centered_slides,
            spaceBetween: space_between,
            slidesPerView: slides_per_view,
            grabCursor : grabCursor,
            loop:loop,
            navigation: {
                nextEl: "."+swiper_class+"-next",
                prevEl: "."+swiper_class+"-prev",
            },
            keyboard: keyboard_control,
            autoplay: autoplay_enable,
            freeMode: free_mode,
            breakpoints:break_points,
        });
    </script>
@endpush
