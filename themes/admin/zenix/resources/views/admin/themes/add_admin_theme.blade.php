{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	@if(!empty($active_theme) && !empty($themename))
		<div class="row">
			<div class="col-md-12">
				<h4>{{ __('common.installing_theme_upload_file') }} {{ $themename }}</h4>
				<p>{{ __('common.theme_installed_successfully') }}</p>
				<a href="{{ $active_theme }}" class="badge badge-primary">{{ __('common.active') }}</a>
				<a href="{{ route('themes.admin.admin_themes') }}" class="badge badge-primary">{{ __('common.all_themes') }}</a>
			</div>
		</div>
	@else
		<div class="row mb-4">
			<div class="col-md-12">
				<h4>{{ __('common.add_theme') }}</h4>
				<button type="button" class="btn btn-primary btn-sm" id="UploadThemeBtn">{{ __('common.upload_theme') }}</button>
				<div class="text-center">
					<div class="my-3 d-inline-block w-50 d-none" id="UploadThemeSec">
						<p class="install-help">{{ __('common.to_install_update_theme') }}</p>
						<form method="post" enctype="multipart/form-data" class="border border-primary bg-light p-5" id="InstallUploadTheme">
							@csrf
							<label class="screen-reader-text" for="theme_zip">{{ __('common.theme_zip_file') }}</label>
							<input type="file" id="theme_zip" name="theme_zip" accept=".zip">
							<input type="submit" name="install_theme" id="install_theme" class="btn btn-primary btn-xs" value="{{ __('common.install_now') }}" disabled>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row page-titles mx-0 mb-3">
			<div class="col-sm-6 p-0">
				<div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
			</div>
			<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
				<input type="search" name="search_apps" class="form-control w-25" id="SearchApps" placeholder="{{ __('common.search_themes') }}">
			</div>
		</div>

		<div class="d-block text-center mt-5 d-none ThemeSectionSpinner">
			<div class="spinner-grow text-primary" role="status">
				<span class="sr-only">{{ __('Loading...') }}</span>
			</div>
		</div>
		<div class="row" id="ThemeSection">
			@forelse($themes as $key => $theme)
				@php
					$theme->updated_at = Carbon\Carbon::parse($theme->updated_at)->format(config('Site.custom_date_format').' '.config('Site.custom_time_format'));
					$themename = Str::of($theme->title)->before(' ')->slug('-');
				@endphp
				<div class="col-md-3">
					<div class="card">
						<div class="card-body p-1">
							<div class="new-arrival-product">
								<img class="img-fluid" src="{{ $theme->preview_image }}" alt="{{ $theme->preview_image }}">
							</div>
						</div>
						<div class="card-footer p-3 border-top d-flex align-items-center justify-content-between flex-column gap-3">
							<h5 class="m-0 text-capitalize">{{ $theme->title }}</h5>
							<div class="d-flex justify-content-between gap-2 w-100">
								@if(Str::contains($currentTheme, $themename))
									<a href="javascript:void(0);" class="btn btn-xs btn-info w-100">{{ __('common.activated') }}</a>
								@elseif($theme->installed)
									<a href="{{ route('themes.admin.admin_themes', ['activate' => config('constants.themes_root.0').'/'.$themename]) }}" theme-name="{{ $themename }}" class="btn btn-xs btn-primary w-100">{{ __('common.active') }}</a>
								@else
									<a href="javascript:void(0);" theme-link="{{ $theme->package }}" theme-name="{{ $themename }}" theme-type="{{ config('constants.themes_root.0') }}" class="btn btn-xs btn-info w-100 InstallTheme">{{ __('common.install') }}</a>
								@endif
								<a href="javascript:void(0);" class="btn btn-xs btn-info light w-100 ThemePreview" theme-data="{{ json_encode($theme) }}">{{ __('common.preview') }}</a>
							</div>
						</div>
					</div>
				</div>
			@empty
			<div class="col-md-12">
				<div class="alert alert-primary text-center" role="alert">
					{{ __('common.themes_not_found') }}
				</div>
			</div>
		@endforelse
		</div>
	@endif

</div>

<div class="modal fade" id="basicModal">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div class="mb-4">
					<div class="tab-content">
						<img class="img-fluid rounded border-2" src="{{ asset('images/noimage.jpg') }}" alt="{{ __('noimage.jpg') }}">
					</div>
					<div class="tab-slide-content new-arrival-product mb-4 mb-xl-0">
						<ul class="nav slide-item-list mt-3" role="tablist">
						</ul>
					</div>
				</div>
				<h3 id="theme-modal-title">{{ __('Theme Name') }}</h3>
				<p id="modal-body-description">{{ __('Theme Content') }}</p>
				<p class="theme-tags border-top pt-3">
					<strong class="text-black">{{ __('Tags:') }}</strong>
					<div id="TagsContent"></div>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">{{ __('common.close') }}</button>
			</div>
		</div>
	</div>
</div>
@endsection

@push('inline-scripts')
	<script>
		'use strict';
		var installThemeRoute = '{{ route('themes.admin.install_theme') }}';
		addThemeRoute = '{{ route('themes.admin.add_admin_theme') }}';
	</script>
@endpush