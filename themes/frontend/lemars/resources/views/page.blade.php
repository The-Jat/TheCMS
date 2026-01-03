@extends('layout.default')

@section('content')
@php
    if (isset($w3cms_option)) {
        extract($w3cms_option);
    }
    $requiredFieldIndicator = config('Discussion.name_email_require') ? DzHelper::requiredFieldIndicator() : '';
    $isRequired = config('Discussion.name_email_require') ? 'required' : '';
    $comment_author = !empty($_COOKIE['comment_author_'.config('constants.comment_cookie_hash')]) ? $_COOKIE['comment_author_'.config('constants.comment_cookie_hash')] : '';
    $comment_email = !empty($_COOKIE['comment_email_'.config('constants.comment_cookie_hash')]) ? $_COOKIE['comment_email_'.config('constants.comment_cookie_hash')] : '';
    $comment_url = !empty($_COOKIE['comment_website_'.config('constants.comment_cookie_hash')]) ? $_COOKIE['comment_website_'.config('constants.comment_cookie_hash')] : '';
    $page_show_sidebar = isset($page) ? ThemeOption::GetPageOptionById($page->id, 'page_show_sidebar') : null;
    $page_sidebar_layout = isset($page) ? ThemeOption::GetPageOptionById($page->id, 'page_sidebar_layout') : null;
@endphp

<!-- Content -->

@include('elements.banner-inner')

@if ($show_sidebar)
<div class="section-full bg-white content-inner p-b0">
    <div class="{{ (!empty($sidebar) && $layout != 'sidebar_full') ? 'container' : 'min-container' }}">
        {!! (!empty($sidebar) && $layout != 'sidebar_full') ? '<div class="row">' : '' !!}
@endif
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
            @if (!empty($sidebar) && $show_sidebar && $layout != 'sidebar_full')
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12">
            @endif

            @if ($page)

                <!-- Password protected block -->
                @include('elements.password_protected_block')
                <!-- End Password protected block -->

                @if ($status == 'unlock_'.$page->id)

                    {!! HelpDesk::shortcodeContent($page->content) !!}

                    <!-- Child Pages Detail End -->
                    @if (optional($page->child_pages)->isNotEmpty())
                    <div class="container">
                        <h4>{{ __('Related Pages') }}</h4>
                        <ul class="related-pages p-l m-b30">
                            @forelse($page->child_pages as $child_page)
                            <li>
                                -<a href="{{ DzHelper::laraPageLink($child_page->id) }}" class="pl-2 ">{{ $child_page->title }}</a>
                                @if ($child_page->child_pages->isNotEmpty())
                                    {{ DzHelper::getChildPage($child_page->child_pages) }}
                                @endif
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    @endif
                    <!-- Child Pages Detail End -->
                @endif

                <!-- Comment list block -->
                @include('elements.comments_block')
                <!-- End comment list block -->
            @else
                <div class="col-12">{{ DzHelper::theme_lang('No record found') }}</div>
            @endif

            @if (!empty($sidebar) && $show_sidebar && $layout != 'sidebar_full')
                </div>
            @endif

            <!-- Right sidebar area -->
            @if (!empty($sidebar) && $show_sidebar && $layout == 'sidebar_right')
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="side-bar p-r20 sticky-top">
                    @include('elements.sidebar')
                    <div class="clearfix"></div>
                </div>
            </div>
            @endif
            <!-- End Right sidebar area -->

@if ( $show_sidebar)
        {!! (!empty($sidebar) && $layout != 'sidebar_full') ? '</div>' : '' !!}
    </div>
</div>
<!-- Content end -->
@endif
@endsection