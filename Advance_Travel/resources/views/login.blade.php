@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/log.css') }}">
@endpush

@section('content')

<section class="login-page">
    <div class="login-container">
        <h2>Login</h2>

        {{-- Display Session Status --}}
        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" novalidate>
            @csrf

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
                <input type="checkbox" id="show-password"> <span>Show Password</span>
            </div>

            <div class="options">
                <label><input type="checkbox" name="remember"> Remember Me</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="register">
            @if (Route::has('register'))
                Don’t have an account? <a href="{{ route('register') }}">Register</a>
            @endif
        </div>
    </div>
</section>

{{-- Show Password Toggle Script --}}
@push('scripts')
<script>
    document.getElementById('show-password').addEventListener('change', function() {
        const passwordField = document.getElementById('password');
        passwordField.type = this.checked ? 'text' : 'password';
    });
</script>
@endpush

@endsection
