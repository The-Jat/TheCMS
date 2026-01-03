@php
	$routeName = Route::currentRouteName();
	$assetUrl = DzHelper::GetBaseUrl('AssetUrl');
	$link1 = $link2 = $link3 = $link4 = $link5 = 'javascript:void(0);';
	$class1 = $class2 = $class3 = $class4 = $class5 = '';
@endphp

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ trans('installation::installer_messages.title') }}</title>
		<link rel="icon" type="image/x-icon" href="{{ $assetUrl.'/installer/img/favicon/favicon.ico' }}">
		<!-- Bootrap for the demo page -->
		<link href="{{ $assetUrl.'installer/font-awesome/css/all.min.css' }}" rel="stylesheet">
		<link href="{{ $assetUrl.'installer/bootstrap/css/bootstrap.min.css' }}" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
		<!-- Animate CSS for the css animation support if needed -->
		<!-- Include SmartWizard CSS -->
		<link href="{{ $assetUrl.'installer/css/style.css' }}" rel="stylesheet" type="text/css">
	</head>
   <body class="h-100">

   		<div class="wizard-wrapper">
			<div class="container">
				<div id="smartwizard" class="custome-wz">
					<div class="wizard-header">
						<div class="wizard-logo">
							<img src="{{ $assetUrl.'installer/images/logo-full-white.png' }}" alt="">
							<span class="version-text">{{ __('installation::installer_messages.version')}} {{ config('constants.version') }}</span>
						</div>
						<div class="wizard-nav">
							<ul class="nav nav-progress">
								<li class="nav-item">
									@if((in_array($routeName, ['LaravelInstaller::welcome', 'LaravelInstaller::requirements', 'LaravelInstaller::environmentWizard', 'LaravelInstaller::admin', 'LaravelInstaller::database', 'LaravelInstaller::final'])))
										@php
											$link1 = route('LaravelInstaller::welcome');
											$class1 = 'active';
										@endphp
									@endif
									<a class="nav-link {{ $class1 }}" href="{{ $link1 }}">
										<div class="num">1</div>
										{{ trans('installation::installer_messages.welcome.choose_language') }}
									</a>
								</li>
								<li class="nav-item">
									@if((in_array($routeName, ['LaravelInstaller::requirements', 'LaravelInstaller::environmentWizard', 'LaravelInstaller::admin', 'LaravelInstaller::database', 'LaravelInstaller::final'])))
										@php
											$link2 = route('LaravelInstaller::requirements');
											$class2 = 'active';
										@endphp
									@endif
									<a class="nav-link {{ $class2 }}" href="{{ $link2 }}">
										<span class="num">2</span>
										{{ trans('installation::installer_messages.welcome.verify_requirements') }}
									</a>
								</li>
								<li class="nav-item">
									@if((in_array($routeName, ['LaravelInstaller::environmentWizard', 'LaravelInstaller::admin', 'LaravelInstaller::database', 'LaravelInstaller::final'])))
										@php
											$link3 = route('LaravelInstaller::requirements');
											$class3 = 'active';
										@endphp
									@endif
									<a class="nav-link EnvStepsLink Step3 {{ $class3 }}" href="{{ $link3 }}">
										<span class="num">3</span>
										{{ trans('installation::installer_messages.welcome.setup_environment') }}
									</a>
								</li>
								<li class="nav-item">
									@if((in_array($routeName, ['LaravelInstaller::database', 'LaravelInstaller::admin', 'LaravelInstaller::final'])))
										@php
											$link4 = route('LaravelInstaller::admin');
											$class4 = 'active';
										@endphp
									@endif
									<a class="nav-link {{ $class4 }}" href="{{ $link4 }}">
									  <span class="num">4</span>
									  {{ trans('installation::installer_messages.welcome.configure_site') }}
									</a>
								</li>
								<li class="nav-item">
									@if((in_array($routeName, ['LaravelInstaller::final'])))
										@php
											$link5 = url('/admin');
											$class5 = 'active';
										@endphp
									@endif
									<a class="nav-link {{ $class5 }}" href="{{ $link5 }}">
									  <span class="num">5</span>
									  {{ trans('installation::installer_messages.final.title') }}
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="wizard-content">
						@yield('container')
					</div>
				</div>
			</div>
			<!-- SmartWizard html -->
		</div>

		<script src="{{ $assetUrl.'installer/js/jquery.min.js' }}"></script>
		<script src="{{ $assetUrl.'installer/bootstrap/js/bootstrap.min.js' }}"></script>
		<script src="{{ $assetUrl.'installer/js/custom-min.js' }}"></script>
	</body>
</html>