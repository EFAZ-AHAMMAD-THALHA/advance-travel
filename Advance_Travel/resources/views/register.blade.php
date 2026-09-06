@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/reg.css') }}">
@endpush

@section('content')
<section class="login-page" role="main" aria-labelledby="register-heading">
  <div class="login-container">
    <h2 id="register-heading">REGISTER</h2>

    {{-- Global Status --}}
    @if (session('status'))
      <div class="alert alert-success" role="status">
        {{ session('status') }}
      </div>
    @endif

    {{-- Error Summary --}}
    @if ($errors->any())
      <div class="alert alert-danger" role="alert" aria-live="polite">
        <strong>There {{ $errors->count() > 1 ? 'were some' : 'was an' }} problem{{ $errors->count() > 1 ? 's' : '' }} with your input:</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST" novalidate>
      @csrf

      {{-- Name --}}
      <div class="input-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
        @error('name')
          <small id="name-error" class="input-error">{{ $message }}</small>
        @enderror
      </div>

      {{-- Email --}}
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
        @error('email')
          <small id="email-error" class="input-error">{{ $message }}</small>
        @enderror
      </div>

      {{-- Phone --}}
      <div class="input-group">
        <label for="phone">Phone (optional)</label>
        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel" @error('phone') aria-invalid="true" aria-describedby="phone-error" @enderror>
        @error('phone')
          <small id="phone-error" class="input-error">{{ $message }}</small>
        @enderror
      </div>

      {{-- Password --}}
      <div class="input-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input type="password" id="password" name="password" required autocomplete="new-password" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
          <button type="button" class="toggle-password" aria-label="Show password" data-target="#password">👁</button>
        </div>
        @error('password')
          <small id="password-error" class="input-error">{{ $message }}</small>
        @enderror
      </div>

      {{-- Confirm Password --}}
      <div class="input-group">
        <label for="password_confirmation">Confirm Password</label>
        <div class="password-wrapper">
          <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
          <button type="button" class="toggle-password" aria-label="Show password" data-target="#password_confirmation">👁</button>
        </div>
      </div>

      {{-- Terms --}}
      <div class="options">
        <label class="remember-me">
          <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
          I agree to the Terms & Privacy Policy
        </label>
        @error('terms')
          <small class="input-error" style="display:block">{{ $message }}</small>
        @enderror
      </div>

      {{-- Submit --}}
      <button type="submit" class="login-btn" aria-label="Create your account">Create Account</button>
    </form>

    {{-- Switch to Login --}}
    <div class="register">
      Already have an account?
      @if (Route::has('login'))
        <a href="{{ route('login') }}">Login</a>
      @else
        <a href="#">Login</a>
      @endif
    </div>
  </div>
</section>

@push('scripts')
<script>
  // Password visibility toggle
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.toggle-password');
    if (!btn) return;
    const target = document.querySelector(btn.getAttribute('data-target'));
    if (!target) return;
    const isHidden = target.type === 'password';
    target.type = isHidden ? 'text' : 'password';
    btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
  });
</script>
@endpush

@endsection
