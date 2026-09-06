<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Advance Travel & Tourism - Multi-modal smart ticketing platform for Bus, Train, and Tour Packages in Bangladesh.">

    <title>@yield('title', 'Advance Travel & Tourism - Intelligent Booking Platform')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/files/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!-- Unified Modern Design System -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Sticky Modern Navbar -->
    @include('partials.nav')

    <!-- Flash Notifications Container -->
    @if(session('success') || session('error') || session('status'))
        <div class="container mt-4 mb-2">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 d-flex align-items-center py-3 px-4" role="alert">
                    <i class='bx bxs-check-circle fs-4 me-3 text-success'></i>
                    <div class="fw-medium text-dark">{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 d-flex align-items-center py-3 px-4" role="alert">
                    <i class='bx bxs-error-circle fs-4 me-3 text-danger'></i>
                    <div class="fw-medium text-dark">{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm border-0 rounded-4 d-flex align-items-center py-3 px-4" role="alert">
                    <i class='bx bxs-info-circle fs-4 me-3 text-info'></i>
                    <div class="fw-medium text-dark">{{ session('status') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Global Footer -->
    @include('partials.footer')

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- City Autocomplete & Search Suggestions -->
    <script src="{{ asset('js/city-autocomplete.js') }}"></script>

    @stack('scripts')
</body>
</html>
