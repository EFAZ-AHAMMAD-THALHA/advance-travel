@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <!-- Stat 1: Total Bookings -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom d-flex align-items-center justify-content-between p-4">
            <div>
                <span class="text-muted fw-bold small text-uppercase" style="font-size: 0.72rem;">Total Bookings</span>
                <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalBookings }}</h2>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded-4 text-primary fs-2">
                <i class='bx bxs-book-content'></i>
            </div>
        </div>
    </div>

    <!-- Stat 2: Total Revenue -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom d-flex align-items-center justify-content-between p-4">
            <div>
                <span class="text-muted fw-bold small text-uppercase" style="font-size: 0.72rem;">Total Revenue</span>
                <h2 class="fw-bold text-success mb-0 mt-1">৳{{ number_format($totalRevenue, 0) }}</h2>
            </div>
            <div class="bg-success bg-opacity-10 p-3 rounded-4 text-success fs-2">
                <i class='bx bxs-badge-dollar'></i>
            </div>
        </div>
    </div>

    <!-- Stat 3: Active Fleet & Packages -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom d-flex align-items-center justify-content-between p-4">
            <div>
                <span class="text-muted fw-bold small text-uppercase" style="font-size: 0.72rem;">Active Services</span>
                <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalPackages }}</h2>
            </div>
            <div class="bg-info bg-opacity-10 p-3 rounded-4 text-info fs-2">
                <i class='bx bxs-bus'></i>
            </div>
        </div>
    </div>

    <!-- Stat 4: Pending Refunds -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom d-flex align-items-center justify-content-between p-4">
            <div>
                <span class="text-muted fw-bold small text-uppercase" style="font-size: 0.72rem;">Refund Requests</span>
                <h2 class="fw-bold {{ $pendingRefunds > 0 ? 'text-danger' : 'text-secondary' }} mb-0 mt-1">{{ $pendingRefunds }}</h2>
            </div>
            <div class="bg-danger bg-opacity-10 p-3 rounded-4 text-danger fs-2">
                <i class='bx bx-refresh'></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Table -->
<div class="card-custom">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h5 class="fw-bold m-0 text-dark">Recent Customer Bookings 🎫</h5>
            <small class="text-muted">Latest travel reservations across bus, train, and tour packages</small>
        </div>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
            View All Reservations ➔
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Code</th>
                    <th class="py-3">Passenger</th>
                    <th class="py-3">Service & Route</th>
                    <th class="py-3">Travel Date</th>
                    <th class="py-3">Fare</th>
                    <th class="py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td class="fw-bold font-monospace text-primary">
                            {{ $booking->booking_code }}
                        </td>
                        <td>
                            <strong class="text-dark">{{ $booking->passenger_name }}</strong>
                            <div class="text-muted small">{{ $booking->phone }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $booking->transport_type === 'bus' ? 'bg-warning text-dark' : ($booking->transport_type === 'train' ? 'bg-danger text-white' : 'bg-primary') }} text-uppercase px-2 py-0.5" style="font-size: 0.68rem;">
                                {{ $booking->transport_type }}
                            </span>
                            <span class="fw-semibold ms-1">{{ $booking->from_city }} ➔ {{ $booking->to_city }}</span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($booking->journey_date ?? $booking->check_in_date)->format('M d, Y') }}
                        </td>
                        <td class="fw-bold text-success">
                            ৳{{ number_format($booking->total_price, 2) }}
                        </td>
                        <td>
                            @if($booking->status === 'cancelled')
                                <span class="badge bg-danger px-2.5 py-1 rounded-pill">Cancelled</span>
                            @elseif($booking->status === 'confirmed')
                                <span class="badge bg-success px-2.5 py-1 rounded-pill">Confirmed</span>
                            @else
                                <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill">{{ ucfirst($booking->status) }}</span>
                            @endif

                            @if($booking->payment_status === 'paid')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success ms-1">Paid</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-dark border border-warning ms-1">Unpaid</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
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
