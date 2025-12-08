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

            <li class="nav-item {{ Request::is('barang*', 'kategori*', 'lokasi*') ? 'active' : '' }}">
                <a href="#masterMenu" data-bs-toggle="collapse" aria-expanded="{{ Request::is('barang*', 'kategori*', 'lokasi*') ? 'true' : 'false' }}">
                    <i class="fas fa-database"></i>
                    <p>Data Master</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse nav-collapse {{ Request::is('barang*', 'kategori*', 'lokasi*') ? 'show' : '' }}" id="masterMenu">
                    <ul>
                        <li><a href="{{ url('/barang') }}" class="{{ Request::is('barang*') ? 'active' : '' }}"><span class="sub-item">Barang</span></a></li>
                        <li><a href="{{ url('/kategori') }}" class="{{ Request::is('kategori*') ? 'active' : '' }}"><span class="sub-item">Kategori</span></a></li>
                        <li><a href="{{ url('/lokasi') }}" class="{{ Request::is('lokasi*') ? 'active' : '' }}"><span class="sub-item">Lokasi</span></a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>