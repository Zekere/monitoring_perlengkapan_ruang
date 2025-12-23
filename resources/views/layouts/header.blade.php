<li class="nav-item topbar-user dropdown hidden-caret">
    <a class="dropdown-toggle profile-pic"
       data-bs-toggle="dropdown"
       href="#"
       aria-expanded="false">

        <div class="avatar-sm">
            <img src="{{ asset('assets/img/img/iconadmin.png') }}" alt="Profile"
                 class="avatar-img rounded-circle">
        </div>

        <span class="profile-username">
            <span class="op-7">Hi,</span>
            <span class="fw-bold">{{ Auth::user()->name }}</span>
        </span>
    </a>

    <ul class="dropdown-menu dropdown-user animated fadeIn">
        <li>
            <div class="user-box">
                <div class="avatar-lg">
                    <img src="{{ asset('assets/img/img/iconadmin.png') }}"
                         class="avatar-img rounded">
                </div>
                <div class="u-text">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </li>

        <li>
            <div class="dropdown-divider"></div>

            <!-- FORM LOGOUT -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</li>
