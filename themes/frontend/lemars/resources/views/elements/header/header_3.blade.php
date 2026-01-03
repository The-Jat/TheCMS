<header class="site-header mo-left header header-transparent style-3">
	<!-- top-bar -->
	<div class="container">
		<div class="top-bar">
			<div class="row d-flex justify-content-between align-items-center">
				@if (!empty($header_button_1_text))
					<a href="{{ !empty($header_button_1_url) ? $header_button_1_url : 'javascript:void(0);' }}"  target="{{ $header_button_1_target ?? '' }}" class="btn black radius-xl">{{ $header_button_1_text }}</a>
				@endif
				<!-- website logo -->
				<div class="logo-header">
					@if ($logo_type == 'text_logo')
					<div class="text-logo">
						@if (!empty($logo_text))
						<h1 class="site-title">
							<a href="{{url( '/' )}}" title="{{$logo_title}}">
								{{$logo_text}}
							</a>
						</h1>
						@endif
					</div>
					@else
					<a href="{{url( '/' )}}" title="{{$logo_title}}">
						<img src="{{DzHelper::siteLogo()}}" alt="{{$logo_alt}}"/>
					</a>
					@endif
				</div>
				<div class="dlab-topbar-right topbar-social">
					@if ($header_social_link_on && $show_social_icon)
					<ul class="dz-social-link">
						{!! get_social_icons(null,'') !!}
					</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
	<!-- top-bar end -->
	<!-- main header -->
    <div class="{{$header_sticky_class}} main-bar-wraper navbar-expand-lg">
        <div class="main-bar clearfix ">
            <div class="container">
				<div class="header-content-bx no-bdr">
					<!-- website logo -->
					<div class="logo-header">
						@if ($logo_type == 'text_logo')
						<div class="text-logo">
							@if (!empty($logo_text))
							<h1 class="site-title">
								<a href="{{url( '/' )}}" title="{{$logo_title}}">
									{{$logo_text}}
								</a>
							</h1>
							@endif
						</div>
						@else
						<a href="{{url( '/' )}}" title="{{$logo_title}}">
							<img src="{{DzHelper::siteLogoLight()}}" alt="{{$logo_alt}}"/>
						</a>
						@endif
					</div>
					<!-- nav toggle button -->
					<button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<!-- main nav -->
					<div class="header-nav navbar-collapse collapse justify-content-center" id="navbarNavDropdown">
						<div class="logo-header">
							@if ($logo_type == 'text_logo')
							<div class="text-logo">
								@if (!empty($logo_text))
								<h1 class="site-title">
									<a href="{{url( '/' )}}" title="{{$logo_title}}">
										{{$logo_text}}
									</a>
								</h1>
								@endif
							</div>
							@else
							<a href="{{url( '/' )}}" title="{{$logo_title}}">
								<img src="{{DzHelper::siteLogoLight()}}" alt="{{$logo_alt}}"/>
							</a>
							@endif
						</div>
						{{ DzHelper::nav_menu(
						  	array(
						 		'theme_location'  => 'primary',
						 		'menu_class'      => 'nav navbar-nav',
						  	)
						  ); }}
                        <div class="btn-white text-center">
                            @if (DzHelper::languageBoxPosition()=='Header')
                                {!! DzHelper::languageSelectBoxStyle() !!}
                            @endif
                        </div>
						<div class="social-menu">
							@if ($header_social_link_on && $show_social_icon && $mobile_header_social_link_on)
							<ul class="dz-social-link">
								{!! get_social_icons(null,'') !!}
							</ul>
							@endif
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
    <!-- main header END -->
</header>
