<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ isset($title) ? $title : 'Dashboard' }}</title> <!-- Menampilkan judul dinamis -->
 <link rel="icon" href="/images/Fix2.png" type="image/png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('template/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Summernote -->
  <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.min.css') }}">

  <style>
    body {
        background-color: #f4f6f9;
    }
    .navbar {
        padding: 0.25rem 1rem;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 56px;
        z-index: 1040;
        background-color: white;
    }
    .navbar-brand img {
        height: 80px;
        width: auto;
        display: block;
    }
    .navbar .nav-item img {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .navbar .nav-item p {
        margin: 0;
        color: black;
    }
    .navbar .nav-link {
        color: black;
    }
    .navbar .nav-link:hover,
    .navbar .nav-link.active {
        color: #007bff;
    }
    .navbar .dropdown-menu {
        background-color: white;
        z-index: 1050;
        position: absolute;
        left: 0;
        right: 0;
    }
    .navbar .dropdown-toggle::after {
        margin-left: 0.5rem;
    }

    /* Sidebar styling */
    .main-sidebar {
        background-color: #00a2ea !important;
        margin-top: 56px;
        width: 200px; /* Lebar sidebar diatur di sini */
    }
    .main-sidebar .nav-link i {
        color: white !important;
    }
    .main-sidebar .nav-link p {
        color: white;
    }
    .main-sidebar .nav-link.active,
    .main-sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }

    /* Konten utama diatur agar tidak terlalu ke kanan */
    .content-wrapper {
        margin-left: 200px;
        padding-top: 56px;
    }

    @media (max-width: 768px) {
      .navbar {
          padding: 0rem 0.25rem;
          height: 60px;
          position: fixed;
      }
      .navbar-brand img {
          height: 60px;
      }
      .navbar .nav-item img {
          height: 30px;
          width: 30px;
      }
      .navbar .nav-item p {
          line-height: 60px;
          margin: 0;
      }
      .navbar .nav-link {
          margin-right: 15px;
      }
      .content-wrapper {
          margin-left: 0;
      }
      .main-sidebar {
          margin-top: 60px;
      }
      .navbar .dropdown-menu {
          position: absolute;
          right: 0;
          left: auto;
          width: 100%;
      }
      .navbar .nav-item.dropdown .nav-link {
          display: flex;
          justify-content: center;
          align-items: center;
          width: 100%;
      }

    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000c7b">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/Fix2.png') }}" alt="Logo" style="height: 40px; width: auto;">
      <span class="ml-2" style="color: white; font-size: 18px; font-weight: bold;">Manajemen Informatika</span>
      <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color:white">
        <i class="fas fa-bars"></i>
      </a>
    </a>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown d-flex align-items-center">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
              <img src="{{ asset('images/Test Account.png') }}" alt="User Photo" class="rounded-circle" style="height: 30px; width: 30px;">
              {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <form id="logout-form" action="" method="POST" style="display: none;">
                @csrf
              </form>
              <a class="dropdown-item" href="login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt" style="color: #000c7b;"></i> Logout
              </a>
            </div>
          </li>
    </ul>
  </nav>

  <div class="wrapper">
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="masterpengguna" class="nav-link d-flex align-items-center">
                <i class="fas fa-home"></i>
                <p class="ml-2 mb-0">DashBoard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="kelas" class="nav-link">
                <i class="fas fa-chalkboard-teacher"></i>
                <p>Data Ruang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="alat" class="nav-link">
                <i class="fas fa-box"></i>
                <p>Data Barang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="peminjaman" class="nav-link">
                <i class="fas fa-hand-holding-heart"></i>
                <p>Data Peminjaman</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      @yield('content')
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
