<div class="main-header">
  <div class="logo-header" data-background-color="dark">
    <a href="{{ url('/') }}" class="logo">
      <img src="{{ asset('assets/img/img/LogoPuprText.png') }}" alt="logo" height="40">
    </a>

    <div class="nav-toggle">
      <button class="btn btn-toggle toggle-sidebar" id="btnToggleSidebar">
        <i class="fa fa-bars"></i>
      </button>
    </div>

    <button class="topbar-toggler more" id="topbarToggler">
      <i class="fa fa-ellipsis-v"></i>
    </button>
  </div>

  <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item topbar-user dropdown">
            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
              <div class="avatar-sm">
                <img src="{{ asset('assets/img/img/iconadmin.png') }}" class="avatar-img rounded-circle" alt="...">
              </div>
              <span class="profile-username">
                <span class="op-7">Hi,</span>
                <span class="fw-bold">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-user">
              <li>
                <div class="user-box">
                  <div class="avatar-lg">
                    <img src="{{ asset('assets/img/img/iconadmin.png') }}" class="avatar-img rounded" alt="profile">
                  </div>
                  <div class="u-text">
                    <h4>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</h4>
                    <p class="text-muted">{{ Auth::check() ? Auth::user()->email : '' }}</p>
                  </div>
                </div>
              </li>
              <li><div class="dropdown-divider"></div></li>
              <li><a class="dropdown-item" href="#" id="logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>


{{-- LOGOUT CONFIRM --}}
<script>
document.getElementById("logout").addEventListener("click", function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Yakin mau logout?',
        text: "Kamu akan keluar dari akun ini.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/logoutadmin";
        }
    });
});
</script>
