<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
</head>

<body>

    <div class="d-flex">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <div class="main-content flex-grow-1">

            {{-- Navbar --}}
            @include('layouts.navbar')

            {{-- Content --}}
            <div class="container-fluid py-4">
                @yield('content')
            </div>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>

    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

</body>
</html>
