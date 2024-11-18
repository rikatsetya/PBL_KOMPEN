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
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link  {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ $activeMenu == 'pengguna' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $activeMenu == 'pengguna' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                        Pengguna
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/level') }}" class="nav-link {{ $activeSubMenu == 'level' ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Level Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/user') }}" class="nav-link {{ $activeSubMenu == 'user' ? 'active' : '' }}">
                            <i class="nav-icon far fa-user"></i>
                            <p>Data Pengguna</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ $activeMenu == 'detail' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $activeMenu == 'detail' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                        Manage Kompen
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/kompetensi') }}" class="nav-link {{ $activeSubMenu == 'kompetensi' ? 'active' : '' }} ">
                            <i class="nav-icon far fa-list-alt"></i>
                            <p>Bidang Kompetensi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/jenis') }}" class="nav-link {{ $activeSubMenu == 'jenis' ? 'active' : '' }} ">
                            <i class="nav-icon far fa-list-alt"></i>
                            <p>Jenis Tugas</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/mahasiswa') }}" class="nav-link {{ $activeMenu == 'mahasiswa' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-file"></i>
                    <p>Manage Mahasiswa</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/daftar_tugas') }}" class="nav-link {{ $activeMenu == 'daftar_tugas' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Daftar Tugas</p>
                </a>
            </li>
            <li class="nav-header">Informasi Kompen</li>
            <li class="nav-item">
                <a href="{{ url('/daftar_alpha') }}" class="nav-link {{ $activeMenu == 'daftar_alpha' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Daftar Mahasiswa Alpha</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/tugas') }}" class="nav-link {{ $activeMenu == 'tugas' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Manage Tugas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
                </form>
            </li>
        </ul>
    </nav>
</div>
