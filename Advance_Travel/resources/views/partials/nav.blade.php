<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 10px 0;">
    <div class="container-fluid container-xl px-2 px-sm-3">

        <!-- Brand Logo & Name -->
        <a class="navbar-brand d-flex align-items-center me-2 me-sm-3" href="{{ url('/') }}">
            <img src="{{ asset('assets/files/logo.png') }}" alt="Logo" height="38" class="me-2 rounded-circle border border-primary border-2">
            <span class="fw-bold text-white fs-5 tracking-tight">Advance<span class="text-info">Travel</span></span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0 text-white shadow-none p-1.5" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-1" style="font-size: 0.88rem;">

                <li class="nav-item">
                    <a class="nav-link px-2 px-xl-3 text-light fw-medium {{ request()->is('/') ? 'active fw-bold text-info' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 px-xl-3 text-light fw-medium {{ request()->is('package*') ? 'active fw-bold text-info' : '' }}" href="{{ route('package') }}">Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 px-xl-3 text-light fw-medium {{ request()->is('locations*') ? 'active fw-bold text-info' : '' }}" href="{{ route('locations') }}">Locations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 px-xl-3 text-light fw-medium {{ request()->is('info*') ? 'active fw-bold text-info' : '' }}" href="{{ route('info') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 px-xl-3 text-light fw-medium {{ request()->is('contact*') ? 'active fw-bold text-info' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-2 px-xl-3 text-light fw-medium {{ request()->is('booking*') ? 'active fw-bold text-info' : '' }}" href="{{ route('booking') }}">Booking</a>
                </li>

                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item my-1 my-lg-0 ms-lg-1">
                            <a class="btn btn-warning btn-sm px-2.5 py-1 fw-bold rounded-pill shadow-sm text-nowrap" style="font-size: 0.82rem;" href="{{ route('admin.dashboard') }}">
                                👑 Admin Panel
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown my-1 my-lg-0 ms-lg-1">
                        <a class="nav-link dropdown-toggle text-white fw-bold d-inline-flex align-items-center gap-1.5 py-1 px-2.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 text-nowrap" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.82rem;">
                            <div class="rounded-circle bg-info text-dark d-flex align-items-center justify-content-center fw-bold" style="width: 22px; height: 22px; font-size: 0.72rem;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-truncate" style="max-width: 100px;">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2">
                            <li>
                                <div class="dropdown-item-text">
                                    <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                                    <small class="text-muted">{{ auth()->user()->email }}</small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(auth()->user()->is_admin)
                                <li>
                                    <a class="dropdown-item fw-semibold text-primary" href="{{ route('admin.dashboard') }}">
                                        👑 Dashboard
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item fw-semibold text-danger" href="{{ route('logout') }}">
                                    🚪 Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item my-1 my-lg-0 ms-lg-1"><a class="btn btn-outline-light btn-sm px-2.5 py-1 rounded-pill fw-semibold text-nowrap" style="font-size: 0.82rem;" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item my-1 my-lg-0"><a class="btn btn-info text-dark btn-sm px-2.5 py-1 rounded-pill fw-bold text-nowrap" style="font-size: 0.82rem;" href="{{ route('register') }}">Register</a></li>
                @endauth

                <li class="nav-item my-1 my-lg-0 ms-lg-1">
                    <a class="btn btn-success text-white btn-sm px-2.5 py-1 rounded-pill fw-bold shadow-sm text-nowrap" style="font-size: 0.82rem;" href="{{ route('payment') }}">💳 Payment</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
