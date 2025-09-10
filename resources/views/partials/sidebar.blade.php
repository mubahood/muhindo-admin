<!-- Brand Logo -->
<a href="{{ admin_url('/') }}" class="brand-link" data-pjax>
    <img src="{{ admin_asset('img/logo.png') }}" alt="{{ config('admin.name') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('admin.name', 'Laravel Admin') }}</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ Admin::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="{{ admin_url('auth/users/'.Admin::user()->id.'/edit') }}" class="d-block" data-pjax>{{ Admin::user()->name }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @each('admin::partials.menu', Admin::menu(), 'item')
        </ul>
    </nav>
</div>
