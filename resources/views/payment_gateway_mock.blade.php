@extends('layouts.app')

@section('title', 'SSLCommerz Payment Gateway | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50 d-flex align-items-center" style="min-height: calc(100vh - 160px);">
    <div class="container-xl" style="max-width: 600px;">
        <div class="bg-white rounded-4 border shadow-xl overflow-hidden">
            <!-- Gateway Header -->
            <div class="p-4 text-white text-center" style="background: linear-gradient(135deg, #091a38 0%, #1e3a8a 100%);">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill small">SSLCOMMERZ SANDBOX</span>
                    <span class="small text-white-50"><i class='bx bx-lock-alt'></i> 256-Bit Encrypted</span>
                </div>
                <h4 class="fw-bold mb-1">Advance Travel & Tourism</h4>
                <p class="mb-0 text-white-50 small">Official Payment Gateway Simulation</p>
            </div>

            <div class="p-4 p-md-5">
                <!-- Order Summary -->
                <div class="bg-light p-3.5 rounded-3 mb-4 border">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-secondary">Booking Reference:</span>
                        <strong class="text-primary">{{ $booking->booking_code }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-secondary">Passenger Name:</span>
                        <span class="fw-semibold text-dark">{{ $booking->passenger_name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-secondary">Route:</span>
                        <span class="text-dark">{{ $booking->from_city }} ➔ {{ $booking->to_city }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-secondary">Allocated Seats:</span>
                        <span class="text-dark">{{ $booking->seats }} Seat(s) ({{ $booking->room_type }})</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Total Amount Due:</span>
                        <h3 class="fw-bold text-success mb-0">৳{{ number_format($amount, 2) }}</h3>
                    </div>
                </div>

                <!-- Payment Methods -->
                <h6 class="fw-bold text-dark mb-3">Select Simulation Gateway:</h6>
                <div class="row g-2 mb-4">
                    <div class="col-4">
                        <div class="border rounded-3 p-3 text-center bg-white shadow-xs border-primary">
                            <span class="fs-3 d-block mb-1">📱</span>
                            <small class="fw-bold text-dark d-block">bKash</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded-3 p-3 text-center bg-white shadow-xs">
                            <span class="fs-3 d-block mb-1">🟠</span>
                            <small class="fw-bold text-dark d-block">Nagad</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded-3 p-3 text-center bg-white shadow-xs">
                            <span class="fs-3 d-block mb-1">💳</span>
                            <small class="fw-bold text-dark d-block">Visa / Card</small>
                        </div>
                    </div>
                </div>

                <!-- Complete Payment Simulation -->
                <form action="{{ route('payment.success') }}" method="POST" class="mb-2">
                    @csrf
                    <input type="hidden" name="tran_id" value="{{ $tran_id }}">
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="value_a" value="{{ $booking->id }}">
                    <input type="hidden" name="value_b" value="{{ $booking->user_id }}">
                    <input type="hidden" name="card_type" value="VISA / bKash Online">
                    <button type="submit" class="btn btn-success w-100 py-3 rounded-3 fw-bold fs-5 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class='bx bxs-check-circle'></i>
                        <span>Authorize Payment (৳{{ number_format($amount, 2) }})</span>
                    </button>
                </form>

                <form action="{{ route('payment.cancel') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tran_id" value="{{ $tran_id }}">
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="value_a" value="{{ $booking->id }}">
                    <input type="hidden" name="value_b" value="{{ $booking->user_id }}">
                    <button type="submit" class="btn btn-link text-danger w-100 text-decoration-none mt-2 small">
                        Cancel Transaction & Return
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
