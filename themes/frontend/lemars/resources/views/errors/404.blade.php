@extends('layout.default')

@section('content')
    @php
        if (isset($w3cms_option)) {
            extract($w3cms_option);
        }
    @endphp

    <div class="section-full">
        <div class="container">
            <div class="error-page text-center">
                <div class="dz_error">{{ $error_page_title }}</div>
                <h2 class="error-head">{{ $error_page_text }}</h2>
                <a href="{{ url('/') }}" class="btn radius-no">
                    <span class="p-lr15">{{ $error_page_button_text }}</span>
                </a>
            </div>
        </div>
    </div>

@endsection
