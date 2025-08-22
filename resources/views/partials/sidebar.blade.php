<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Brand -->
    <div class="sidebar-brand">
        <a href="{{ admin_url('/') }}" class="brand-link">
            <img src="{{ url('assets/img/logo.png') }}" alt="{{ env('APP_NAME', 'AdminLTE') }} Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ env('APP_NAME', 'AdminLTE') }}</span>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!-- Sidebar user panel (optional) -->
            <div class="nav-header">
                <div class="user-panel d-flex">
                    <div class="image">
                        <img src="{{ Admin::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ admin_url('auth/setting') }}" class="d-block text-white text-decoration-none">{{ Admin::user()->name }}</a>
                        <span class="badge badge-success">{{ trans('admin.online') }}</span>
                    </div>
                </div>
            </div>

            @if (config('admin.enable_menu_search'))
                <!-- Search form (Optional) -->
                <div class="form-inline mt-2">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar autocomplete" type="search" placeholder="Search..." aria-label="Search" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                        <div class="sidebar-search-results">
                            <div class="list-group">
                                @foreach (Admin::menuLinks() as $link)
                                    <a href="{{ admin_url($link['uri']) }}" class="list-group-item">
                                        <i class="fas {{ $link['icon'] }} fa-fw"></i>
                                        {{ admin_trans($link['title']) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-header text-uppercase">{{ trans('admin.menu') }}</li>
                
                @each('admin::partials.menu', Admin::menu(), 'item')
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
