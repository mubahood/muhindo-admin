<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  @if(!is_null($favicon = Admin::favicon()))
  <link rel="shortcut icon" href="{{$favicon}}">
  @endif

  <!-- Bootstrap 5.3.3 -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/muhindo-admin/bootstrap5/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/muhindo-admin/font-awesome/css/all.min.css") }}">
  <!-- AdminLTE 4.0.0-rc4 -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/muhindo-admin/AdminLTE4/css/adminlte.min.css") }}">[[ Validate Asset]]
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ admin_asset("vendor/muhindo-admin/toastr/build/toastr.min.css") }}">[[ Validate Asset]]

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

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
      
      $primary_rgb = sscanf($primary_color, "#%02x%02x%02x");
      $primary_hover = sprintf("#%02x%02x%02x", 
          max(0, $primary_rgb[0] - 25), 
          max(0, $primary_rgb[1] - 25), 
          max(0, $primary_rgb[2] - 25)
      );
      $primary_active = sprintf("#%02x%02x%02x", 
          max(0, $primary_rgb[0] - 35), 
          max(0, $primary_rgb[1] - 35), 
          max(0, $primary_rgb[2] - 35)
      );
      $focus_rgb = implode(', ', $primary_rgb);
  ?>
  <style>
      /* MUHINDO ADMIN LOGIN PRIMARY COLOR OVERRIDE */
      :root {
          --bs-primary: <?php echo $primary_color; ?> !important;
          --bs-primary-rgb: <?php echo $focus_rgb; ?> !important;
          --primary-color: <?php echo $primary_color; ?> !important;
          --accent-color: <?php echo $primary_color; ?> !important;
      }
      
      /* LOGIN PAGE OVERRIDES */
      .bg-gradient-primary,
      .login-page.bg-gradient-primary {
          background: <?php echo $primary_color; ?> !important;
          background-image: none !important;
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
      .text-primary { color: <?php echo $primary_color; ?> !important; }
      .bg-primary { background-color: <?php echo $primary_color; ?> !important; color: #fff !important; }
      .border-primary { border-color: <?php echo $primary_color; ?> !important; }
      
      /* BADGES AND PROGRESS */
      .badge.bg-primary,
      .badge-primary { background-color: <?php echo $primary_color; ?> !important; }
      .progress-bar { background-color: <?php echo $primary_color; ?> !important; }
      
      /* LOGIN BOX LOGO */
      .login-logo a {
          color: #fff !important;
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
  </style>
</head>
<body class="login-page bg-gradient-primary" @if(config('admin.login_background_image'))style="background: url({{config('admin.login_background_image')}}) no-repeat center center fixed;background-size: cover;"@endif>
<div class="login-box">
  <div class="login-logo">
    <a href="{{ admin_url('/') }}" class="text-white"><b>{{config('admin.name')}}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">{{ trans('admin.login') }}</p>

      <form action="{{ admin_url('auth/login') }}" method="post" class="login-form">
        <div class="input-group mb-3">
          @if($errors->has('username'))
            @foreach($errors->get('username') as $message)
              <div class="invalid-feedback d-block"><i class="fas fa-times-circle"></i> {{$message}}</div>
            @endforeach
          @endif
          
          <input type="text" class="form-control {!! !$errors->has('username') ?: 'is-invalid' !!}" 
                 placeholder="{{ trans('admin.username') }}" name="username" value="{{ old('username') }}" required>
          <div class="input-group-text">
            <span class="fas fa-user"></span>
          </div>
        </div>
        
        <div class="input-group mb-3">
          @if($errors->has('password'))
            @foreach($errors->get('password') as $message)
              <div class="invalid-feedback d-block"><i class="fas fa-times-circle"></i> {{$message}}</div>
            @endforeach
          @endif
          
          <input type="password" class="form-control {!! !$errors->has('password') ?: 'is-invalid' !!}" 
                 placeholder="{{ trans('admin.password') }}" name="password" required>
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            @if(config('admin.auth.remember'))
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" {{ (!old('username') || old('remember')) ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                {{ trans('admin.remember_me') }}
              </label>
            </div>
            @endif
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary btn-block">
              <i class="fas fa-sign-in-alt me-1"></i>
              {{ trans('admin.login') }}
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery 3.7.1 -->
<script src="{{ admin_asset("vendor/muhindo-admin/jquery/jquery-3.7.1.min.js")}}"></script>
<!-- Bootstrap 5.3.3 -->
<script src="{{ admin_asset("vendor/muhindo-admin/bootstrap5/js/bootstrap.bundle.min.js")}}"></script>
<!-- AdminLTE 4.0.0-rc4 -->
<script src="{{ admin_asset("vendor/muhindo-admin/AdminLTE4/js/adminlte.min.js")}}"></script>
<!-- SweetAlert2 v11 -->
<script src="{{ admin_asset("vendor/muhindo-admin/sweetalert2/dist/sweetalert2.min.js")}}"></script>
<!-- Toastr -->
<script src="{{ admin_asset("vendor/muhindo-admin/toastr/build/toastr.min.js")}}"></script>
<script>
  $(function () {
    // Modern form validation and interaction
    $('.form-control').on('focus', function() {
      $(this).addClass('is-valid').removeClass('is-invalid');
    });

    // Enhanced login form submission
    $('.login-form').on('submit', function(e) {
      var form = $(this);
      var submitBtn = form.find('button[type="submit"]');
      
      submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> {{trans('admin.login')}}...');
      
      // Let the form submit normally, but with enhanced UI feedback
    });
  });
</script>
</script>
</body>
</html>
