<!-- **********************************
	Header start
*********************************** -->

@php
	$current_user 	= auth()->user();
	$user_name 		= isset($current_user->full_name) ? $current_user->full_name : '';
	$user_email 	= isset($current_user->email) ? $current_user->email : '';
	$userId 		= isset($current_user->id) ? $current_user->id : '';
	$userImg 		= HelpDesk::user_img($current_user->profile);
	$page_title  	= isset($page_title) ? $page_title : 'Dashboard';
@endphp

<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
					<div class="d-flex align-items-center flex-wrap me-auto">
						<h3 class="mb-0"> {{ $page_title }}</h3>
					</div>
                </div>
                <ul class="navbar-nav header-right main-notification">
                    <li class="nav-item dropdown notification_dropdown all position-relative d-flex d-md-none">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <svg height="24" class="svg-main-icon" viewBox="0 0 32 32" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><clipPath id="clip_1"><path id="artboard_1" clip-rule="evenodd" d="m0 0h32v32h-32z"/></clipPath><g id="select" clip-path="url(#clip_1)"><path id="Vector" d="m4.70222 7.16834-.12871-.2574c-.0593-.11861-.13904-.22136-.23922-.30824-.10018-.08689-.21317-.1513-.33898-.19323-.1258-.04194-.25484-.0582-.38711-.0488-.13228.0094-.25772.04375-.37633.10306-.24699.12349-.41414.31622-.50147.5782-.08732.26197-.06923.51645.05426.76344l1.32093 2.64183c.0593.1186.13904.2214.23922.3083.10018.0868.21317.1512.33898.1932.1258.0419.25484.0582.38711.0488.13228-.0094.25772-.0438.37633-.1031.01854-.0092.03678-.0191.05471-.0295s.03552-.0214.05277-.0329l5.99999-3.99995c.1104-.07356.2024-.16543.2762-.27561s.1237-.23029.1497-.36032c.026-.13004.0261-.2601.0004-.39019-.0257-.13008-.0754-.25029-.1489-.36063-.1532-.22977-.3652-.37173-.636-.42588-.2707-.05416-.521-.00465-.7508.14853l-1.94316 1.29545-3.1143 2.07619zm11.29778-1.16834c-.2761 0-.5118.09763-.7071.29289s-.2929.43097-.2929.70711.0976.51184.2929.70711c.1953.19526.431.29289.7071.29289h14c.2761 0 .5118-.09763.7071-.29289.1953-.19527.2929-.43097.2929-.70711s-.0976-.51185-.2929-.70711-.431-.29289-.7071-.29289zm-11.27691 9.1683-.12871-.2574c-.12349-.2469-.31622-.4141-.5782-.5014-.26197-.0874-.51645-.0693-.76344.0542-.11861.0593-.22135.1391-.30824.2393-.08688.1001-.15129.2131-.19323.3389-.04193.1258-.0582.2549-.0488.3871.0094.1323.04376.2578.10306.3764l1.32092 2.6418c.1235.247.31623.4142.5782.5015.26198.0873.51646.0692.76345-.0543.01854-.0092.03678-.0191.05471-.0295s.03552-.0214.05277-.0329l6.00002-3.9999c.2298-.1532.3717-.3652.4259-.636.0541-.2708.0046-.521-.1486-.7508-.1531-.2298-.3651-.3717-.6359-.4259-.2708-.0541-.521-.0046-.7508.1485l-5.05749 3.3717zm11.27691-.1683c-.2761 0-.5118.0976-.7071.2929s-.2929.431-.2929.7071.0976.5118.2929.7071.431.2929.7071.2929h14c.2761 0 .5118-.0976.7071-.2929s.2929-.431.2929-.7071-.0976-.5118-.2929-.7071-.431-.2929-.7071-.2929zm-11.27691 8.1683-.12871-.2574c-.12349-.247-.31622-.4141-.5782-.5014-.26197-.0874-.51645-.0693-.76344.0542-.11861.0593-.22135.1391-.30824.2393-.08688.1001-.15129.2131-.19323.3389-.04193.1258-.0582.2549-.0488.3871.0094.1323.04376.2578.10306.3764l1.32092 2.6418c.1235.247.31623.4142.5782.5015.26198.0873.51646.0692.76345-.0543.01854-.0092.03678-.0191.05471-.0295s.03552-.0214.05277-.0329l6.00002-4c.1103-.0735.2024-.1654.2762-.2756.0738-.1101.1237-.2303.1497-.3603s.0261-.2601.0004-.3902c-.0258-.1301-.0754-.2503-.149-.3606-.1531-.2298-.3651-.3717-.6359-.4259-.2708-.0541-.521-.0046-.7508.1485l-1.94319 1.2955-3.1143 2.0762zm11.27691.8317c-.2761 0-.5118.0976-.7071.2929s-.2929.431-.2929.7071.0976.5118.2929.7071.431.2929.7071.2929h14c.2761 0 .5118-.0976.7071-.2929s.2929-.431.2929-.7071-.0976-.5118-.2929-.7071-.431-.2929-.7071-.2929z" fill-rule="evenodd"/></g></svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="card mb-0">
                                <div class="p-1 border-0 d-block h-auto">
                                    <ul class="d-flex align-items-center justify-content-around">
                                        <li class="nav-item dropdown notification_dropdown">
                                            <a class="nav-link bell " title="Visit Site" target="blank" href="{{ url('/') }}">
                                                <i class="fas fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item dropdown notification_dropdown">
                                            <a class="nav-link bell dz-theme-mode" title="Dark Mode" href="#">
                                                <i id="icon-light" class="fas fa-sun"></i>
                                                <i id="icon-dark" class="fas fa-moon"></i>
                                                
                                            </a>
                                        </li>
                                        <li class="nav-item dropdown notification_dropdown">
                                            <a class="nav-link bell dz-fullscreen d-flex align-items-center justify-content-center" title="Fullscreen" href="#">
                                                <svg id="icon-full" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                                                <svg id="icon-minimize" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                                            </a>
                                        </li>          
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                	<li class="nav-item dropdown notification_dropdown d-none d-md-flex">
                        <a class="nav-link bell " title="Visit Site" target="blank" href="{{ url('/') }}">
							<i class="fas fa-home"></i>
                        </a>
					</li>
					<li class="nav-item dropdown notification_dropdown d-none d-md-flex">
                        <a class="nav-link bell dz-theme-mode" title="Dark Mode" href="#">
							<i id="icon-light" class="fas fa-sun"></i>
                            <i id="icon-dark" class="fas fa-moon"></i>
                        </a>
					</li>
					<li class="nav-item dropdown notification_dropdown d-none d-md-flex">
                        <a class="nav-link bell dz-fullscreen" title="Fullscreen" href="#">
                            <svg id="icon-full" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                            <svg id="icon-minimize" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                        </a>
					</li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="{{ $userImg }}" width="20" alt="{{ __('common.user_profile') }}"/>
							<div class="header-info">
								<span>{{ $user_name }}</span>
								<small>{{ implode(', ', Auth::user()->roles->pluck('name')->toArray()) }}</small>
							</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{!! route('admin.users.profile') !!}" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ms-2">{{ __('common.profile') }} </span>
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
								<a href="{!! route('admin.logout'); !!}" class="dropdown-item ai-icon LogOutBtn">
									<svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
									<span class="ms-2">{{ __('common.logout') }} </span>
								</a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
	</div>
</div>
<!--**********************************
	Header end ti-comment-alt
***********************************-->
