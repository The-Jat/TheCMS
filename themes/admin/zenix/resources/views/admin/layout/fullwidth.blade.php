<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
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
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/configuration-images/'.config('Site.favicon')) }}">
    @else 
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    @endif


    @php
        $action = DzHelper::controller().'_'.DzHelper::action();
    @endphp
    @if(isset($action) && !empty(config('dz.public.pagelevel.css.'.$action)))
        @foreach(config('dz.public.pagelevel.css.'.$action) as $style)
            <link href="{{ theme_asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif

    {{-- Global Theme Styles (used by all pages) --}}
    @if(!empty(config('dz.public.global.css')))
        @foreach(config('dz.public.global.css') as $style)
            <link href="{{ theme_asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif

</head>

<body class="Vh-100 {{ (preg_match('(login|register|forgot-password|two-factor-challenge)', URL::current()) == 1) ? 'authPages' : '' }}">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
            @yield('content')
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->


    <script>
        'use strict';
        var baseUrl = "{{ url('/') }}";
        var csrf_token = "{{ csrf_token() }}";
        var enableCkeditor = '{!! config('Writing.editable') !!}';
        var makeSlugUrl = '<?php echo route('configurations.make_slug') ?>';
        var direction = '<?php echo config('Site.direction', 'ltr') ?>';
        var admin_theme = '<?php echo config('Settings.admin_layout', "0") ?>';
        var uploadFilesRoute = '<?php echo route('configurations.upload_files') ?>';
        var removeFilesRoute = '<?php echo route('configurations.remove_files') ?>';
        var addThemeRoute = '<?php echo route('themes.admin.add_theme') ?>';
        var dzSettingsOptions = JSON.parse('<?php echo config('Settings.admin_layout_options', json_encode(config('constants.dezThemeSet0'))) ?>');
    </script>

    @stack('inline-scripts')

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

    @yield('scripts')

</body>

</html>
