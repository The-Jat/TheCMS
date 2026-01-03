{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
@php
	$options_data = isset($options_data) ? $options_data : array();
 @endphp
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
				<li class="breadcrumb-item"><a href="#">{{ __('common.theme_options') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.theme_options') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<form action="{{ route('w3options.admin.save-theme-options') }}" id="ThemeOptionForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
			@csrf
				<div class="card dz-setting">
					<div class="card-header">
						<h4 class="card-title">{{ __('common.theme_options') }}</h4>
					</div>
					<div class="card-body">
						@if (isset($sections) && !empty($sections))
							@include('w3options::elements.options', compact('sections','options_data'))
						@endif
					</div>
					<div class="card-footer">
	                   <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>


@endsection
