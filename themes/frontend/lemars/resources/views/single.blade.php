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

        $post_layout = !empty($post_layout)?$post_layout:'post_standard'; 
    @endphp

    @include('elements.banner-inner')

    @include('elements.post_template.'.$post_layout);

@endsection