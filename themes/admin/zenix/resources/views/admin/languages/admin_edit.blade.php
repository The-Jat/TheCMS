{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('language.admin.index') }}">{{ __('common.language') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit_Language') }}</a></li>
            </ol>
        </div>
    </div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">{{ __('common.edit_Language') }}</h4>
		</div>
		<form action="{{ route('language.admin.update',$language->id)}}" method="POST">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">{{ __('common.title') }}</label>
						<div class="col-sm-9">
							<input type="text" name="title" id="title" class="form-control" autocomplete="title" value="{{ old('title', $language->title) }}">
							@error('title')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>

				<div class="basic-form">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">{{ __('common.language_code') }}</label>
						<div class="col-sm-9">
							<input type="text" name="language_code" id="language_code" class="form-control" autocomplete="language_code" value="{{ old('language_code',$language->language_code) }}">
							@error('language_code')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>

                <div class="basic-form">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">{{ __('common.country') }}</label>
						<div class="col-sm-9">
							<input type="text" name="country" id="country" class="form-control" autocomplete="country" value="{{ old('country',$language->country) }}">
							@error('country')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>

                <div class="basic-form">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">{{ __('common.country_code') }}</label>
						<div class="col-sm-9">
							<input type="text" name="country_code" id="country_code" class="form-control" autocomplete="country_code" value="{{ old('country_code',$language->country_code) }}">
							@error('country_code')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>

                <div class="basic-form">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">{{ __('common.country_flag') }}</label>
						<div class="col-sm-9">
							<input type="text" name="country_flag" id="country_flag" class="form-control" autocomplete="country_flag" value="{{ old('country_flag',$language->country_flag) }}">
							@error('country_flag')
	                            <p class="text-danger">
	                                {{ $message }}
	                            </p>
	                        @enderror
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer text-end">
				<button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
				<a href="{{ route('language.admin.index') }}" class="btn btn-danger">{{ __('common.back') }}</a>
			</div>
		</form>
	</div>

</div>

@endsection
