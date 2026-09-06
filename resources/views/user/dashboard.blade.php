@extends('layouts.app')

@section('title', 'My Bookings & Travel Dashboard | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50" style="min-height: calc(100vh - 160px);">
    <div class="container-xl">

        <!-- User Profile Summary Header -->
        <div class="bg-white rounded-4 border p-4 p-md-5 shadow-sm mb-4">
            <div class="row align-items-center g-4">
                <div class="col-auto">
                    <div class="user-avatar-badge fs-2 shadow-sm" style="width: 72px; height: 72px;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <h3 class="fw-bold text-dark mb-0">{{ auth()->user()->name }}</h3>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small fw-bold">Verified Traveler</span>
                    </div>
                    <div class="text-secondary small d-flex flex-wrap gap-3">
                        <span><i class='bx bx-envelope me-1'></i>{{ auth()->user()->email }}</span>
                        @if(auth()->user()->phone)
                            <span><i class='bx bx-phone me-1'></i>{{ auth()->user()->phone }}</span>
                        @endif
                        <span><i class='bx bx-calendar me-1'></i>Member since {{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                </div>
                <div class="col-12 col-md-auto d-flex gap-3 text-center border-start-md ps-md-4">
                    <div class="px-3">
                        <span class="text-secondary small text-uppercase fw-bold d-block">Total Tickets</span>
                        <h3 class="fw-bold text-primary mb-0">{{ $totalBookings }}</h3>
                    </div>
                    <div class="px-3 border-start">
                        <span class="text-secondary small text-uppercase fw-bold d-block">Total Spent</span>
                        <h3 class="fw-bold text-success mb-0">৳{{ number_format($totalSpent, 0) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metric KPI Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-kpi-card">
                    <div class="stat-icon blue">
                        <i class='bx bx-trip'></i>
                    </div>
                    <div>
                        <div class="text-secondary small fw-bold text-uppercase">Upcoming Trips</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $upcomingBookings->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-kpi-card">
                    <div class="stat-icon green">
                        <i class='bx bx-history'></i>
                    </div>
                    <div>
                        <div class="text-secondary small fw-bold text-uppercase">Completed Trips</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $pastBookings->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-kpi-card">
                    <div class="stat-icon amber">
                        <i class='bx bx-wallet'></i>
                    </div>
                    <div>
                        <div class="text-secondary small fw-bold text-uppercase">Total Invested</div>
                        <h3 class="fw-bold mb-0 text-dark">৳{{ number_format($totalSpent, 0) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Navigation Tabs -->
        <div class="bg-white rounded-4 border shadow-sm overflow-hidden">
            <div class="border-bottom p-3 bg-light">
                <ul class="nav nav-pills gap-2" id="ticketTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active rounded-pill fw-bold px-4" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button">
                            <i class='bx bx-calendar-event me-1'></i>Upcoming Journeys ({{ $upcomingBookings->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link rounded-pill fw-bold px-4" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button">
                            <i class='bx bx-history me-1'></i>Travel History ({{ $pastBookings->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link rounded-pill fw-bold px-4" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button">
                            <i class='bx bx-x-circle me-1'></i>Cancelled & Refunds ({{ $cancelledBookings->count() }})
                        </button>
                    </li>
                </ul>
            </div>

            <div class="p-4">
                <div class="tab-content" id="ticketTabsContent">

                    <!-- 1. UPCOMING TRIPS -->
                    <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                        @if($upcomingBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-secondary small">
                                        <tr>
                                            <th>Ticket Code</th>
                                            <th>Route & Service</th>
                                            <th>Journey Date</th>
                                            <th>Seats / Class</th>
                                            <th>Total Fare</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($upcomingBookings as $b)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('booking.ticket', $b->id) }}" class="fw-bold text-primary font-monospace">
                                                        {{ $b->booking_code }}
                                                    </a>
                                                    <span class="badge {{ $b->transport_type === 'bus' ? 'badge-bus' : ($b->transport_type === 'train' ? 'badge-train' : 'badge-tour') }} badge-pill d-block mt-1" style="font-size: 0.65rem;">
                                                        {{ strtoupper($b->transport_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong class="text-dark">{{ $b->from_city }} ➔ {{ $b->to_city }}</strong>
                                                    <div class="text-secondary small">{{ $b->package_title }}</div>
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-dark">
                                                        {{ \Carbon\Carbon::parse($b->journey_date ?? $b->check_in_date)->format('M d, Y') }}
                                                    </div>
                                                    <small class="text-secondary">
                                                        {{ \Carbon\Carbon::parse($b->journey_date ?? $b->check_in_date)->diffForHumans() }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border px-2.5 py-1">
                                                        {{ $b->seats }} Seat(s)
                                                    </span>
                                                    <div class="text-secondary small mt-0.5">{{ $b->room_type }}</div>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-success">৳{{ number_format($b->total_price, 2) }}</span>
                                                </td>
                                                <td>
                                                    @if($b->payment_status === 'paid')
                                                        <span class="badge badge-status-confirmed badge-pill">Paid ✅</span>
                                                    @else
                                                        <span class="badge badge-status-pending badge-pill">Unpaid ⏳</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-1">
                                                        <a href="{{ route('booking.ticket', $b->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 fw-semibold" title="View & Print Ticket">
                                                            <i class='bx bx-printer align-middle'></i> E-Ticket
                                                        </a>

                                                        @if($b->payment_status !== 'paid')
                                                            <a href="{{ route('payment.checkout', $b->id) }}" class="btn btn-sm btn-primary-gradient rounded-pill px-2.5">
                                                                Pay ৳
                                                            </a>
                                                        @endif

                                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2"
                                                                data-bs-toggle="modal" data-bs-target="#cancelModal{{ $b->id }}" title="Cancel Booking">
                                                            <i class='bx bx-x'></i>
                                                        </button>
                                                    </div>

                                                    <!-- Cancellation Confirmation Modal -->
                                                    <div class="modal fade" id="cancelModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content rounded-4 border-0 shadow">
                                                                <div class="modal-header border-0 pb-0">
                                                                    <h5 class="modal-title fw-bold text-danger">
                                                                        <i class='bx bx-error-circle align-middle me-1'></i>Cancel Ticket Booking
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body text-start pt-3">
                                                                    <p class="text-secondary mb-3">
                                                                        Are you sure you want to cancel booking <strong class="text-dark">{{ $b->booking_code }}</strong> for <strong>{{ $b->from_city }} ➔ {{ $b->to_city }}</strong>?
                                                                    </p>

                                                                    <div class="p-3 bg-light rounded-3 mb-3 border small">
                                                                        <div class="d-flex justify-content-between mb-1">
                                                                            <span>Paid Fare:</span>
                                                                            <strong class="text-dark">৳{{ number_format($b->total_price, 2) }}</strong>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between text-success">
                                                                            <span>Eligible Refund:</span>
                                                                            <strong>৳{{ number_format($b->payment_status === 'paid' ? $b->total_price : 0, 2) }}</strong>
                                                                        </div>
                                                                    </div>

                                                                    <form action="{{ route('booking.cancel', $b->id) }}" method="POST">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label class="form-label small fw-bold">Reason for Cancellation (Optional)</label>
                                                                            <textarea name="reason" rows="2" class="form-control" placeholder="Change of plans, emergency, etc."></textarea>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end gap-2">
                                                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Keep Booking</button>
                                                                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Confirm Cancellation</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="stat-icon blue mx-auto mb-3" style="width: 60px; height: 60px; font-size: 2rem;">
                                    <i class='bx bx-calendar-plus'></i>
                                </div>
                                <h5 class="fw-bold mb-1">No Upcoming Trips Scheduled</h5>
                                <p class="text-secondary small mb-4">You have no active trips booked right now. Explore buses, trains, and tour packages.</p>
                                <a href="{{ route('explore') }}" class="btn btn-primary-gradient px-4 py-2 rounded-pill">
                                    <i class='bx bx-search me-1'></i>Explore & Book Tickets
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- 2. PAST JOURNEYS -->
                    <div class="tab-pane fade" id="past" role="tabpanel">
                        @if($pastBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-secondary small">
                                        <tr>
                                            <th>Ticket Code</th>
                                            <th>Route & Service</th>
                                            <th>Journey Date</th>
                                            <th>Seats</th>
                                            <th>Total Paid</th>
                                            <th>Status</th>
                                            <th class="text-end">Ticket</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pastBookings as $b)
                                            <tr>
                                                <td>
                                                    <span class="fw-bold text-dark font-monospace">{{ $b->booking_code }}</span>
                                                    <span class="badge bg-light text-secondary border d-block mt-1" style="font-size: 0.65rem;">
                                                        {{ strtoupper($b->transport_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong class="text-dark">{{ $b->from_city }} ➔ {{ $b->to_city }}</strong>
                                                    <div class="text-secondary small">{{ $b->package_title }}</div>
                                                </td>
                                                <td>
                                                    <span class="text-dark fw-medium">{{ \Carbon\Carbon::parse($b->journey_date ?? $b->check_in_date)->format('M d, Y') }}</span>
                                                </td>
                                                <td>{{ $b->seats }} Seat(s)</td>
                                                <td class="fw-bold text-dark">৳{{ number_format($b->total_price, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1">Completed</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('booking.ticket', $b->id) }}" class="btn btn-sm btn-light border rounded-pill px-3">
                                                        <i class='bx bx-receipt me-1'></i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <p class="text-secondary small mb-0">No past journeys recorded in your travel history yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- 3. CANCELLED & REFUNDS -->
                    <div class="tab-pane fade" id="cancelled" role="tabpanel">
                        @if($cancelledBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-secondary small">
                                        <tr>
                                            <th>Ticket Code</th>
                                            <th>Route</th>
                                            <th>Date Cancelled</th>
                                            <th>Amount</th>
                                            <th>Cancellation Status</th>
                                            <th>Refund State</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cancelledBookings as $b)
                                            <tr>
                                                <td class="fw-bold font-monospace">{{ $b->booking_code }}</td>
                                                <td>{{ $b->from_city }} ➔ {{ $b->to_city }}</td>
                                                <td>{{ $b->cancelled_at ? \Carbon\Carbon::parse($b->cancelled_at)->format('M d, Y') : 'N/A' }}</td>
                                                <td class="fw-bold">৳{{ number_format($b->total_price, 2) }}</td>
                                                <td>
                                                    <span class="badge badge-status-cancelled badge-pill">Cancelled</span>
                                                </td>
                                                <td>
                                                    @if($b->refund_status === 'approved' || $b->refund_status === 'refunded')
                                                        <span class="badge badge-status-refunded badge-pill">Refund Approved ৳</span>
                                                    @elseif($b->refund_status === 'requested' || $b->refund_status === 'pending')
                                                        <span class="badge badge-status-pending badge-pill">Under Review ⏳</span>
                                                    @elseif($b->refund_status === 'rejected')
                                                        <span class="badge badge-status-cancelled badge-pill">Refund Rejected</span>
                                                    @else
                                                        <span class="badge bg-light text-secondary border badge-pill">No Refund</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <p class="text-secondary small mb-0">You have no cancelled bookings or refund requests.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
