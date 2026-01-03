@extends('layout.fullwidth')

@section('content')
    @php
        extract($w3cms_option);
    @endphp
    
    @if ($coming_soon_template == 'coming_style_1')
        @include('elements.comingsoon.comingsoon_1')
    @else
        @include('elements.comingsoon.comingsoon_1')
    @endif
    
@endsection