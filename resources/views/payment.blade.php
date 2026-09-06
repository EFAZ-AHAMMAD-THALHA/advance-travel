@extends('layouts.app')

@section('title', 'Booking Checkout & Payment | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50" style="min-height: calc(100vh - 160px);">
    <div class="container-xl" style="max-width: 780px;">

        @if(isset($booking))
        <!-- Ticket Checkout Card -->
        <div class="bg-white rounded-4 border shadow-md overflow-hidden mb-4">
            <!-- Header -->
            <div class="ticket-header d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge {{ $booking->transport_type === 'bus' ? 'badge-bus' : ($booking->transport_type === 'train' ? 'badge-train' : 'badge-tour') }} badge-pill mb-2">
                        {{ strtoupper($booking->transport_type) }} TICKET
                    </span>
                    <h4 class="fw-bold mb-0 text-white">{{ $booking->package_title ?? 'Travel Reservation' }}</h4>
                </div>
                <div class="text-end">
                    <span class="small text-white-50 d-block">Booking Reference</span>
                    <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold rounded-pill">{{ $booking->booking_code }}</span>
                </div>
            </div>

            <div class="p-4 p-md-5">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <span class="text-secondary small d-block">Primary Passenger</span>
                        <strong class="text-dark fs-6">{{ $booking->passenger_name }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-secondary small d-block">Contact Info</span>
                        <span class="text-dark fw-medium">{{ $booking->phone }}</span>
                        <span class="text-muted small d-block">{{ $booking->email }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-secondary small d-block">Travel Route</span>
                        <strong class="text-primary fs-6">{{ $booking->from_city }} ➔ {{ $booking->to_city }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-secondary small d-block">Departure Date</span>
                        <strong class="text-dark">{{ \Carbon\Carbon::parse($booking->journey_date ?? $booking->check_in_date)->format('D, M d, Y') }}</strong>
                        @if($booking->return_date)
                            <span class="text-muted small d-block">Return: {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <span class="text-secondary small d-block">Seat & Accommodation</span>
                        <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-semibold">
                            {{ $booking->seats }} Seat(s)
                            @if($booking->selected_seats)
                                ({{ $booking->selected_seats }})
                            @endif
                            • {{ $booking->room_type }}
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-secondary small d-block">Payment Status</span>
                        @if($booking->payment_status === 'paid')
                            <span class="badge badge-status-confirmed badge-pill">Paid & Confirmed ✅</span>
                        @else
                            <span class="badge badge-status-pending badge-pill">Awaiting Payment ⏳</span>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="text-secondary small">Base Fare: ৳{{ number_format($booking->unit_price * $booking->seats, 2) }}</span>
                        @if($booking->discount_amount > 0)
                            <div class="text-success small fw-semibold">
                                <i class='bx bxs-discount me-1'></i>Promo Code ({{ $booking->promo_code }}): -৳{{ number_format($booking->discount_amount, 2) }}
                            </div>
                        @endif
                        <h5 class="fw-bold text-dark mt-1">Total Payable Amount:</h5>
                    </div>
                    <h2 class="fw-bold text-primary mb-0">৳{{ number_format($booking->total_price, 2) }}</h2>
                </div>

                <!-- Payment Action Options -->
                <div class="row g-3">
                    <div class="col-md-7">
                        <form method="POST" action="{{ route('payment.pay') }}">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            <button type="submit" class="btn btn-primary-gradient btn-lg w-100 py-3 rounded-3 shadow-sm">
                                <i class='bx bxs-credit-card fs-4'></i>
                                <span>Pay via SSLCommerz (bKash/Cards)</span>
                            </button>
                        </form>
                        <small class="text-secondary text-center d-block mt-2" style="font-size: 0.775rem;">
                            Supports bKash, Nagad, Rocket, Visa, Mastercard & Internet Banking
                        </small>
                    </div>

                    <div class="col-md-5">
                        <form method="POST" action="{{ route('payment.cash', $booking->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-lg w-100 py-3 rounded-3 fw-semibold">
                                <i class='bx bx-money me-1'></i>
                                <span>Pay at Terminal</span>
                            </button>
                        </form>
                        <small class="text-secondary text-center d-block mt-2" style="font-size: 0.775rem;">
                            Pay directly at the transport counter or terminal
                        </small>
                    </div>
                </div>

            </div>
        </div>

        @else
        <!-- Standalone Info Card -->
        <div class="bg-white rounded-4 border shadow-sm text-center p-5">
            <div class="brand-icon-box mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.75rem;">
                <i class='bx bx-receipt'></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">No Active Checkout Order</h4>
            <p class="text-secondary small mb-4">Please book an available bus, train, or holiday tour to generate a payment order.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('explore') }}" class="btn btn-primary-gradient px-4 py-2 rounded-pill">Explore Trips</a>
                <a href="{{ route('my.bookings') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill">My Bookings</a>
            </div>
        </div>
        @endif

        <div class="text-center text-secondary small mt-4">
            <i class='bx bx-shield-quarter text-success me-1 align-middle'></i>
            <span>256-Bit Bank-Grade SSL Encryption • Guaranteed Seat Reservation</span>
        </div>

    </div>
</div>
@endsection
