<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="description" content="@yield('page_description', $page_description ?? '')" />
    <meta name="format-detection" content="telephone=no">
    
    <title>
        {{ config('Site.title') ? config('Site.title') : config('dz.name') }}
        @hasSection('title')
            | @yield('title')
        @elseif (!empty($page_title))
            | {{ $page_title }}
        @endif
    </title>
    <!-- Favicon icon -->
    @if(config('Site.favicon'))
        <link rel="icon" type="image/png" href="{{ asset('storage/configuration-images/'.config('Site.favicon')) }}">
    @else 
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    @endif
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet" type="text/css"/>

    @php
        $action = DzHelper::controller().'_'.DzHelper::action();
        $admin_layout_options = json_decode(config('Settings.admin_layout_options', json_encode(config('constants.dezThemeSet0'))));
    @endphp
    @if(isset($action) && !empty(config('dz.public.pagelevel.css.'.$action))) 
        @foreach(config('dz.public.pagelevel.css.'.$action) as $style)
            <link href="{{ theme_asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif  

    {{-- Global Theme Styles (used by all pages) --}}
    @if(!empty(config('dz.public.global.css')))
        @foreach(config('dz.public.global.css') as $style)
            @if($admin_layout_options->direction == 'rtl' && str_contains('css/style.css', $style))
                @php
                    $style = str_replace('css/style.css', 'css/style-rtl.css', $style);
                @endphp
            @endif
            <link href="{{ theme_asset($style) }}" {!! str_contains('css/style.css', $style) ? 'id="ChangeStyleRtl"' : '' !!} rel="stylesheet" type="text/css"/>
        @endforeach
    @endif

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">


</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{!! url('/admin'); !!}" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('images/logo.png') }}">
                <img class="brand-title" src="{{ asset('images/logo-text.png') }}">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        
          @include('admin.elements.header')
        
        
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        
        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('admin.elements.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->
        
        <!--**********************************
            Content body start kri
        ***********************************-->
        <div class="content-body">
            @include('admin.elements.alert_message')
            <!-- row -->
            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        
        @include('admin.elements.footer')
        
        <!--**********************************
            Footer end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Role, User Permissions Model Start
    ***********************************-->
    <div class="modal fade" id="AssignRevokePermissionsModal">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('common.permissions') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="AssignRevokePermissionsModalBody">
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Role, User Permissions Model End
    ***********************************-->

    <!--**********************************
        Flaticon select model Start
    ***********************************-->
    <div class="custom-modal-wrapper" id="selectIcon">
        <div class="custom-modal-content">
            <div class="modal-head border-bottom">
                <span class="close-btn" id="closeModal">&times;</span>
                <h3>{{ __('Select Icons') }}</h3>
            </div>
            <div class="row py-3">
            </div>
        </div>
    </div>
    <!--**********************************
        Flaticon select model End
    ***********************************-->

    <!--**********************************
        Global Ajax Modals
    ***********************************-->
    <div class="modal fade" id="AjaxModalBoxXl">
        <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
            <div class="modal-content" id="AjaxResultContainerXl">
                <div class="d-flex p-3 flex-column align-items-center">
                    <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                    <span>&nbsp;&nbsp;Loading... </span>
                </div>
            </div>  
        </div>  
    </div>

    <div class="modal fade" id="AjaxModalBoxMd" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="AjaxResultContainerMd" >
                <div class="d-flex p-3 flex-column align-items-center">
                    <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                    <span>&nbsp;&nbsp;Loading... </span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AjaxModalBoxLg" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content " id="AjaxResultContainerLg">
                <div class="d-flex p-3 flex-column align-items-center">
                    <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                    <span>&nbsp;&nbsp;Loading... </span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AjaxModalBoxSm" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content " id="AjaxResultContainerSm">
                <div class="d-flex p-3 flex-column align-items-center">
                    <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                    <span>&nbsp;&nbsp;Loading... </span>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Global Ajax Modals End
    ***********************************-->

    @stack('inline-modals')

    <!--**********************************
        Scripts
    ***********************************-->
    <script>
        'use strict';
        var baseUrl = "{{ url('/') }}";
        var asset = "{{ asset('/') }}";
        var active_frontend_theme = "{{ config('Theme.select_theme') }}";
        var csrf_token = "{{ csrf_token() }}";
        var enableCkeditor = '{!! config('Writing.editable') !!}';
        var makeSlugUrl = '{{ route('configurations.make_slug') }}';
        var direction = '{{ config('Site.direction', 'ltr') }}';
        var admin_theme = '{{ config('Settings.admin_layout', "0") }}';
        var uploadFilesRoute = '{{ route('configurations.upload_files') }}';
        var removeFilesRoute = '{{ route('configurations.remove_files') }}';
        var addThemeRoute = '{{ route('themes.admin.add_theme') }}';
        var dzSettingsOptions = JSON.parse('<?php echo config('Settings.admin_layout_options', json_encode(config('constants.dezThemeSet0'))) ?>');
    </script>

    @if(!empty(config('dz.public.global.js.top')))
        @foreach(config('dz.public.global.js.top') as $script)
            <script src="{{ theme_asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif
    @if(!empty(config('dz.public.pagelevel.js.'.$action)))
        @foreach(config('dz.public.pagelevel.js.'.$action) as $script)
            <script src="{{ theme_asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif
    @if(!empty(config('dz.public.global.js.bottom')))
        @foreach(config('dz.public.global.js.bottom') as $script)
            <script src="{{ theme_asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif
    
    @stack('inline-scripts')
    
</body>
</html>