@extends('layouts.app')

@section('title', 'Sign In | Advance Travel & Tourism')

@section('content')

<div class="py-5 bg-slate-50 d-flex align-items-center" style="min-height: calc(100vh - 160px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-10">

                <div class="bg-white rounded-4 border p-4 p-md-5 shadow-lg">
                    <!-- Brand Icon & Title -->
                    <div class="text-center mb-4">
                        <div class="brand-icon-box mx-auto mb-3" style="width: 48px; height: 48px; font-size: 1.5rem;">
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <h3 class="fw-bold mb-1">Welcome Back</h3>
                        <p class="text-secondary small mb-0">Sign in to manage your bookings and download tickets</p>
                    </div>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="alert alert-success border-0 rounded-3 small py-2 px-3 mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small py-2 px-3 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Quick Demo Credentials for University Viva -->
                    <div class="p-2.5 rounded-3 bg-light border mb-4 text-center">
                        <div class="small fw-bold text-secondary mb-2">Academic Evaluation Quick-Fill:</div>
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold rounded-pill px-2.5 py-1" onclick="fillDemo('admin@travel.com', 'password123')">
                                👑 Admin Demo
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-2.5 py-1" onclick="fillDemo('user@travel.com', 'password123')">
                                🎫 Traveler Demo
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('login.submit') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="email">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class='bx bx-envelope'></i></span>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="username">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class='bx bx-lock-alt'></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()">
                                    <i class='bx bx-show' id="passwordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-secondary" for="remember">
                                    Remember Me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="small fw-semibold text-primary">Forgot Password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100 py-2.5 rounded-3 mb-3">
                            Sign In to Account
                        </button>
                    </form>

                    <div class="text-center text-secondary small pt-2 border-top">
                        Don’t have an account yet? 
                        <a href="{{ route('register') }}" class="fw-bold text-primary">Create One Free</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('passwordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.className = 'bx bx-hide';
        } else {
            passwordInput.type = 'password';
            icon.className = 'bx bx-show';
        }
    }

    function fillDemo(email, pass) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pass;
    }
</script>
@endpush

@endsection
