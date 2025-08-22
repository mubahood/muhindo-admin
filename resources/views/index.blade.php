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
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- AdminLTE 4 accessibility meta tags -->
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">

    {{--     @if (!is_null($favicon = Admin::favicon()))
    <link rel="shortcut icon" href="{{$favicon}}">
    @endif --}}

    <link rel="shortcut icon" href="{{ url('assets/img/logo.png') }}">

    {!! Admin::css() !!}

    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary {{ join(' ', config('admin.layout')) }}">

    @if ($alert = config('admin.top_alert'))
        <div style="text-align: center;padding: 5px;font-size: 12px;background-color: #ffffd5;color: #ff0000;">
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

    <button id="totop" title="Go to top" style="display: none;"><i class="fa fa-chevron-up"></i></button>

    <script>
        function LA() {}
        LA.token = "{{ csrf_token() }}";
        LA.user = @json($_user_);
    </script>

    <!-- REQUIRED JS SCRIPTS -->
    {!! Admin::js() !!}

</body>

</html>
