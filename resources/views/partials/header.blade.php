<!-- Main Header -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ admin_url('/') }}" class="nav-link" data-pjax>
                <i class="fas fa-home mr-1"></i>{{ trans('admin.home') }}
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button" aria-label="Search">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="{{ trans('admin.search') }}" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit" aria-label="Submit search">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search" aria-label="Close search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-label="Messages">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="{{ admin_asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-label="Notifications">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>

        <!-- User Account Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-label="User menu">
                <img src="{{ Admin::user()->avatar }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ Admin::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ Admin::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
                    <p>
                        {{ Admin::user()->name }}
                        <small>{{ trans('admin.member_since') }} {{ Admin::user()->created_at->format('M Y') }}</small>
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a href="#" class="btn btn-default btn-flat btn-sm">Followers</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#" class="btn btn-default btn-flat btn-sm">Sales</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#" class="btn btn-default btn-flat btn-sm">Friends</a>
                        </div>
                    </div>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ admin_url('auth/users/' . Admin::user()->id . '/edit') }}" class="btn btn-default btn-flat" data-pjax>Profile</a>
                    <a href="{{ admin_url('auth/logout') }}" class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>

        <!-- Control Sidebar Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" aria-label="Toggle control sidebar">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ Admin::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
                    <p>
                        {{ Admin::user()->name }}
                        <small>{{ trans('admin.member_since') }} {{ Admin::user()->created_at->format('M. Y') }}</small>
                    </p>
                </li>

                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a href="#" class="btn btn-default btn-flat">{{ trans('admin.followers') }}</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#" class="btn btn-default btn-flat">{{ trans('admin.sales') }}</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#" class="btn btn-default btn-flat">{{ trans('admin.friends') }}</a>
                        </div>
                    </div>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="float-left">
                        <a href="{{ admin_url('auth/users/' . Admin::user()->id . '/edit') }}" class="btn btn-default btn-flat" data-pjax>
                            {{ trans('admin.profile') }}
                        </a>
                    </div>
                    <div class="float-right">
                        <a href="{{ admin_url('auth/logout') }}" class="btn btn-default btn-flat">
                            {{ trans('admin.logout') }}
                        </a>
                    </div>
                </li>
            </ul>
        </li>

        <!-- Control Sidebar Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
