<nav class="navbar navbar-expand-lg site-navbar sticky-top py-2.5">
    <div class="container-xl">

        <!-- Brand Logo & Name -->
        <a class="navbar-brand d-inline-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('assets/files/logo.png') }}" alt="AdvanceTravel" class="rounded-2" style="height: 34px; width: auto; object-fit: contain;">
            <span class="fw-bold fs-5 tracking-tight">Advance<span class="text-primary-emphasis" style="color: #38bdf8 !important;">Travel</span></span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0 text-white shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class='bx bx-menu fs-2 text-white'></i>
        </button>

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('explore*') ? 'active' : '' }}" href="{{ route('explore') }}" id="exploreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-compass me-1 align-middle'></i>Explore
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg rounded-3 py-2" aria-labelledby="exploreDropdown">
                        <li><a class="dropdown-item py-2 fw-semibold d-flex align-items-center gap-2" href="{{ route('explore') }}"><i class='bx bx-grid-alt text-primary'></i> Explore All Tickets & Fleets</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('explore', ['type' => 'bus']) }}"><i class='bx bx-bus text-info'></i> Luxury Bus Tickets</a></li>
                        <li><a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('explore', ['type' => 'train']) }}"><i class='bx bx-train text-warning'></i> Express Train Tickets</a></li>
                        <li><a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('explore', ['type' => 'tour']) }}"><i class='bx bx-sun text-success'></i> Holiday Tour Packages</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('locations') }}"><i class='bx bx-map-pin text-danger'></i> Top Destinations</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('package*') ? 'active' : '' }}" href="{{ route('package') }}">
                        <i class='bx bx-map-pin me-1 align-middle'></i>Tour Packages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('locations*') ? 'active' : '' }}" href="{{ route('locations') }}">
                        Destinations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('info*') ? 'active' : '' }}" href="{{ route('info') }}">
                        About Project
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">
                        Contact
                    </a>
                </li>
            </ul>

            <!-- Auth Controls -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                @auth
                    <a class="btn btn-outline-light btn-sm rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1" href="{{ route('my.bookings') }}">
                        <i class='bx bx-receipt text-info'></i>
                        <span>My Trips</span>
                    </a>

                    @if(auth()->user()->is_admin)
                        <a class="btn btn-warning btn-sm rounded-pill px-3 py-1.5 fw-bold shadow-sm d-inline-flex align-items-center gap-1" href="{{ route('admin.dashboard') }}">
                            <i class='bx bxs-shield'></i>
                            <span>Admin</span>
                        </a>
                    @endif

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-dark btn-sm rounded-pill d-flex align-items-center gap-2 p-1 pe-3 border border-secondary border-opacity-50" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar-badge">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-white fw-semibold small text-truncate" style="max-width: 110px;">
                                {{ auth()->user()->name }}
                            </span>
                            <i class='bx bx-chevron-down text-slate-400 small'></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2" style="min-width: 220px;">
                            <li class="px-3 py-2 border-bottom mb-1">
                                <div class="fw-bold text-dark text-truncate">{{ auth()->user()->name }}</div>
                                <div class="text-muted small text-truncate">{{ auth()->user()->email }}</div>
                                <span class="badge {{ auth()->user()->is_admin ? 'bg-warning text-dark' : 'bg-primary-subtle text-primary' }} mt-1 rounded-pill">
                                    {{ auth()->user()->is_admin ? 'Administrator' : 'Traveler Member' }}
                                </span>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 fw-medium d-flex align-items-center gap-2 text-primary" href="{{ route('my.bookings') }}">
                                    <i class='bx bx-confirmation fs-5'></i>
                                    <span>My Booked Tickets</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 fw-medium d-flex align-items-center gap-2 text-dark" href="{{ route('profile') }}">
                                    <i class='bx bx-user-circle fs-5 text-secondary'></i>
                                    <span>Profile & Settings</span>
                                </a>
                            </li>
                            @if(auth()->user()->is_admin)
                                <li>
                                    <a class="dropdown-item rounded-3 py-2 fw-medium d-flex align-items-center gap-2 text-warning" href="{{ route('admin.dashboard') }}">
                                        <i class='bx bx-bar-chart-alt-2 fs-5'></i>
                                        <span>Admin Dashboard</span>
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 fw-medium d-flex align-items-center gap-2 text-danger" href="{{ route('logout') }}">
                                    <i class='bx bx-log-out fs-5'></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-outline-light btn-sm rounded-pill px-3 py-1.5 fw-semibold" href="{{ route('login') }}">
                        Sign In
                    </a>
                    <a class="btn btn-primary-gradient btn-sm rounded-pill px-3 py-1.5" href="{{ route('register') }}">
                        Create Account
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
