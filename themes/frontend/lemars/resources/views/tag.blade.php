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

                <!-- Content Side-->
                <div class="{{empty($sidebar) || !$show_sidebar || $layout == 'sidebar_full' ? 'col-sm-12' : 'col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12' }}" >
                    <div class="row masonry" id="BlogsLoadmoreContent">
                        @include('elements.post_listing.'.$post_listing_style)
                    </div>

                    <!-- Blogs Pagination -->
                    <div class="text-center">
                        @if ($disable_ajax_pagination == 'load_more')
                            @if ($blogs->hasMorePages())
                            <form id="W3AjaxTagsForm" class="text-center">
                                <input type="hidden" name="ajax_container" value="BlogsLoadmoreContent">
                                <input type="hidden" name="no_of_posts" value="{{config('Reading.nodes_per_page')}}">
                                <input type="hidden" name="page" value="2">
                                <input type="hidden" name="ajax_view" value="ajax_tags_blog_listing">
                                <input type="hidden" name="view_name" value="tag">
                                <input type="hidden" name="slug" value="{{request()->slug}}">
                                <button  class="btn outline outline-2 black radius-xl ajax-load-more" data-form-id="W3AjaxTagsForm">{{ __('Load More') }}</button>
                            </form>
                            @else
                            <a href="javascript:void(0);" class="btn outline outline-2 black radius-xl disabled">{{ DzHelper::theme_lang('No More Posts') }}</a>
                            @endif
                        @else
                        {!! $blogs->links('elements.pagination') !!}
                        @endif
                    </div>
                    <!-- Blogs Pagination End--> 
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
