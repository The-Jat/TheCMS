@extends('layout.default')

@section('content')
    @php
        if (isset($w3cms_option)) {
            extract($w3cms_option);
        }
    @endphp

    @include('elements.banner-inner')

    <!-- Blog Post Start -->
    <div class="section-full bg-white content-inner p-b0">
        <div class="container">
            <div class="row">
                <!-- Left sidebar area -->
                @if ( !empty($sidebar) && $show_sidebar && $layout == 'sidebar_left')
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="side-bar p-l30 sticky-top">
                        @include('elements.sidebar')
                        <div class="clearfix"></div>
                    </div>
                </div>
                @endif
                <!-- End Left sidebar area -->

                <!--Content Side-->
                <div class="{{empty($sidebar) || !$show_sidebar || $layout == 'sidebar_full' ? 'col-sm-12' : 'col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12' }}" >
                    <div class="widget w-100">
                        <div class="search-bx">
                            <form method="get" action="{{ route('permalink.search') }}">
                                @csrf
                                <div class="input-group">
                                    <input name="s" type="text" class="form-control" value="{{ $pageTitle }}" placeholder="{{ DzHelper::theme_lang('Search Here...')}}">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Blogs Listing --> 
                    <h4 class="m-b30">{{ __('Blogs') }}</h4>
                    <div class="row masonry" id="BlogsLoadmoreContent">
                        @include('elements.post_listing.'.$post_listing_style)
                    </div>
                    <div class="d-block text-center mt-lg-4 mt-0 mb-4">
                        @if ($disable_ajax_pagination == 'load_more')
                            @if ($blogs->hasMorePages())
                            <form id="W3AjaxPostForm">
                                <input type="hidden" name="ajax_container" value="BlogsLoadmoreContent">
                                <input type="hidden" name="no_of_posts" value="{{config('Reading.nodes_per_page')}}">
                                <input type="hidden" name="page" value="2">
                                <input type="hidden" name="ajax_view" value="ajax_search_blog_listing">
                                <input type="hidden" name="view_name" value="search">
                                <input type="hidden" name="search_type" value="blog">
                                <input type="hidden" name="s" value="{{$title}}">
                                <button  class="btn outline outline-2 black radius-xl ajax-load-more" data-form-id="W3AjaxPostForm">{{ __('Load More') }}</button>
                            </form>
                            @else
                            <a href="javascript:void(0);" class="btn outline outline-2 black radius-xl disabled">{{ DzHelper::theme_lang('No More Posts') }}</a>
                            @endif
                        @else
                        {!! $blogs->links('elements.pagination') !!}
                        @endif
                    </div>
                    <!-- Blogs Listing End--> 

                    <!-- Pages Listing End--> 
                    <h4 class="m-b30">{{ __('Pages') }}</h4>
                    <div class="row masonry" id="PagesLoadmoreContent">
                        @include('elements.page_listing.page_listing_1')
                    </div>
                    <div class="d-block text-center mt-lg-4 mt-0 mb-4">
                        @if ($pages->isNotEmpty() && $disable_ajax_pagination == 'load_more')
                            @if ($pages->hasMorePages())
                            <form id="W3AjaxPageForm">
                                <input type="hidden" name="ajax_container" value="PagesLoadmoreContent">
                                <input type="hidden" name="no_of_posts" value="{{config('Reading.nodes_per_page')}}">
                                <input type="hidden" name="page" value="2">
                                <input type="hidden" name="ajax_view" value="ajax_search_page_listing">
                                <input type="hidden" name="view_name" value="search">
                                <input type="hidden" name="search_type" value="page">
                                <input type="hidden" name="s" value="{{$title}}">
                                <button  class="btn outline outline-2 black radius-xl ajax-load-more" data-form-id="W3AjaxPageForm">{{ __('Load More') }}</button>
                            </form>
                            @else
                            <a href="javascript:void(0);" class="btn outline outline-2 black radius-xl disabled">{{ DzHelper::theme_lang('No More Posts') }}</a>
                            @endif
                        @else
                        {!! $pages->links('elements.pagination') !!}
                        @endif
                    </div>
                    <!-- Pages Listing End--> 

                </div>
                <!-- End Content Side-->

                <!-- Right sidebar area -->
                @if ( !empty($sidebar) && $show_sidebar && $layout == 'sidebar_right')
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="side-bar p-r20 sticky-top">
                        @include('elements.sidebar')
                        <div class="clearfix"></div>
                    </div>
                </div>
                @endif
                <!-- End Right sidebar area -->
            </div>
        </div>
    </div>
    <!-- Blog Post End -->
@endsection
