@include('layouts.auth.header')
<body class="hold-transition login-page body-1">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <div class="login-logo">
    <a href="{{url('/')}}"><img src='{{asset("adminlte/imgs/logo.png")}}' width='125'></a>
  </div>
 
      <!-- <p class="login-box-msg">Sign in</p> -->

      @if ($errors->any())

      <p class="text-danger">
     
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
      
            </p>
      @elseif(Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  {!! session('error') !!}
                </div>
            
      @elseif (Session::has('feedback'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  {!! session('feedback') !!}
                </div>
            
    @else
    <br>
    @endif

      <form method="POST" action="{{ route('login') }}">
            @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" :value="old('email')" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <br>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password"  
                                name="password"
                                required autocomplete="current-password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
        <br>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->
      <br>

      <p class="mb-1">
        <a href="{{url('forgot-password')}}">I forgot my password</a>
      </p>
      <!-- <p class="mb-0">
        <a href="{{url('register')}}" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
@include('layouts.auth.footer')