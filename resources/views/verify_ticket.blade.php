@extends('layouts.app')

@section('title', 'Ticket & QR Verification Portal | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50">
    <div class="container-xl" style="max-width: 820px;">

        <!-- Portal Header -->
        <div class="text-center mb-4">
            <div class="brand-icon-box mx-auto mb-2" style="width: 48px; height: 48px; font-size: 1.6rem;">
                <i class='bx bx-check-shield'></i>
            </div>
            <h2 class="fw-bold text-dark mb-1">Official Ticket Verification Portal</h2>
            <p class="text-secondary small mb-0">Authorized conductor & passenger electronic boarding pass verification system.</p>
        </div>

        <!-- PNR Lookup Form -->
        <div class="bg-white rounded-4 border p-3 shadow-sm mb-4">
            <form action="{{ route('booking.verify') }}" method="GET" class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-light text-primary border-end-0"><i class='bx bx-qr-scan fs-5'></i></span>
                    <input type="text" name="code" class="form-control border-start-0 font-monospace text-uppercase fw-bold"
                           placeholder="Enter PNR or Booking Code (e.g. TKT-2026-XXXXXX)"
                           value="{{ old('code', $searchCode ?? '') }}" required>
                </div>
                <button type="submit" class="btn btn-primary-gradient px-4 fw-semibold d-inline-flex align-items-center gap-1">
                    <i class='bx bx-search'></i> Verify
                </button>
            </form>
        </div>

        @if($booking)
            <!-- Verification Result Card -->
            <div class="bg-white rounded-4 border shadow-sm overflow-hidden mb-4">
                <!-- Status Banner -->
                <div class="p-4 text-center {{ $booking->status === 'confirmed' ? 'bg-success-subtle text-success' : ($booking->status === 'cancelled' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary') }} border-bottom">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 56px; height: 56px; background-color: rgba(255,255,255,0.85);">
                        @if($booking->status === 'confirmed')
                            <i class='bx bxs-check-circle fs-1 text-success'></i>
                        @elseif($booking->status === 'cancelled')
                            <i class='bx bxs-x-circle fs-1 text-danger'></i>
                        @else
                            <i class='bx bxs-info-circle fs-1 text-primary'></i>
                        @endif
                    </div>

                    @if($booking->status === 'confirmed')
                        <h4 class="fw-bold mb-1 text-success">AUTHENTIC & VALID BOARDING PASS</h4>
                        <p class="small mb-0 text-success-emphasis">Passenger is cleared for boarding. Identity & ticket verified on official registry.</p>
                    @elseif($booking->status === 'cancelled')
                        <h4 class="fw-bold mb-1 text-danger">TICKET CANCELLED / VOID</h4>
                        <p class="small mb-0 text-danger-emphasis">This ticket has been officially cancelled. Boarding is not permitted.</p>
                    @elseif($booking->status === 'completed')
                        <h4 class="fw-bold mb-1 text-primary">JOURNEY COMPLETED</h4>
                        <p class="small mb-0 text-primary-emphasis">This ticket has already been utilized for completed travel.</p>
                    @else
                        <h4 class="fw-bold mb-1 text-dark">STATUS: {{ strtoupper($booking->status) }}</h4>
                        <p class="small mb-0 text-muted">Ticket record exists in registry.</p>
                    @endif
                </div>

                <!-- Ticket Particulars Grid -->
                <div class="p-4 p-md-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 mb-4 border-bottom">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold d-block">Booking Reference (PNR)</span>
                            <h4 class="fw-bold text-dark font-monospace mb-0">{{ $booking->booking_code }}</h4>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $booking->transport_type === 'flight' ? 'badge-flight' : ($booking->transport_type === 'bus' ? 'badge-bus' : ($booking->transport_type === 'train' ? 'badge-train' : 'badge-tour')) }} badge-pill fs-6 px-3 py-1.5">
                                {{ strtoupper($booking->transport_type) }} FLEET
                            </span>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <span class="text-secondary small fw-bold text-uppercase d-block">Passenger Name</span>
                            <div class="fs-5 fw-bold text-dark mt-0.5">{{ $booking->passenger_name }}</div>
                            <small class="text-muted"><i class='bx bx-phone me-1'></i>{{ $booking->phone }}</small>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-secondary small fw-bold text-uppercase d-block">Travel Route</span>
                            <div class="fs-5 fw-bold text-dark mt-0.5 d-flex align-items-center gap-2">
                                <span>{{ $booking->from_city }}</span>
                                <i class='bx bx-right-arrow-alt text-primary'></i>
                                <span>{{ $booking->to_city }}</span>
                            </div>
                            <small class="text-muted">{{ $booking->package_title ?? 'Intercity Express Service' }}</small>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-secondary small fw-bold text-uppercase d-block">Journey Date</span>
                            <div class="fs-5 fw-bold text-primary mt-0.5">
                                {{ \Carbon\Carbon::parse($booking->journey_date ?? $booking->check_in_date)->format('l, M d, Y') }}
                            </div>
                            @if($booking->return_date)
                                <small class="text-secondary">Return: {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-6">
                            <span class="text-secondary small fw-bold text-uppercase d-block">Allocated Seats & Class</span>
                            <div class="fs-5 fw-bold text-dark mt-0.5">
                                @if($booking->selected_seats)
                                    <span class="badge bg-primary text-white fs-6 px-2.5 py-1">{{ $booking->selected_seats }}</span>
                                @else
                                    <span>{{ $booking->seats }} Seat(s)</span>
                                @endif
                            </div>
                            <small class="text-secondary">{{ $booking->room_type }}</small>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-secondary small fw-bold text-uppercase d-block">Payment Status</span>
                            <div class="mt-1">
                                <span class="badge {{ $booking->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3 py-1.5 font-medium">
                                    {{ $booking->payment_status === 'paid' ? 'PAID & VERIFIED (৳' . number_format($booking->total_price, 2) . ')' : 'UNPAID / ON BOARDING (৳' . number_format($booking->total_price, 2) . ')' }}
                                </span>
                            </div>
                            @if($booking->promo_code)
                                <small class="text-success d-block mt-1"><i class='bx bxs-discount me-1'></i>Promo Code Applied: <strong>{{ $booking->promo_code }}</strong></small>
                            @endif
                        </div>

                        <div class="col-sm-6">
                            <span class="text-secondary small fw-bold text-uppercase d-block">Issued Timestamp</span>
                            <div class="fw-semibold text-dark mt-0.5">
                                {{ $booking->created_at ? $booking->created_at->format('M d, Y • h:i A') : 'N/A' }}
                            </div>
                            <small class="text-muted">Digital Seal: SHA256-{{ substr(hash('sha256', $booking->booking_code . $booking->created_at), 0, 16) }}</small>
                        </div>
                    </div>

                    @if($booking->cancellation_reason)
                        <div class="p-3 rounded-3 bg-danger-subtle border border-danger-subtle text-danger small mb-4">
                            <strong>Cancellation Reason:</strong> {{ $booking->cancellation_reason }}
                        </div>
                    @endif

                    <!-- Verification Stamp Box -->
                    <div class="p-3 rounded-3 bg-light border d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class='bx bx-check-double text-success fs-3'></i>
                            <div>
                                <div class="fw-bold text-dark small">Digitally Verified via Advance Travel Cloud</div>
                                <div class="text-secondary" style="font-size: 0.72rem;">Official registry lookup complete. All rights reserved.</div>
                            </div>
                        </div>
                        @auth
                            @if($booking->user_id === auth()->id() || auth()->user()->is_admin)
                                <a href="{{ route('booking.ticket', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                                    <i class='bx bx-printer me-1'></i> View Boarding Pass
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @elseif(!empty($searchCode))
            <!-- Not Found State -->
            <div class="bg-white rounded-4 border p-5 text-center shadow-sm mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger-subtle text-danger mb-3" style="width: 64px; height: 64px;">
                    <i class='bx bx-search-alt fs-1'></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">No Ticket Record Found</h4>
                <p class="text-secondary small mb-3">No active or archived travel voucher was found matching PNR code <code>{{ $searchCode }}</code>.</p>
                <div class="alert alert-warning border-0 rounded-3 small max-w-md mx-auto mb-0" style="max-width: 480px;">
                    <i class='bx bx-info-circle me-1'></i>Please ensure the booking code was entered accurately or scan the QR code printed on the e-ticket.
                </div>
            </div>
        @else
            <!-- Instruction State -->
            <div class="bg-white rounded-4 border p-5 text-center shadow-sm mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary mb-3" style="width: 64px; height: 64px;">
                    <i class='bx bx-barcode-reader fs-1'></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Scan QR or Search PNR Code</h5>
                <p class="text-secondary small mb-0" style="max-width: 500px; margin: 0 auto;">
                    Point your mobile device camera at any Advance Travel QR code to verify instantly, or enter the 12-character booking reference code in the search box above.
                </p>
            </div>
        @endif

    </div>
</div>
@endsection
