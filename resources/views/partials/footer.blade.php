<!-- AdminLTE 4 Footer -->
<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">
        @if (config('admin.show_version'))
            Version {{ \Muhindo\Admin\Admin::VERSION }}
        @endif
    </div>
    <strong>Copyright © {{ date('Y') }} {{ config('admin.name', 'Laravel Admin') }}.</strong> 
    All rights reserved.
    
    @if (config('admin.show_environment') && config('app.env') !== 'production')
        <span class="badge bg-warning ms-2">{{ strtoupper(config('app.env')) }}</span>
    @endif
</footer>
