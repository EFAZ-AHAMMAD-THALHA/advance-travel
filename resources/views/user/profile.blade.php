@extends('layouts.app')

@section('title', 'My Traveler Profile & Settings | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50">
    <div class="container-xl">

        <!-- Header -->
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('my.bookings') }}">My Bookings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile & Security</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-1">Account & Traveler Settings</h2>
            <p class="text-secondary small mb-0">Manage your traveler credentials, contact numbers for boarding alerts, and security preferences.</p>
        </div>

        <div class="row g-4">
            <!-- Left Profile Summary Card -->
            <div class="col-lg-4">
                <div class="bg-white rounded-4 border p-4 shadow-sm text-center mb-4">
                    <div class="user-avatar-large mx-auto mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                    <p class="text-secondary small mb-2">{{ $user->email }}</p>
                    <div class="d-inline-flex align-items-center gap-1">
                        <span class="badge {{ $user->is_admin ? 'bg-warning text-dark' : 'bg-primary-subtle text-primary' }} rounded-pill px-3 py-1.5 font-medium">
                            {{ $user->is_admin ? 'System Administrator' : 'Verified Traveler' }}
                        </span>
                    </div>

                    <hr class="my-4">

                    <!-- Traveler Stats Grid -->
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="p-2 rounded-3 bg-light border">
                                <div class="fw-bold text-dark fs-5">{{ $totalTrips }}</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Total Trips</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3 bg-light border">
                                <div class="fw-bold text-primary fs-5">{{ $upcomingTrips }}</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Upcoming</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3 bg-light border">
                                <div class="fw-bold text-success fs-5">{{ $completedTrips }}</div>
                                <small class="text-secondary" style="font-size: 0.72rem;">Done</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 border-top text-start">
                        <div class="d-flex align-items-center justify-content-between small text-secondary mb-2">
                            <span>Member Since:</span>
                            <span class="fw-semibold text-dark">{{ $user->created_at ? $user->created_at->format('M Y') : '2026' }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between small text-secondary">
                            <span>Total Spent:</span>
                            <span class="fw-bold text-success">৳{{ number_format($totalSpent, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Fast Shortcuts -->
                <div class="bg-white rounded-4 border p-4 shadow-sm">
                    <h6 class="fw-bold mb-3 text-dark">Traveler Quick Actions</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('my.bookings') }}" class="btn btn-light text-start d-flex align-items-center justify-content-between py-2.5 px-3 rounded-3 border">
                            <span class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                                <i class='bx bx-receipt text-primary fs-5'></i> View My Bookings
                            </span>
                            <i class='bx bx-chevron-right text-muted'></i>
                        </a>
                        <a href="{{ route('explore') }}" class="btn btn-light text-start d-flex align-items-center justify-content-between py-2.5 px-3 rounded-3 border">
                            <span class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                                <i class='bx bx-compass text-info fs-5'></i> Book New Tickets
                            </span>
                            <i class='bx bx-chevron-right text-muted'></i>
                        </a>
                        <a href="{{ route('booking.verify') }}" class="btn btn-light text-start d-flex align-items-center justify-content-between py-2.5 px-3 rounded-3 border">
                            <span class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                                <i class='bx bx-qr-scan text-success fs-5'></i> Verify Any Ticket / PNR
                            </span>
                            <i class='bx bx-chevron-right text-muted'></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Forms Column -->
            <div class="col-lg-8">
                <!-- Personal Info Card -->
                <div class="bg-white rounded-4 border p-4 p-md-5 shadow-sm mb-4">
                    <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                        <div class="brand-icon-box" style="width: 34px; height: 34px; font-size: 1.15rem;">
                            <i class='bx bx-user-pin'></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Personal Information</h5>
                            <small class="text-secondary">Used for pre-filling passenger tickets and sending travel notifications.</small>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address</label>
                                <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly disabled>
                                <small class="text-muted" style="font-size: 0.72rem;">Primary account identity email cannot be changed directly.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Mobile Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="017xxxxxxxx" value="{{ old('phone', $user->phone) }}">
                                <small class="text-muted" style="font-size: 0.72rem;">Used for boarding SMS and cancellation OTP verifications.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Emergency Contact Number</label>
                                <input type="tel" name="emergency_contact" class="form-control" placeholder="018xxxxxxxx" value="{{ old('emergency_contact', $user->emergency_contact) }}">
                                <small class="text-muted" style="font-size: 0.72rem;">Contact for emergency notifications during intercity travel.</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Default City / Residential Address</label>
                                <input type="text" name="address" class="form-control" placeholder="e.g. Uttara Sector 4, Dhaka" value="{{ old('address', $user->address) }}">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary-gradient px-4 py-2 fw-semibold">
                                    <i class='bx bx-save me-1'></i> Save Profile Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Password & Security Card -->
                <div class="bg-white rounded-4 border p-4 p-md-5 shadow-sm">
                    <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                        <div class="brand-icon-box" style="width: 34px; height: 34px; font-size: 1.15rem; background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class='bx bx-shield-quarter'></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Password & Security</h5>
                            <small class="text-secondary">Ensure your account is protected with a secure password.</small>
                        </div>
                    </div>

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Current Password <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" class="form-control" required placeholder="Enter current password">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required placeholder="Min. 6 characters">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Re-type new password">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-dark px-4 py-2 fw-semibold">
                                    <i class='bx bx-lock-alt me-1'></i> Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
