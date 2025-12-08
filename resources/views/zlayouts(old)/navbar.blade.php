<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <div class="ms-auto d-flex align-items-center">

        <span class="me-3 fw-semibold">
            {{ Auth::guard('admin')->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>

    </div>
</nav>
