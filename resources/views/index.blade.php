<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Admin::title() }} @if ($header)
            | {{ $header }}
        @endif
    </title>

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

    <!-- Additional AdminLTE 4 optimizations -->
    <style>
        .wrapper {
            min-height: 100vh;
        }

        .main-header {
            border-bottom: 1px solid #dee2e6;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .08);
        }

        .main-sidebar {
            box-shadow: 2px 0 6px rgba(0, 0, 0, .1);
        }

        .content-wrapper {
            background-color: #f4f6f9;
            min-height: calc(100vh - 57px);
        }

        .content-header {
            padding: 15px 15px 0 15px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 15px;
        }

        .content {
            padding: 0 15px 15px 15px;
        }

        /* Responsive improvements */
        @media (max-width: 767.98px) {
            .content-wrapper {
                margin-left: 0;
            }

            .main-sidebar {
                margin-left: -250px;
            }

            .sidebar-open .main-sidebar {
                margin-left: 0;
            }
        }

        /* Loading state */
        .content-wrapper.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .content-wrapper.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 32px;
            height: 32px;
            margin: -16px 0 0 -16px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed {{ join(' ', config('admin.layout')) }}">

    @if ($alert = config('admin.top_alert'))
        <div class="alert alert-warning"
            style="text-align: center; padding: 1rem; font-size: 0.875rem; margin: 0; border-radius: 0;">
            {!! $alert !!}
        </div>
    @endif

    <div class="wrapper">
        @include('admin::partials.header')
     {{--    @include('admin::partials.sidebar') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @if (isset($header))
                                <h1 class="m-0">{{ $header }}</h1>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @if (isset($breadcrumbs))
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        @if ($loop->last)
                                            <li class="breadcrumb-item active">{{ $breadcrumb['text'] }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['url'] }}"
                                                    class="text-decoration-none">{{ $breadcrumb['text'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ol>
                        </div>
                    </div>
                    {!! Admin::style() !!}
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid" id="pjax-container">
                    <div id="app">
                        @yield('content')
                    </div>
                    {!! Admin::script() !!}
                    {!! Admin::html() !!}
                </div>
            </section>
        </div>

        @include('admin::partials.footer')
    </div>

    <!-- Back to top button -->
    <button id="totop" class="btn btn-primary" title="Go to top"
        style="display: none; position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; border-radius: 50%; z-index: 1000; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
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

            // Initialize AdminLTE
            if (typeof AdminLTE !== 'undefined') {
                AdminLTE.init();
            }

            // PJAX configuration
            if (typeof $.pjax !== 'undefined') {
                $(document).pjax('a[data-pjax]', '#pjax-container', {
                    timeout: 8000,
                    push: true,
                    replace: false
                });
            }

            // PJAX event handling
            $(document).on('pjax:start', function(event) {
                console.log('PJAX START:', event);
                $('.content-wrapper').addClass('loading');
            });

            $(document).on('pjax:end', function(event) {
                console.log('PJAX COMPLETE:', event);
                $('.content-wrapper').removeClass('loading');

                // Reinitialize components after PJAX load
                if (typeof Admin !== 'undefined' && Admin.reinitialize) {
                    Admin.reinitialize();
                }

                // Reinitialize AdminLTE components
                if (typeof AdminLTE !== 'undefined') {
                    AdminLTE.init();
                }
            });

            $(document).on('pjax:error', function(event) {
                console.log('PJAX ERROR:', event);
                $('.content-wrapper').removeClass('loading');
            });

            // Mobile sidebar handling
            $('[data-widget="pushmenu"]').on('click', function(e) {
                e.preventDefault();

                if ($(window).width() <= 991.98) {
                    $('body').toggleClass('sidebar-open');
                } else {
                    $('body').toggleClass('sidebar-collapse');
                }
            });

            // Auto-hide sidebar on mobile when clicking content
            $('.content-wrapper').on('click', function() {
                if ($(window).width() <= 991.98 && $('body').hasClass('sidebar-open')) {
                    $('body').removeClass('sidebar-open');
                }
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
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                return false;
            });

            // Dashboard page detection
            if (window.location.pathname.endsWith('/admin') || window.location.pathname.endsWith('/admin/')) {
                $('body').addClass('dashboard-page');
                console.log('Dashboard page detected');
            }

            // Test main elements
            console.log('App container:', $('#app').length);
            console.log('PJAX container:', $('#pjax-container').length);
            console.log('Sidebar menu links:', $('.nav-sidebar .nav-link').length);
        });
    </script>

</body>

</html>
