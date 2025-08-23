<!-- AdminLTE 4 Sidebar -->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ admin_url('/') }}" class="brand-link">
            <img src="{{ Admin::user()->avatar }}" alt="Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ config('admin.name', 'Laravel Admin') }}</span>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false">
                @each('admin::partials.menu', Admin::menu(), 'item')
            </ul>
        </nav>
    </div>
</aside>
