@extends('layouts.app')

@section('title', 'e-Ticket #' . $booking->booking_code . ' | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50">
    <div class="container-xl ticket-wrapper">

        <!-- Action Bar (Hidden on Print) -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('my.bookings') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-1.5 fw-semibold">
                <i class='bx bx-arrow-back me-1'></i> Back to My Bookings
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-primary-gradient rounded-pill px-4 py-1.5 fw-semibold shadow-sm">
                    <i class='bx bx-printer me-1'></i> Print / Save as PDF
                </button>
                @if($booking->payment_status === 'unpaid' && $booking->status !== 'cancelled')
                    <a href="{{ route('payment.checkout', $booking->id) }}" class="btn btn-success rounded-pill px-3.5 py-1.5 fw-bold">
                        💳 Pay ৳{{ number_format($booking->total_price, 0) }}
                    </a>
                @endif
            </div>
        </div>

        <!-- Official Boarding Pass -->
        <div class="boarding-pass">
            <!-- Ticket Header -->
            <div class="ticket-header d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="brand-icon-box" style="width: 44px; height: 44px; font-size: 1.4rem;">
                        <i class='bx bxs-compass'></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white">Advance Travel & Tourism</h4>
                        <small class="text-white-50">Official Electronic Boarding Pass & Reservation Voucher</small>
                    </div>
                </div>
                <div class="text-end mt-2 mt-sm-0">
                    <span class="badge {{ $booking->transport_type === 'bus' ? 'badge-bus' : ($booking->transport_type === 'train' ? 'badge-train' : 'badge-tour') }} badge-pill mb-1">
                        {{ strtoupper($booking->transport_type) }} TICKET
                    </span>
                    <div class="font-monospace text-light small">PNR: <strong>{{ $booking->booking_code }}</strong></div>
                </div>
            </div>

            <!-- Route Banner Bar -->
            <div class="bg-light px-4 py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="fw-bold text-dark fs-5">{{ $booking->from_city }}</div>
                    <div class="text-primary fs-4 d-flex align-items-center">
                        <i class='bx bx-right-arrow-alt'></i>
                    </div>
                    <div class="fw-bold text-dark fs-5">{{ $booking->to_city }}</div>
                </div>
                <div>
                    <span class="badge {{ $booking->status === 'confirmed' ? 'badge-status-confirmed' : ($booking->status === 'cancelled' ? 'badge-status-cancelled' : 'badge-status-pending') }} badge-pill">
                        STATUS: {{ strtoupper($booking->status) }}
                    </span>
                </div>
            </div>

            <!-- Ticket Details Grid -->
            <div class="p-4 p-md-5">
                <div class="row g-4">
                    <!-- Main Itinerary -->
                    <div class="col-md-8">
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Passenger Name</span>
                                <h5 class="fw-bold text-dark mb-0 mt-1">{{ $booking->passenger_name }}</h5>
                                <small class="text-secondary">{{ $booking->phone }}</small>
                            </div>

                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Contact Email</span>
                                <div class="fw-semibold text-dark mt-1 text-truncate">{{ $booking->email }}</div>
                                <small class="text-secondary">E-Ticket Confirmed</small>
                            </div>

                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Date of Journey</span>
                                <div class="fs-5 fw-bold text-primary mt-1">
                                    {{ \Carbon\Carbon::parse($booking->journey_date ?? $booking->check_in_date)->format('D, M d, Y') }}
                                </div>
                                @if($booking->return_date)
                                    <small class="text-secondary">Return: {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</small>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Seats & Class</span>
                                <div class="fs-5 fw-bold text-dark mt-1">
                                    {{ $booking->seats }} Seat(s)
                                </div>
                                <small class="text-secondary">{{ $booking->room_type }}</small>
                            </div>

                            <div class="col-12">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Package / Operator Service</span>
                                <div class="fw-bold text-dark mt-1">{{ $booking->package_title ?? 'Advance Travel Intercity Express' }}</div>
                            </div>
                        </div>

                        <!-- Boarding Notice -->
                        <div class="p-3 rounded-3 bg-light border small text-secondary">
                            <div class="fw-bold text-dark mb-1"><i class='bx bx-info-circle text-primary me-1'></i>Passenger Notice:</div>
                            Please arrive at the station terminal at least 20 minutes before scheduled departure. Present this digital e-ticket or a printed copy along with a valid National ID or Student ID.
                        </div>
                    </div>

                    <!-- Right Stub / Verification Column -->
                    <div class="col-md-4 border-start-md ps-md-4">
                        <div class="text-center p-3 rounded-3 bg-light border mb-3">
                            <!-- Simulated QR Code -->
                            <div class="bg-white p-2 d-inline-block rounded-3 shadow-xs border mb-2">
                                <svg width="110" height="110" viewBox="0 0 100 100" fill="none">
                                    <rect width="100" height="100" fill="white"/>
                                    <!-- QR pattern simulator -->
                                    <rect x="10" y="10" width="25" height="25" fill="#0f172a"/>
                                    <rect x="15" y="15" width="15" height="15" fill="white"/>
                                    <rect x="18" y="18" width="9" height="9" fill="#0f172a"/>
                                    <rect x="65" y="10" width="25" height="25" fill="#0f172a"/>
                                    <rect x="70" y="15" width="15" height="15" fill="white"/>
                                    <rect x="73" y="18" width="9" height="9" fill="#0f172a"/>
                                    <rect x="10" y="65" width="25" height="25" fill="#0f172a"/>
                                    <rect x="15" y="70" width="15" height="15" fill="white"/>
                                    <rect x="18" y="73" width="9" height="9" fill="#0f172a"/>
                                    <rect x="42" y="12" width="6" height="6" fill="#0f172a"/>
                                    <rect x="52" y="20" width="6" height="6" fill="#0f172a"/>
                                    <rect x="42" y="42" width="16" height="16" fill="#0f172a"/>
                                    <rect x="65" y="45" width="8" height="8" fill="#0f172a"/>
                                    <rect x="78" y="55" width="8" height="8" fill="#0f172a"/>
                                    <rect x="45" y="75" width="12" height="12" fill="#0f172a"/>
                                    <rect x="68" y="78" width="18" height="8" fill="#0f172a"/>
                                </svg>
                            </div>
                            <div class="small fw-bold text-dark font-monospace">{{ $booking->booking_code }}</div>
                            <div class="text-secondary" style="font-size: 0.725rem;">Scan to Verify at Terminal</div>
                        </div>

                        <!-- Financial Summary -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small text-secondary mb-1">
                                <span>Total Paid Fare:</span>
                                <strong class="text-success fs-6">৳{{ number_format($booking->total_price, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between small text-secondary mb-1">
                                <span>Payment Mode:</span>
                                <span class="fw-semibold text-dark">{{ strtoupper($booking->payment_method ?? 'ONLINE') }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-secondary">
                                <span>Payment Status:</span>
                                <span class="badge {{ $booking->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-2">
                                    {{ $booking->payment_status === 'paid' ? 'VERIFIED PAID' : 'UNPAID / PENDING' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perforated Divider -->
            <div class="ticket-divider"></div>

            <!-- Bottom Barcode Strip -->
            <div class="p-4 bg-light text-center">
                <div class="barcode-strip mx-auto mb-2" style="max-width: 480px;"></div>
                <div class="font-monospace text-secondary small">
                    *{{ $booking->booking_code }}* • ISSUED BY ADVANCE TRAVEL & TOURISM BANGLADESH
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
