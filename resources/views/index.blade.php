<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Admin::title() }} @if ($header) | {{ $header }} @endif</title>
    
    <!-- Responsive meta -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Modern accessibility and theme meta tags -->
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#2563eb" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1e293b" media="(prefers-color-scheme: dark)">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('assets/img/logo.png') }}">

    {!! Admin::css() !!}

    <!-- Scripts -->
    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary {{ join(' ', config('admin.layout')) }}">

    @if ($alert = config('admin.top_alert'))
        <div class="alert alert-warning" style="text-align: center; padding: 1rem; font-size: 0.875rem; margin: 0; border-radius: 0;">
            {!! $alert !!}
        </div>
    @endif

    <div class="app-wrapper">
        @include('admin::partials.header')
        @include('admin::partials.sidebar')
        
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    {!! Admin::style() !!}
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid" id="pjax-container">
                    <div id="app">
                        @yield('content')
                    </div>
                    {!! Admin::script() !!}
                    {!! Admin::html() !!}
                </div>
            </div>
        </main>

        @include('admin::partials.footer')
    </div>

    <!-- Back to top button -->
    <button id="totop" class="btn btn-primary" title="Go to top" style="display: none; position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; border-radius: 50%; z-index: 1000; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Global JavaScript variables -->
    <script>
        function LA() {}
        LA.token = "{{ csrf_token() }}";
        LA.user = @json($_user_);
    </script>

    <!-- Required JS Scripts -->
    {!! Admin::js() !!}

    <script>
        $(document).ready(function() {
            console.log('Admin panel initialized');
            console.log('jQuery version:', $.fn.jquery);
            console.log('PJAX available:', typeof $.pjax !== 'undefined');
            
            // PJAX event debugging
            $(document).on('pjax:start', function(event) {
                console.log('PJAX START:', event);
            });
            
            $(document).on('pjax:send', function(event) {
                console.log('PJAX SEND:', event);
            });
            
            $(document).on('pjax:success', function(event) {
                console.log('PJAX SUCCESS:', event);
            });
            
            $(document).on('pjax:complete', function(event) {
                console.log('PJAX COMPLETE:', event);
            });
            
            $(document).on('pjax:error', function(event) {
                console.log('PJAX ERROR:', event);
            });
            
            $(document).on('pjax:timeout', function(event) {
                console.log('PJAX TIMEOUT:', event);
            });
            
            // Test if main elements exist
            console.log('App container:', $('#app').length);
            console.log('PJAX container:', $('#pjax-container').length);
            console.log('Sidebar menu links:', $('.sidebar-menu .nav-link').length);
            
            // Test click events on menu
            $('.sidebar-menu .nav-link').on('click', function(e) {
                console.log('Menu link clicked:', $(this).attr('href'));
            });
            
            // Back to top functionality
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#totop').fadeIn();
                } else {
                    $('#totop').fadeOut();
                }
            });
            
            $('#totop').click(function() {
                $('html, body').animate({scrollTop: 0}, 500);
                return false;
            });
            
            // Add some dashboard styling if on dashboard
            if (window.location.pathname.endsWith('/admin') || window.location.pathname.endsWith('/admin/')) {
                $('body').addClass('dashboard-page');
                console.log('Dashboard page detected');
            }
        });
    </script>

</body>
</html>
