<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} {{ config('admin.name', 'Laravel Admin') }}.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        @if (config('admin.show_version'))
            <b>Version</b> {{ \Muhindo\Admin\Admin::VERSION }}
        @endif
        @if (config('admin.show_environment') && config('app.env') !== 'production')
            <span class="badge badge-warning ml-2">{{ strtoupper(config('app.env')) }}</span>
        @endif
    </div>
</footer>
