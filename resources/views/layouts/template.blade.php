<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title', 'Admin')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>    <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* =========================================
           ULTIMATE FIX UNTUK OVERFLOW-X
           Ditambahkan di atas CSS asli kamu
        ========================================= */
        
        /* 1. ROOT LEVEL FIX - Paling Penting! */
        html {
            overflow-x: hidden !important;
            width: 100vw;
            position: relative;
        }
        
        body {
            overflow-x: hidden !important;
            width: 100%;
            max-width: 100vw;
            position: relative;
        }

        /* 2. Bootstrap Row Fix - PENYEBAB UTAMA! */
        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            max-width: 100%;
        }
        
        .row > * {
            padding-left: calc(var(--bs-gutter-x) * 0.5);
            padding-right: calc(var(--bs-gutter-x) * 0.5);
        }

        /* 3. Container Fix */
        .container-fluid, 
        .container {
            max-width: 100% !important;
            overflow-x: hidden !important;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* 4. Media Elements Responsive */
        img, svg, video, canvas, iframe {
            max-width: 100%;
            height: auto;
        }

        /* 5. Flexbox Fix */
        * {
            min-width: 0;
        }

        /* 6. Main Content Width Fix */
        .main-content {
            overflow-x: hidden !important;
            width: calc(100% - 250px);
            max-width: calc(100vw - 250px);
        }

        /* 7. Header Fix */
        .main-header {
            overflow: hidden !important;
            max-width: 100%;
        }

        /* 8. Sidebar Fix */
        .sidebar {
            overflow-x: hidden !important;
        }

        /* 9. Dropdown Menu Fix */
        .dropdown-menu-user {
            max-width: 90vw;
            overflow-x: hidden;
        }

        /* 10. Navbar Container Fix */
        .navbar-container {
            max-width: 100%;
            overflow: hidden;
        }

        /* ===============================
           CSS ASLI KAMU (TIDAK DIHAPUS)
        =============================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f5f9;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: #1a2035;
            color: #fff;
            z-index: 1030;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .sidebar-logo {
            height: 70px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo .logo img {
            height: 40px;
            width: auto;
        }

        .sidebar-toggle {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
            display: none;
        }

        .sidebar-toggle:hover {
            color: #fff;
        }

        .sidebar-content {
            padding: 20px 0;
        }

        .nav-secondary {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-section {
            padding: 20px 20px 10px;
            margin-top: 15px;
        }

        .nav-section .text-section {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            margin: 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-item > a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-item > a:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }

        .nav-item.active > a {
            background: linear-gradient(90deg, rgba(31,150,255,0.2) 0%, rgba(31,150,255,0) 100%);
            color: #fff;
            font-weight: 500;
            border-left: 3px solid #1f96ff;
        }

        .nav-item > a i {
            font-size: 18px;
            width: 35px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item > a p {
            margin: 0;
            margin-left: 10px;
            flex: 1;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-item > a .caret {
            margin-left: auto;
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid rgba(255,255,255,0.7);
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }

        .nav-item > a[aria-expanded="true"] .caret {
            transform: rotate(180deg);
        }

        .nav-collapse {
            list-style: none;
            padding: 0;
            margin: 0;
            background: rgba(0,0,0,0.15);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .nav-collapse.show {
            max-height: 500px;
        }

        .nav-collapse li a {
            display: block;
            padding: 10px 20px 10px 65px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-collapse li a:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
            padding-left: 70px;
        }

        /* ========== NAVBAR ========== */
        .main-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 250px;
            height: 70px;
            background: #fff;
            z-index: 1020;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .navbar-container {
            height: 100%;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .mobile-toggle {
            background: transparent;
            border: none;
            font-size: 24px;
            color: #495057;
            cursor: pointer;
            margin-right: 20px;
            display: none;
            flex-shrink: 0;
        }

        .search-form {
            position: relative;
            flex-shrink: 1;
            min-width: 0;
        }

        .search-form .input-group {
            background: #f1f3f5;
            border-radius: 25px;
            padding: 8px 20px;
            width: 100%;
            max-width: 350px;
        }

        .search-form .btn-search {
            background: transparent;
            border: none;
            color: #999;
            padding: 0;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .search-form .form-control {
            background: transparent;
            border: none;
            padding: 0;
            font-size: 14px;
            min-width: 0;
            flex: 1;
        }

        .search-form .form-control:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-shrink: 0;
        }

        .topbar-user {
            position: relative;
        }

        .profile-pic {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            border-radius: 25px;
            background: #f8f9fa;
            cursor: pointer;
            text-decoration: none;
            color: #495057;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .profile-pic:hover {
            background: #e9ecef;
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-username {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            min-width: 0;
        }

        .profile-username .op-7 {
            font-size: 11px;
            color: #999;
        }

        .profile-username .fw-bold {
            font-size: 14px;
            font-weight: 600;
            color: #1a2035;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dropdown-menu-user {
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 280px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            margin-top: 10px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu-user.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-box {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .avatar-lg {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .u-text {
            min-width: 0;
            flex: 1;
        }

        .u-text h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #1a2035;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .u-text p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #999;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dropdown-menu-user .dropdown-item {
            padding: 12px 20px;
            color: #495057;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dropdown-menu-user .dropdown-item:hover {
            background: #f8f9fa;
            color: #1a2035;
        }

        .dropdown-divider {
            height: 1px;
            background: #eee;
            margin: 0;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 250px;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            background: #f4f5f9;
        }

        .container-fluid {
            padding: 30px;
            flex: 1;
        }

        /* ========== FOOTER ========== */
        .footer {
            background: #fff;
            padding: 20px 30px;
            border-top: 1px solid #eee;
            margin-top: auto;
        }

        .footer .copyright {
            font-size: 13px;
            color: #999;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .main-header {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                max-width: 100vw;
            }

            .mobile-toggle {
                display: block;
            }

            .search-form .input-group {
                width: 200px;
            }

            .profile-username {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .search-form {
                display: none;
            }

            .container-fluid {
                padding: 20px 15px;
            }
            
            .navbar-container {
                padding: 0 15px;
            }
        }

        /* Overlay untuk mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1025;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Include Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Include Navbar -->
        @include('layouts.navbar')

        <!-- Content -->
        <div class="container-fluid">
            @yield('content')
        </div>

        <!-- Include Footer -->
        @include('layouts.footer')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle Sidebar for Mobile
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }

        // Profile Dropdown
        const profileDropdown = document.getElementById('profileDropdown');
        const userDropdown = document.getElementById('userDropdown');

        if (profileDropdown) {
            profileDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                userDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });
        }

        // Logout Confirmation with SweetAlert
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Yakin mau logout?',
                    text: "Kamu akan keluar dari akun ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logoutForm').submit();
                    }
                });
            });
        }

        // Active menu highlight
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-secondary .nav-item > a');
        
        navLinks.forEach(link => {
            const parent = link.parentElement;
            if (link.getAttribute('href') === currentPath) {
                parent.classList.add('active');
            } else {
                parent.classList.remove('active');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>