@extends('admin.layout.fullwidth')

@section('content')
    <div class="col-md-5">
        <div class="form-input-content text-center error-page">
            <h1 class="error-text fw-bold">{{ __('503') }}</h1>
            <p>{!! config('Site.maintenance_message') !!}</p>
        </div>
    </div>
@endsection