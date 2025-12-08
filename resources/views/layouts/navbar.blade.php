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
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    
                    <!-- Form Logout -->
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    
                    <a class="dropdown-item" href="#" id="logoutBtn" 
                       onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>