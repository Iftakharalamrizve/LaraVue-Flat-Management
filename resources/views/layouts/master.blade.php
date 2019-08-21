<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Starter</title>
  <!-- Styles -->
  <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div  id="app">
  <div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
      <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
      <div class="sidebar-content">
        <div class="sidebar-brand">
          <a href="#">pro sidebar</a>
          <div id="close-sidebar">
            <i class="fas fa-times"></i>
          </div>
        </div>
        <div class="sidebar-header">
          <div class="user-pic">
            <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
              alt="User picture">
          </div>
          <div class="user-info">
            <span class="user-name">
              <strong>{{Auth::user()->name}}</strong>
            </span>
            <span class="user-role">Administrator</span>
            <span class="user-status">
              <i class="fa fa-circle"></i>
              <span>Online</span>
            </span>
          </div>
        </div>
        <!-- sidebar-header  -->
        <div class="sidebar-search">
          <div>
            <div class="input-group">
              <input type="text" class="form-control search-menu" placeholder="Search...">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
          <ul class="" style="text-align: left;">
            <li class="header-menu">
              <span>General</span>
            </li>
            <li class="sidebar-dropdown">
              <router-link to="/dashboard" >
                <i class="fa fa-tachometer-alt"></i>
                <span>Dashboard</span>
              </router-link>
            </li>
            {{-- <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>E-commerce</span>
                <span class="badge badge-pill badge-danger">3</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">Products
  
                    </a>
                  </li>
                  <li>
                    <a href="#">Orders</a>
                  </li>
                  <li>
                    <a href="#">Credit cart</a>
                  </li>
                </ul>
              </div>
            </li> --}}
            {{-- <li class="sidebar-dropdown">
              <a href="#">
                <i class="far fa-gem"></i>
                <span>Components</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">General</a>
                  </li>
                  <li>
                    <a href="#">Panels</a>
                  </li>
                  <li>
                    <a href="#">Tables</a>
                  </li>
                  <li>
                    <a href="#">Icons</a>
                  </li>
                  <li>
                    <a href="#">Forms</a>
                  </li>
                </ul>
              </div>
            </li> --}}
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-cog"></i>
                <span>Management</span>
              </a>
              <div class="sidebar-submenu">
                @can('isAdmin')
                <ul>
                  <router-link to="/users">
                    <i class="fa fa-users nav-icon purple"></i>
                    <span>Users</span>
                  </router-link>
                  <router-link to="/developer">
                      <i class="nav-icon fa fa-cogs"></i>
                      <span>
                          Developer
                      </span>
                  </router-link>
                  <li>
                    <a href="#">Bar chart</a>
                  </li>
                  <li>
                    <a href="#">Histogram</a>
                  </li>
                </ul>
                @endcan
              </div>
            </li>
            {{-- <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-globe"></i>
                <span>Maps</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">Google maps</a>
                  </li>
                  <li>
                    <a href="#">Open street map</a>
                  </li>
                </ul>
              </div>
            </li> --}}
            {{-- <li class="header-menu">
              <span>Extra</span>
            </li> --}}
            {{-- <li>
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Documentation</span>
                <span class="badge badge-pill badge-primary">Beta</span>
              </a>
            </li> --}}
            <li>
              <router-link to="/bill-history" class="nav-link">
                <i class="far fa-money-bill-alt"></i>
                    Bill History
                  </span>
              </router-link>
            </li>
            <li>
              <router-link to="/mill-account" class="nav-link">
                <i class="fab fa-stack-exchange"></i>
                  <span>
                    Mill Accounts
                  </span>
              </router-link>
            </li>
            <li>
                <router-link to="/user-accounts" class="nav-link">
                  <i class="nav-icon fa fa-history"></i>
                  <span>
                      Current Hisory Monthly
                  </span>
              </router-link>
            </li>
            <li>
              <router-link to="/report" class="nav-link">
                  <i class="nav-icon fa fa-line-chart" aria-hidden="true"></i>
                  <span>
                      Report
                  </span>
              </router-link>
            </li>
            <li>
              <router-link to="/profile" class="nav-link">
                  <i class="nav-icon fa fa-user"></i>
                  <span>
                      Profile
                  </span>
              </router-link>
            </li>
            
            <li>
              <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                  <i class="nav-icon fa fa-power-off" yellow></i>
                  <span>
                    Logout
                  </span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
          </ul>
        </div>
        <!-- sidebar-menu  -->
      </div>
      <!-- sidebar-content  -->
      <div class="sidebar-footer">
        <a href="#">
          <i class="fa fa-bell"></i>
          <span class="badge badge-pill badge-warning notification">3</span>
        </a>
        <a href="#">
          <i class="fa fa-envelope"></i>
          <span class="badge badge-pill badge-success notification">7</span>
        </a>
        <a href="#">
          <i class="fa fa-cog"></i>
          <span class="badge-sonar"></span>
        </a>
        <a href="#">
          <i class="fa fa-power-off"></i>
        </a>
      </div>
    </nav>
    <!-- sidebar-wrapper  -->
    <main class="page-content">
      <div class="container-fluid">
          <router-view></router-view>
          {{-- <vue-progress-bar></vue-progress-bar> --}}
      </div><!-- /.container-fluid -->
     </main>
    <!-- page-content" -->
  </div>
 
  <!-- /.control-sidebar -->

</div>
@auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth
<!-- Scripts -->
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <script src="/js/sidebar.js"></script>
  <script src="/js/app.js"></script>
<!-- jQuery -->
</body>
</html>
