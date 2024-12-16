<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <!-- Menampilkan foto profil -->
            <img id="sidebar-profile-img" src="{{ asset(Auth::user()->foto ?? 'adminlte/dist/img/default-profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        {{-- <div class="info">
            <a href="{{ url('/profile') }}" class="d-block">{{ Auth::user()->nama }}</a>
        </div> --}}
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')?'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">Manage Kompen</li>
            <li class="nav-item">
                <a href="{{ url('/tugas') }}" class="nav-link {{ $activeMenu == 'tugas' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>Manage Tugas</p>
                </a>
            </li>
            <li class="nav-header">Lihat dan Pilih Kompen</li>
            <li class="nav-item">
                <a href="{{ url('/pilihkompen') }}" class="nav-link {{ $activeMenu == 'pilihkompen' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>Lihat dan Pilih Kompen</p>
                </a>
            </li>
                <!-- /.sidebar-menu -->
            </div>