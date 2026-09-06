@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="row g-4 mb-4">
    <!-- Stat 1: Total Bookings -->
    <div class="col-md-4">
        <div class="card-custom d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted fw-semibold small text-uppercase">Total Bookings</span>
                <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalBookings }}</h2>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded-4 text-primary">
                <i class='bx bxs-book-content fs-1'></i>
            </div>
        </div>
    </div>

    <!-- Stat 2: Active Packages -->
    <div class="col-md-4">
        <div class="card-custom d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted fw-semibold small text-uppercase">Active Packages</span>
                <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalPackages }}</h2>
            </div>
            <div class="bg-success bg-opacity-10 p-3 rounded-4 text-success">
                <i class='bx bxs-package fs-1'></i>
            </div>
        </div>
    </div>

    <!-- Stat 3: Contact Messages -->
    <div class="col-md-4">
        <div class="card-custom d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted fw-semibold small text-uppercase">Customer Inquiries</span>
                <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalContacts }}</h2>
            </div>
            <div class="bg-warning bg-opacity-10 p-3 rounded-4 text-warning">
                <i class='bx bxs-envelope fs-1'></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Table -->
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold m-0 text-dark">Recent Customer Bookings</h5>
            <small class="text-muted">Latest travel package reservations submitted by users</small>
        </div>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-sm rounded-3 px-3 fw-semibold">
            View All Bookings
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Guest Name</th>
                    <th class="py-3">Contact Details</th>
                    <th class="py-3">Selected Package</th>
                    <th class="py-3">Check-in Date</th>
                    <th class="py-3">Room Type</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td class="fw-bold text-dark">{{ $booking->firstname }} {{ $booking->lastname }}</td>
                        <td>
                            <div>{{ $booking->email }}</div>
                            <small class="text-muted">{{ $booking->phone }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 fw-bold">
                                {{ $booking->package_title ?? $booking->destination ?? 'Custom Tour' }}
                            </span>
                        </td>
                        <td class="fw-medium">
                            {{ $booking->check_in_date ? date('M d, Y', strtotime($booking->check_in_date)) : 'N/A' }}
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 rounded-2">
                                {{ $booking->rooms }} Room(s) ({{ $booking->room_type }})
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class='bx bx-calendar-x fs-1 d-block mb-2 text-secondary opacity-50'></i>
                            No travel bookings submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
