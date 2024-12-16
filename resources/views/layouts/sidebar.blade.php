<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link  {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if (session('level_id') == 1)
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
                            <a href="{{ url('/level') }}"
                                class="nav-link {{ $activeSubMenu == 'level' ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>Level Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/user') }}"
                                class="nav-link {{ $activeSubMenu == 'user' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
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
                            <a href="{{ url('/kompetensi') }}"
                                class="nav-link {{ $activeSubMenu == 'kompetensi' ? 'active' : '' }} ">
                                <i class="nav-icon far fa-list-alt"></i>
                                <p>Bidang Kompetensi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/jenis') }}"
                                class="nav-link {{ $activeSubMenu == 'jenis' ? 'active' : '' }} ">
                                <i class="nav-icon far fa-list-alt"></i>
                                <p>Jenis Tugas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/periode') }}"
                                class="nav-link {{ $activeSubMenu == 'periode' ? 'active' : '' }} ">
                                <i class="nav-icon far fa-list-alt"></i>
                                <p>Periode Kompen</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/mahasiswa') }}"
                        class="nav-link {{ $activeMenu == 'mahasiswa' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Manage Mahasiswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/daftar_tugas') }}"
                        class="nav-link {{ $activeMenu == 'daftar_tugas' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Daftar Tugas</p>
                    </a>
                </li>
                <li class="nav-header">Informasi Kompen</li>
                @endif
            @if (session('level_id') == 1 || session('level_id') == 2 || session('level_id') == 3)
                <li class="nav-item">
                    <a href="{{ url('/daftar_alpha') }}"
                        class="nav-link {{ $activeMenu == 'daftar_alpha' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Mahasiswa Alpha</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/daftar_kompen') }}"
                        class="nav-link {{ $activeMenu == 'kompen' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-exclamation"></i>
                        <p>Mahasiswa Kompen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/manage_tugas') }}"
                        class="nav-link {{ $activeMenu == 'tugas' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Manage Tugas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/kompen_selesai') }}"
                        class="nav-link {{ $activeMenu == 'selesai' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Kompen Selesai</p>
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
            @else
                <li class="nav-header" style="text-align: center">- Kompen -</li>
                <li class="nav-item">
                    <a href="{{ url('/kompen_progres') }}"
                        class="nav-link {{ $activeMenu == 'progres' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Progres Kompen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/pilihkompen') }}" class="nav-link {{ $activeMenu == 'pilihkompen' ? 'active' : '' }} ">
                        <i class="nav-icon far fa-address-card"></i>
                        <p>Lihat dan Pilih Kompen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/kompen_selesaim') }}"
                        class="nav-link {{ $activeMenu == 'selesai' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Kompen Selesai</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/hasil') }}" class="nav-link {{ $activeMenu == 'hasil' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-print"></i>
                        <p>Cetak Hasil Kompen</p>
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
            @endif
        </ul>
    </nav>
</div>
