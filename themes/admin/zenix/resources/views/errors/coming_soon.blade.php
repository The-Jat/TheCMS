@extends('admin.layout.fullwidth')

@section('content')
    <div class="col-md-5">
        <div class="form-input-content text-center error-page">
            <h1 class="error-text fw-bold"><i class="fa fa-exclamation-triangle text-warning"></i></h1>
            <p>{!! config('Site.comingsoon_message') !!}</p>
        </div>
    </div>
@endsection