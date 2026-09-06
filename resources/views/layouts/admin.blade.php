<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal') | Advance Travel & Tourism</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/files/logo.png') }}">

    <!-- Google Fonts & Boxicons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --admin-sidebar-width: 260px;
            --admin-bg: #f8fafc;
            --admin-dark: #0f172a;
            --admin-card-bg: #ffffff;
            --admin-primary: #2563eb;
            --admin-accent: #38bdf8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-bg);
            color: #334155;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 25px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand img {
            height: 38px;
            margin-right: 12px;
        }

        .sidebar-brand span {
            font-weight: 800;
            font-size: 1.15rem;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .sidebar-menu {
            padding: 20px 14px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin: 15px 12px 8px;
        }

        .nav-link-admin {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #94a3b8;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.92rem;
            text-decoration: none;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .nav-link-admin i {
            font-size: 1.25rem;
            margin-right: 12px;
            transition: transform 0.2s;
        }

        .nav-link-admin:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.06);
            transform: translateX(3px);
        }

        .nav-link-admin.active {
            color: #ffffff;
            background: var(--admin-primary);
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        .nav-link-admin.active i {
            color: #ffffff;
        }

        /* Sidebar Footer / User Profile */
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(15, 23, 42, 0.5);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--admin-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* Main Content Wrapper */
        .admin-main {
            margin-left: var(--admin-sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
        .admin-header {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .admin-content {
            padding: 35px;
            flex-grow: 1;
        }

        /* Custom Cards */
        .card-custom {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            padding: 24px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-custom:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        /* Custom Pagination Styles */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 6px;
            align-items: center;
            justify-content: center;
            margin-bottom: 0;
        }
        .page-item .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px !important;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .page-item.active .page-link {
            color: #ffffff !important;
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            border-color: #2563eb !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }
        .page-item:not(.active):not(.disabled) .page-link:hover {
            color: #1e40af;
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            cursor: not-allowed;
            opacity: 0.7;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('assets/files/logo.png') }}" alt="Logo">
            <span>Advance Admin</span>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-label">Main Navigation</div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-link-admin {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class='bx bxs-dashboard'></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('packages.index') }}" class="nav-link-admin {{ request()->routeIs('packages.*') ? 'active' : '' }}">
                <i class='bx bxs-package'></i>
                <span>Tour Packages</span>
            </a>

            <a href="{{ route('bookings.index') }}" class="nav-link-admin {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                <i class='bx bxs-book-content'></i>
                <span>Bookings</span>
            </a>

            <a href="{{ route('contacts.index') }}" class="nav-link-admin {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                <i class='bx bxs-envelope'></i>
                <span>Messages</span>
            </a>

            <div class="sidebar-label">Website</div>
            <a href="{{ route('home') }}" target="_blank" class="nav-link-admin">
                <i class='bx bx-globe'></i>
                <span>Live Website</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-white text-truncate" style="font-size: 0.88rem;">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="text-muted text-truncate" style="font-size: 0.75rem;">Administrator</div>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger border-0 text-white" title="Logout">
                    <i class='bx bx-log-out fs-5'></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Top Navbar -->
        <header class="admin-header">
            <div class="d-flex align-items-center gap-3">
                <h5 class="fw-bold m-0 text-slate-800">@yield('title', 'Admin Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('packages.create') }}" class="btn btn-primary btn-sm px-3 fw-bold rounded-3">
                    <i class='bx bx-plus me-1'></i> Add Package
                </a>

                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle fw-semibold rounded-3 border" type="button" data-bs-toggle="dropdown">
                        👑 {{ auth()->user()->name ?? 'Admin' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank">🌐 Live Site</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">🚪 Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="admin-content">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class='bx bxs-check-circle me-2 fs-5 align-middle'></i>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class='bx bxs-error-circle me-2 fs-5 align-middle'></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
