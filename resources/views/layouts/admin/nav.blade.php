<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="/"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/" class="nav-link">Home</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- Add messages here -->
      </div>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- Add notifications here -->
      </div>
    </li>

    <!-- User Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <!-- Check if the user is authenticated -->
        @if(Auth::check())
          <!-- Display user photo if authenticated -->
          <img src="{{ asset('assets/images/users/' . Auth::user()->photo) ?? asset('adminlte/dist/img/user2-160x160.jpg') }}" width="25" class="img-circle elevation-2" alt="User Image">
          {{ \Illuminate\Support\Str::limit(Auth::user()->name, 8, '...') }}
        @else
          <!-- Display a default image when the user is not authenticated -->
          <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" width="25" class="img-circle elevation-2" alt="Guest User">
        @endif
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        @if(Auth::check())
          <!-- Show user details if authenticated -->
          <a class="dropdown-item" href="my-profile">
            <img src="{{ asset('assets/images/users/' . Auth::user()->photo) }}" width="100" height="100" alt="User Image">
          </a>
          <h4 class="dropdown-item" style="text-transform: capitalize;">{{ Auth::user()->name }}</h4>
          <h5 class="dropdown-item">
            @foreach(Auth::user()->getRoleNames() as $role)
              <label class="badge badge-success">{{ $role }}</label>
            @endforeach
          </h5>
        @else
          <!-- Default text for unauthenticated users -->
          <h4 class="dropdown-item">Guest</h4>
        @endif
        <div class="divider"></div>
        <div class="dropdown-item">
          @if(Auth::check())
            <a href="{{ url('my-profile') }}" style="margin: 3px;" data-toggle="tooltip" title="My Profile"><i class="fa fa-user"></i> Profile</a>
            <a href="{{ url('change-password') }}" style="margin: 3px;" data-toggle="tooltip" title="Change Password"><i class="fa fa-key"></i> Password</a>
            <a href="{{ route('logout') }}" style="margin: 3px;" onclick="event.preventDefault(); document.getElementById('logout').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
          @else
            <!-- Option for unauthenticated users to log in -->
            <a href="{{ route('login') }}" style="margin: 3px;"><i class="fas fa-sign-in-alt"></i> Login</a>
          @endif
        </div>
      </div>
    </li>

  </ul>
</nav>

<!-- Loading Section -->
<section id="loading">
  <div id="loading-content"></div>
</section>

<!-- Logout Form -->
<form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
