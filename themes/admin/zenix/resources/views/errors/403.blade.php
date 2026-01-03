@extends('admin.layout.fullwidth')

@section('content')
    <div class="col-md-5">
        <div class="form-input-content text-center error-page">
            <h1 class="error-text  font-weight-bold">{{ __('403') }}</h1>
            <h4><i class="fa fa-times-circle text-danger"></i> {{ __('Forbidden Error!') }}</h4>
            <p>{{ __('You do not have permission to view this resource.') }}</p>
			<div>
                <a class="btn btn-primary" href="{{ url('/admin') }}">{{ __('Back to Home') }}</a>
            </div>
        </div>
    </div>
@endsection