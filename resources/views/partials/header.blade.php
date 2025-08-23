<!-- AdminLTE 4 Header -->
<nav class="app-header navbar navbar-expand bg-body">
    <!-- Container -->
    <div class="container-fluid">
        <!-- Start Navbar Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ admin_url('/') }}" class="nav-link">{{ trans('admin.dashboard') }}</a>
            </li>
        </ul>

        <!-- End Navbar Links -->
        <ul class="navbar-nav ms-auto">
            
            <!-- User Account Menu -->
            <li class="nav-item dropdown user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- The user image in the navbar-->
                    <img src="{{ Admin::user()->avatar }}" class="user-image rounded-circle shadow" alt="User Image">
                    <!-- hidden on small devices so only the image appears. -->
                    <span class="d-none d-md-inline">{{ Admin::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!-- User image -->
                    <li class="user-header text-bg-primary">
                        <img src="{{ Admin::user()->avatar }}" class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{ Admin::user()->name }}
                            <small>Member since {{ Admin::user()->created_at->format('M Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ admin_url('auth/setting') }}" class="btn btn-default btn-flat">{{ trans('admin.setting') }}</a>
                        <a href="{{ admin_url('auth/logout') }}" class="btn btn-default btn-flat float-end">{{ trans('admin.logout') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
            
            <!-- User Account Menu -->
            <li class="nav-item dropdown user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- The user image in the navbar-->
                    <img src="{{ Admin::user()->avatar }}" class="user-image rounded-circle shadow" alt="User Image">
                    <!-- hidden on small devices so only the image appears. -->
                    <span class="d-none d-md-inline">{{ Admin::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!-- User image -->
                    <li class="user-header text-bg-primary">
                        <img src="{{ Admin::user()->avatar }}" class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{ Admin::user()->name }}
                            <small>Member since {{ Admin::user()->created_at->format('M Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ admin_url('auth/setting') }}" class="btn btn-default btn-flat">{{ trans('admin.setting') }}</a>
                        <a href="{{ admin_url('auth/logout') }}" class="btn btn-default btn-flat float-end">{{ trans('admin.logout') }}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
