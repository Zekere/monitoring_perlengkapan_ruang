<!-- Navbar -->
<div class="main-header">
    <div class="navbar-container">
        <div class="navbar-left">
            <button class="mobile-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <form class="search-form d-none d-md-block">
                <div class="input-group">
                    <button type="submit" class="btn-search">
                        <i class="fa fa-search"></i>
                    </button>
                    <input type="text" placeholder="Search..." class="form-control">
                </div>
            </form>
        </div>

        <div class="navbar-right">
            <div class="topbar-user dropdown">
                <a href="#" class="profile-pic" id="profileDropdown">
                    <div class="avatar-sm">
                        <img src="{{ asset('assets/img/img/iconadmin.png') }}" alt="Profile">
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Hi,</span>
                        <span class="fw-bold">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
                        @if(Auth::check() && Auth::user()->isSuperAdmin())
                            <span class="badge bg-danger ms-2" style="font-size: 10px;">Super Admin</span>
                        @endif
                    </span>
                </a>
                
                <div class="dropdown-menu-user" id="userDropdown">
                    <div class="user-box">
                        <div class="avatar-lg">
                            <img src="{{ asset('assets/img/img/iconadmin.png') }}" alt="Profile">
                        </div>
                        <div class="u-text">
                            <h4>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</h4>
                            <p>{{ Auth::check() ? Auth::user()->email : '' }}</p>
                            @if(Auth::check())
                                <span class="badge {{ Auth::user()->isSuperAdmin() ? 'bg-danger' : 'bg-secondary' }} mt-1">
                                    {{ Auth::user()->isSuperAdmin() ? 'Super Admin' : 'Admin' }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    
                    <!-- Menu Kelola Admin (Hanya SuperAdmin) -->
                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                    <a href="{{ route('admin.index') }}" class="dropdown-item">
                        <i class="fas fa-user-shield me-2"></i> Kelola Admin
                    </a>
                    <div class="dropdown-divider"></div>
                    @endif

                    <!-- Form Logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    <a href="#" class="dropdown-item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>