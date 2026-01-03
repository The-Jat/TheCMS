<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

	<!-- PAGE TITLE HERE -->
	<title>{{ !empty($seoMeta['title']) ? $seoMeta['title'] : config('Site.title') }}</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Meta Tags --}}
    @include('elements.meta')
    {{-- Meta Tags --}}

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="canonical" href="{{ url()->current() }}" />

	<!-- FAVICONS ICON -->
	<link rel="icon" type="image/png" sizes="32x32" href="{{ $site_favicon }}">

	<!-- STYLESHEETS -->
	<link rel="stylesheet" href="{{ theme_asset('plugins/swiper/swiper-bundle.min.css') }}">
	<link rel="stylesheet" href="{{ theme_asset('plugins/owl-carousel/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/plugins-min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/style.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/custom.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ theme_asset('css/templete.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/default-element-min.css') }}">
	<link class="skin" rel="stylesheet" type="text/css" href="{{ theme_asset('css/skin/skin-1-min.css') }}">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body id="bg">
	<div class="page-wraper">

		<!-- Header Style -->
		@if (!empty($header_style))
			@include('elements.header.'.$header_style)
		@else
			@include('elements.header.header_1')
		@endif
		<!-- End Set Header Style -->

		<!-- Page Content -->
		<div class="page-content bg-white">

			@yield('content')


			<!-- Footer Subscription Box For every Page -->
			@if (!empty($footer_subscription_section))
				@include('elements.footer_subscription')
			@endif
			<!-- End Footer Subscription Box For every Page -->

		</div>
		<!-- End Page Content -->

		<!-- Footer Start-->
		@if(!empty($footer_on))
        	@include('elements/footer/'.$footer_style)
        @endif
		<!-- Footer End-->

		<button class="scroltop fas fa-chevron-up" ></button>

	</div>

	

	<script>
		var dynamicDate = "{{ $comingsoon_launch_date ?? date('Y-m-d', strtotime('+1 day')) }}";
		var baseUrl = '{{ url('/') }}';
	</script>

	<!-- JAVASCRIPT FILES -->
	<script src="{{ theme_asset('js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
	@stack('inline-scripts') <!-- inline-scripts have code of jquery thats why we call it after jquery.min.js -->
	<script src="{{ theme_asset('plugins/bootstrap/js/popper.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="{{ theme_asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="{{ theme_asset('plugins/magnific-popup/magnific-popup.js') }}"></script><!-- MAGNIFIC POPUP JS -->
	<script src="{{ theme_asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script><!-- FORM JS -->
	<script src="{{ theme_asset('plugins/owl-carousel/owl.carousel.min.js') }}"></script><!-- SWIPER SLIDER -->
	<script src="{{ theme_asset('plugins/swiper/swiper-bundle.min.js') }}"></script><!-- SWIPER SLIDER -->
	<script src="{{ theme_asset('plugins/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED -->
	<script src="{{ theme_asset('plugins/masonry/masonry-3.1.4.js') }}"></script><!-- MASONRY -->
	<script src="{{ theme_asset('plugins/masonry/masonry.filter.js') }}"></script><!-- MASONRY -->
	<script src="{{ theme_asset('js/custom.min.js') }}"></script><!-- CUSTOM FUCTIONS  -->
	<script src="{{ theme_asset('js/w3cms_frontend_min.js') }}"></script><!-- W3cms_Frontend JS -->

  	@stack('inline-swiper')
</body>
</html>
