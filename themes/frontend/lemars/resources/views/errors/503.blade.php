@extends('layout.fullwidth')

@section('content')
    @php
        extract($w3cms_option);
    @endphp

    @if ($maintenance_template == 'maintenance_style_1')
        @include('elements.maintinance.maintenance_1')
    @else
        @include('elements.maintinance.maintenance_1')
    @endif
@endsection