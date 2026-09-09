@extends('layouts.app')

@section('title', 'Create Account | Advance Travel & Tourism')

@section('content')

<div class="py-5 bg-slate-50 d-flex align-items-center" style="min-height: calc(100vh - 160px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">

                <div class="bg-white rounded-4 border p-4 p-md-5 shadow-lg">
                    <!-- Brand Icon & Title -->
                    <div class="text-center mb-4">
                        <div class="brand-icon-box mx-auto mb-3" style="width: 48px; height: 48px; font-size: 1.5rem;">
                            <i class='bx bx-user-plus'></i>
                        </div>
                        <h3 class="fw-bold mb-1">Create Traveler Account</h3>
                        <p class="text-secondary small mb-0">Join Advance Travel to book tickets and manage itineraries</p>
                    </div>

                    {{-- Global Status --}}
                    @if (session('status'))
                        <div class="alert alert-success border-0 rounded-3 small py-2 px-3 mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Error Summary --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small py-2 px-3 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.submit') }}" method="POST" novalidate>
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary"><i class='bx bx-user'></i></span>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Tanvir Ahmed" required autofocus>
                            </div>
                        </div>

                        <!-- Email & Phone Grid -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class='bx bx-envelope'></i></span>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone (Bangladeshi)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class='bx bx-phone'></i></span>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="01712345678">
                                </div>
                            </div>
                        </div>

                        <!-- Password & Confirm Password Grid -->
                        <div class="row g-3 mb-2">
                            <div class="col-md-6">
                                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class='bx bx-lock-alt'></i></span>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Min 8 characters" data-password-strength data-confirm-input="password_confirmation" required>
                                    <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="password" title="Toggle password visibility">
                                        <i class='bx bx-hide'></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-secondary"><i class='bx bx-lock-check'></i></span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                                    <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="password_confirmation" title="Toggle password visibility">
                                        <i class='bx bx-hide'></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Live Password Strength Meter & Requirements -->
                        <div class="p-3.5 bg-slate-100 rounded-3 mb-3.5 border shadow-sm">
                            <div class="d-flex align-items-center mb-1.5">
                                <span class="small text-secondary fw-semibold">Security Score:</span>
                                <span class="password-strength-text small ms-auto fw-bold text-secondary">Password Required</span>
                            </div>
                            <div class="progress mb-3 rounded-pill bg-slate-200" style="height: 7px;">
                                <div class="progress-bar password-strength-bar bg-secondary rounded-pill" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="row g-2 text-secondary">
                                <div class="col-6"><div class="password-req-chip bg-white border shadow-xs" data-req="length"><i class='bx bx-circle me-1 opacity-50'></i> Min 8 characters</div></div>
                                <div class="col-6"><div class="password-req-chip bg-white border shadow-xs" data-req="uppercase"><i class='bx bx-circle me-1 opacity-50'></i> Uppercase (A-Z)</div></div>
                                <div class="col-6"><div class="password-req-chip bg-white border shadow-xs" data-req="lowercase"><i class='bx bx-circle me-1 opacity-50'></i> Lowercase (a-z)</div></div>
                                <div class="col-6"><div class="password-req-chip bg-white border shadow-xs" data-req="number"><i class='bx bx-circle me-1 opacity-50'></i> Number (0-9)</div></div>
                                <div class="col-6"><div class="password-req-chip bg-white border shadow-xs" data-req="special"><i class='bx bx-circle me-1 opacity-50'></i> Special (!@#$)</div></div>
                                <div class="col-6"><div class="password-req-chip bg-white border shadow-xs" data-req="match"><i class='bx bx-circle me-1 opacity-50'></i> Match confirmation</div></div>
                            </div>
                        </div>

                        <!-- Terms & Privacy -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" value="1" id="terms" {{ old('terms') ? 'checked' : '' }} required>
                                <label class="form-check-label small text-secondary" for="terms">
                                    I agree to the <a href="#" class="text-primary fw-semibold">Terms of Service</a> & <a href="#" class="text-primary fw-semibold">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100 py-2.5 rounded-3 mb-3">
                            Create Traveler Account
                        </button>
                    </form>

                    <div class="text-center text-secondary small pt-2 border-top">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="fw-bold text-primary">Sign In</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/password-validator.js') }}"></script>
@endsection
