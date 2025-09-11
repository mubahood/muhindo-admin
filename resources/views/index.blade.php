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

    <!-- Dynamic Primary Color Override -->
    <?php
    // Get primary color from config
    $configured_color = config('admin.primary_color');
    $admin_skin = config('admin.skin', 'skin-green');
    
    $skin_color_map = [
        'skin-blue' => '#007bff',
        'skin-green' => '#198754',
        'skin-yellow' => '#ffc107',
        'skin-purple' => '#6f42c1',
        'skin-red' => '#dc3545',
        'skin-black' => '#343a40',
    ];
    
    if (!$configured_color && isset($skin_color_map[$admin_skin])) {
        $primary_color = $skin_color_map[$admin_skin];
    } else {
        $primary_color = $configured_color ?: '#198754';
    }
    
    $primary_rgb = sscanf($primary_color, '#%02x%02x%02x');
    $primary_hover = sprintf('#%02x%02x%02x', max(0, $primary_rgb[0] - 25), max(0, $primary_rgb[1] - 25), max(0, $primary_rgb[2] - 25));
    $primary_active = sprintf('#%02x%02x%02x', max(0, $primary_rgb[0] - 35), max(0, $primary_rgb[1] - 35), max(0, $primary_rgb[2] - 35));
    $focus_rgb = implode(', ', $primary_rgb);
    ?>
    <style>
        /* MUHINDO ADMIN PRIMARY COLOR OVERRIDE */
        :root {
            --bs-primary: <?php echo $primary_color; ?> !important;
            --bs-primary-rgb: <?php echo $focus_rgb; ?> !important;
            --primary-color: <?php echo $primary_color; ?> !important;
            --accent-color: <?php echo $primary_color; ?> !important;
        }

        /* STRONGEST BOOTSTRAP 5 BUTTON PRIMARY OVERRIDES */
        .btn-primary,
        .btn.btn-primary {
            background-color: <?php echo $primary_color; ?> !important;
            border-color: <?php echo $primary_color; ?> !important;
            color: #fff !important;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn.btn-primary:hover,
        .btn.btn-primary:focus {
            background-color: <?php echo $primary_hover; ?> !important;
            border-color: <?php echo $primary_hover; ?> !important;
            color: #fff !important;
        }

        .btn-primary:active,
        .btn.btn-primary:active {
            background-color: <?php echo $primary_active; ?> !important;
            border-color: <?php echo $primary_active; ?> !important;
            color: #fff !important;
        }

        /* FORM CONTROLS */
        .form-control:focus,
        .form-select:focus {
            border-color: <?php echo $primary_color; ?> !important;
            box-shadow: 0 0 0 0.25rem rgba(<?php echo $focus_rgb; ?>, 0.25) !important;
        }

        /* TEXT AND BACKGROUND */
        .text-primary {
            color: <?php echo $primary_color; ?> !important;
        }

        .bg-primary {
            background-color: <?php echo $primary_color; ?> !important;
            color: #fff !important;
        }

        .border-primary {
            border-color: <?php echo $primary_color; ?> !important;
        }

        /* BADGES AND PROGRESS */
        .badge.bg-primary,
        .badge-primary {
            background-color: <?php echo $primary_color; ?> !important;
        }

        .progress-bar {
            background-color: <?php echo $primary_color; ?> !important;
        }

        /* ADMIN COMPONENTS */
        .main-header,
        .main-header .navbar {
            background-color: <?php echo $primary_color; ?> !important;
        }

        .main-sidebar,
        .left-side {
            background-color: <?php echo $primary_color; ?> !important;
        }

        .main-header .logo:hover,
        .main-header .navbar .sidebar-toggle:hover,
        .main-header .navbar .nav>li>a:hover {
            background-color: <?php echo $primary_hover; ?> !important;
        }

        .sidebar-menu>li.active>a,
        .sidebar-menu>li:hover>a {
            background-color: <?php echo $primary_hover; ?> !important;
            border-left-color: #fff !important;
        }

        .card-primary .card-header {
            background-color: <?php echo $primary_color; ?> !important;
            border-color: <?php echo $primary_color; ?> !important;
        }

        /* LINKS */
        .link-primary,
        a.link-primary {
            color: <?php echo $primary_color; ?> !important;
        }

        .link-primary:hover,
        a.link-primary:hover {
            color: <?php echo $primary_hover; ?> !important;
        }

        /* ALERTS */
        .alert-primary {
            background-color: rgba(<?php echo $focus_rgb; ?>, 0.1) !important;
            border-color: rgba(<?php echo $focus_rgb; ?>, 0.2) !important;
            color: <?php echo $primary_active; ?> !important;
        }

        /* DROPDOWN ACTIVE */
        .dropdown-item:active {
            background-color: <?php echo $primary_color; ?> !important;
            color: #fff !important;
        }

        /* NAV TABS ACTIVE */
        .nav-tabs .nav-link.active {
            color: <?php echo $primary_color; ?> !important;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}

    <!-- PJAX Fallback CDN if local file fails -->
    <script>
        if (typeof $.pjax === 'undefined') {
            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js';
            document.head.appendChild(script);
        }
    </script>


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
        @include('admin::partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
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

            // Remove skip links immediately and periodically
            function removeSkipLinks() {
                const skipLinks = document.querySelector('.skip-links');
                if (skipLinks) {
                    skipLinks.remove();
                }
            }

            // Remove skip links on load
            removeSkipLinks();

            // Initialize AdminLTE
            if (typeof AdminLTE !== 'undefined') {
                AdminLTE.init();

                // Remove skip links after AdminLTE initialization
                setTimeout(removeSkipLinks, 100);
                setTimeout(removeSkipLinks, 500);
                setTimeout(removeSkipLinks, 1000);
            }

            // Watch for skip links being added and remove them
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1 && (node.classList.contains('skip-links') ||
                                node.querySelector('.skip-links'))) {
                            removeSkipLinks();
                        }
                    });
                });
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Initialize Bootstrap dropdowns manually if needed
            if (typeof bootstrap !== 'undefined') {
                // Initialize all dropdowns
                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });
            }

            // PJAX IMPLEMENTATION
            if (typeof $.pjax !== 'undefined') {

                // Check container
                const $container = $('#pjax-container');

                if ($container.length === 0) {
                    console.error('❌ PJAX container #pjax-container not found!');
                    return;
                }

                // Clear any existing PJAX handlers
                $(document).off('click.pjax');

                // PJAX Global Setup
                $.pjax.defaults.timeout = 8000;
                $.pjax.defaults.scrollTo = 0;

                // Manual PJAX click handler
                $(document).on('click', 'a[data-pjax]', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const href = $(this).attr('href');
                    console.log('� MANUAL PJAX TRIGGERED for:', href);

                    if (href && href !== '#' && href !== window.location.pathname + window.location
                        .search) {

                        $.pjax({
                            url: href,
                            container: '#pjax-container',
                            timeout: 8000,
                            push: true,
                            replace: false
                        }).fail(function(xhr, textStatus, errorThrown) {
                            console.error('❌ PJAX failed:', textStatus, errorThrown);
                            // Fallback to regular navigation
                            window.location = href;
                        });
                    }

                    return false;
                });

            } else {
                console.error('❌ PJAX library not available!');
            }

            // PJAX EVENT HANDLERS
            $(document).on('pjax:start', function(xhr, options) {
                $('.content-wrapper').addClass('loading');

                // Show loading indicator
                if (typeof NProgress !== 'undefined') {
                    NProgress.start();
                }
            });

            $(document).on('pjax:end', function(xhr, options) {
                $('.content-wrapper').removeClass('loading');

                // Hide loading indicator
                if (typeof NProgress !== 'undefined') {
                    NProgress.done();
                }

                // Reinitialize components after PJAX load
                setTimeout(function() {
                    // Reinitialize AdminLTE components
                    if (typeof AdminLTE !== 'undefined') {
                        AdminLTE.init();
                    }

                    // Reinitialize Bootstrap dropdowns
                    if (typeof bootstrap !== 'undefined') {
                        var dropdownElementList = [].slice.call(document.querySelectorAll(
                            '.dropdown-toggle'));
                        var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                            return new bootstrap.Dropdown(dropdownToggleEl);
                        });
                    }

                    // Reinitialize sidebar treeview
                    if (typeof $.fn.Treeview !== 'undefined') {
                        $('[data-widget="treeview"]').Treeview();
                    }

                    // Remove skip links after content load
                    removeSkipLinks();

                    // Trigger custom reinit event
                    $(document).trigger('admin:pjax:complete');
                }, 100);
            });

            $(document).on('pjax:error', function(xhr, textStatus, error, options) {
                console.error('❌ PJAX ERROR:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    textStatus: textStatus,
                    error: error,
                    url: options.url
                });
                $('.content-wrapper').removeClass('loading');

                // Hide loading indicator
                if (typeof NProgress !== 'undefined') {
                    NProgress.done();
                }

                // Show error message
                if (typeof toastr !== 'undefined') {
                    toastr.error('Navigation failed. Please try again.', 'Error');
                }
            });

            $(document).on('pjax:timeout', function(event) {
                // Prevent the timeout from aborting the request
                event.preventDefault();
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

            // Dashboard-specific init
            if (window.location.pathname.includes('dashboard') || window.location.pathname === '/admin' || window
                .location.pathname === '/admin/') {
                // Dashboard page specific initialization if needed
            }
        });
    </script>

</body>
});
</script>
</script>

</body>

</html>
