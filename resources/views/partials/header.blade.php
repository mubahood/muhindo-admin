<header class="main-header admin-header">
    <div class="header-container">

        <!-- Left Section: Toggle + Logo -->
        <div class="header-left" style="min-width: 210px;">


            <!-- App Logo -->
            <a href="{{ admin_url('/') }}" class="app-logo">
                <div class="logo-content">
                    <span class="logo-main">{!! config('admin.logo', config('admin.name', 'Admin')) !!}</span>
                    <span class="logo-mini">{!! config('admin.logo-mini', 'A') !!}</span>
                </div>
            </a>
        </div>
        <!-- Sidebar Toggle -->
        <button type="button" class="sidebar-toggle btn-clean" data-widget="pushmenu" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>

        <!-- Center Section: Navigation -->
        <div class="header-center">
            <nav class="main-nav">
                {!! Admin::getNavbar()->render('left') !!}
            </nav>
        </div>

        <!-- Right Section: Actions + User -->
        <div class="header-right">
            <!-- Additional Nav Items -->
            <div class="nav-actions">
                {!! Admin::getNavbar()->render() !!}
            </div>

            <!-- User Menu -->
            <div class="user-section dropdown ">
                <a href="#" class="user-trigger" data-bs-toggle="dropdown" aria-expanded="false"
                    id="userDropdown">
                    <img src="{{ Admin::user()->avatar }}" class="user-avatar" alt="Avatar">
                    <div class="user-details">
                        <span class="user-name">{{ Admin::user()->name }}</span>
                        <small class="user-role">Administrator</small>
                    </div>
                    <i class="bi bi-chevron-down user-arrow"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end user-menu my-user-menu" aria-labelledby="userDropdown">
                    <div class="user-profile">
                        <img src="{{ Admin::user()->avatar }}" class="profile-avatar" alt="Avatar">
                        <div class="profile-info">
                            <h6 class="profile-name">{{ Admin::user()->name }}</h6>
                            <small class="profile-joined">Member since
                                {{ Admin::user()->created_at->format('M Y') }}</small>
                        </div>
                    </div>

                    <div class="menu-divider"></div>

                    <a href="{{ admin_url('auth/setting') }}" class="menu-item" style="color: black!important;">
                        <i class="fas fa-cog"  style="color: black!important;"></i>
                        <span>{{ trans('admin.setting') }}</span>
                    </a>

                    <a href="{{ admin_url('auth/logout') }}" class="menu-item logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>{{ trans('admin.logout') }}</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</header>
