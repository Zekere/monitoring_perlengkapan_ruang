<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <a href="{{ url('/dashboard') }}" class="logo">
            <img src="{{ asset('assets/img/img/TextPUPRputih.png') }}" alt="Logo">
        </a>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="sidebar-content">
        <ul class="nav-secondary">
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-section">
                <span class="text-section">MENU</span>
            </li>

            <!-- Menu Barang -->
            <li class="nav-item {{ Request::is('barang') && !Request::is('barang/create') ? 'active' : '' }}">
                <a href="{{ url('/barang') }}">
                    <i class="fas fa-box"></i>
                    <p>Barang</p>
                </a>
            </li>

            <!-- Menu Tambah Barang -->
            <li class="nav-item {{ Request::is('barang/create') ? 'active' : '' }}">
                <a href="{{ route('barang.create') }}">
                    <i class="fas fa-plus-circle"></i>
                    <p>Tambah Barang</p>
                </a>
            </li>

            <!-- Menu Kategori -->
            <li class="nav-item {{ Request::is('kategori*') ? 'active' : '' }}">
                <a href="{{ url('/kategori') }}">
                    <i class="fas fa-tags"></i>
                    <p>Kategori</p>
                </a>
            </li>

            <!-- Menu Ruangan -->
            <li class="nav-item {{ Request::is('ruangan*') ? 'active' : '' }}">
                <a href="{{ url('/ruangan') }}">
                    <i class="fas fa-door-open"></i>
                    <p>Ruangan</p>
                </a>
            </li>

            <!-- Menu Pengaduan -->
            <li class="nav-item {{ Request::is('pengaduan*') ? 'active' : '' }}">
                <a href="{{ url('/pengaduan') }}">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Pengaduan</p>
                    @php
                        $pengaduanMenunggu = \App\Models\PengaduanKerusakan::where('status', 'Menunggu')->count();
                    @endphp
                    @if($pengaduanMenunggu > 0)
                        <span class="badge badge-warning ms-2">{{ $pengaduanMenunggu }}</span>
                    @endif
                </a>
            </li>

            <!-- Menu Riwayat Perawatan -->
            <li class="nav-item {{ Request::is('riwayat-perawatan*') ? 'active' : '' }}">
                <a href="{{ route('riwayat-perawatan.index') }}">
                    <i class="fas fa-tools"></i>
                    <p>Riwayat Perawatan</p>
                </a>
            </li>

            <!-- Menu Riwayat Pengecekan -->
            <li class="nav-item {{ Request::is('riwayat*') && !Request::is('riwayat-perawatan*') ? 'active' : '' }}">
                <a href="{{ route('riwayat.index') }}">
                    <i class="fas fa-history"></i>
                    <p>Riwayat Pengecekan</p>
                </a>
            </li>

            <!-- ============================================ -->
            <!-- MENU KELOLA ADMIN (HANYA UNTUK SUPERADMIN) -->
            <!-- ============================================ -->
            @if(Auth::check() && Auth::user()->isSuperAdmin())
            <li class="nav-section">
                <span class="text-section">PENGATURAN</span>
            </li>

            <li class="nav-item {{ Request::is('admin*') ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}">
                    <i class="fas fa-user-shield"></i>
                    <p>Kelola Admin</p>
                </a>
            </li>
            @endif

            <!-- Menu Logout -->
            <li class="nav-item mt-3">
                <a href="{{ route('logout') }}"
                   class="nav-link text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>