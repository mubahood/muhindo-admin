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
