@extends('layouts.app')

@section('title', 'Book Ticket & Tour Reservation | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50">
    <div class="container-xl">

        <!-- Breadcrumb & Title -->
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('explore') }}">Tickets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Booking Checkout</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-1">Confirm Your Travel Reservation</h2>
            <p class="text-secondary small mb-0">Fill in passenger details to secure your seats. Instant digital boarding pass issued upon payment.</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 p-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class='bx bxs-error-circle fs-4 text-danger'></i>
                    <strong class="text-danger">Please correct the following errors:</strong>
                </div>
                <ul class="mb-0 small ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
            @csrf

            @if($package && !empty($package->id))
                <input type="hidden" name="package_id" value="{{ $package->id }}">
            @endif

            <input type="hidden" name="package_price" id="hiddenUnitPrice" value="{{ $package ? $package->price : 1000 }}">
            <input type="hidden" name="package_title" value="{{ $package ? $package->title : 'Custom Ticket' }}">

            <div class="row g-4">
                <!-- Left Form Column -->
                <div class="col-lg-8">
                    <!-- Selected Service Banner Card -->
                    @if($package)
                        <div class="bg-white rounded-4 border p-4 shadow-sm mb-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                                <span class="badge {{ ($package->type ?? 'tour') === 'bus' ? 'badge-bus' : (($package->type ?? 'tour') === 'train' ? 'badge-train' : 'badge-tour') }} badge-pill">
                                    {{ strtoupper($package->type ?? 'tour') }} SERVICE
                                </span>
                                <span class="text-success fw-bold fs-5">৳{{ number_format($package->price, 0) }} / seat</span>
                            </div>

                            <h4 class="fw-bold text-dark mb-1">{{ $package->title }}</h4>
                            <div class="text-secondary small mb-0">
                                <i class='bx bxs-map text-primary me-1'></i>
                                <strong>{{ $package->from_location ?? 'Dhaka' }}</strong> ➔ <strong>{{ $package->to_location ?? $package->location ?? 'Destination' }}</strong>
                                @if(!empty($package->departure_time))
                                    <span class="ms-2"><i class='bx bx-time me-1'></i>{{ $package->departure_time }}</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Step 1: Journey Details -->
                    <div class="bg-white rounded-4 border p-4 shadow-sm mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <div class="brand-icon-box" style="width: 32px; height: 32px; font-size: 1.1rem;">
                                <i class='bx bx-trip'></i>
                            </div>
                            <h5 class="fw-bold mb-0">1. Route & Travel Dates</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Transport Category <span class="text-danger">*</span></label>
                                <select name="transport_type" class="form-select" id="transportTypeSelect" required>
                                    <option value="bus" {{ (old('transport_type') == 'bus' || ($package->type ?? '') == 'bus') ? 'selected' : '' }}>🚌 AC Bus Fleet</option>
                                    <option value="train" {{ (old('transport_type') == 'train' || ($package->type ?? '') == 'train') ? 'selected' : '' }}>🚆 Intercity Train</option>
                                    <option value="tour" {{ (old('transport_type') == 'tour' || ($package->type ?? '') == 'tour') ? 'selected' : '' }}>🏖️ Tour Package</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label d-flex justify-content-between">
                                    <span>From (Departure) <span class="text-danger">*</span></span>
                                    <span class="text-primary small" style="font-size: 0.72rem; cursor: pointer;" onclick="document.getElementById('fromCityBooking').focus()">Suggestions ▼</span>
                                </label>
                                <div class="city-autocomplete-wrapper">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-primary border-end-0"><i class='bx bxs-navigation'></i></span>
                                        <input type="text" class="form-control border-start-0 city-search-input" name="from_city" id="fromCityBooking"
                                               value="{{ old('from_city', $package->from_location ?? 'Dhaka') }}" required autocomplete="off"
                                               data-dropdown="fromDropdownBooking">
                                        <button type="button" class="btn btn-light border border-start-0 text-muted city-dropdown-trigger" data-target="fromDropdownBooking">
                                            <i class='bx bx-chevron-down'></i>
                                        </button>
                                    </div>
                                    <div class="city-suggestion-menu" id="fromDropdownBooking">
                                        <div class="p-2 border-bottom bg-light d-flex justify-content-between align-items-center">
                                            <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.7rem;">Departure Hubs</span>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill" style="font-size: 0.65rem;">Hubs</span>
                                        </div>
                                        <div class="city-suggestion-list"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label mb-0">To (Destination) <span class="text-danger">*</span></label>
                                    <button type="button" class="btn btn-link text-primary p-0 text-decoration-none small fw-semibold d-inline-flex align-items-center gap-1" onclick="swapCities('fromCityBooking', 'toCityBooking')" title="Swap Origin & Destination">
                                        <i class='bx bx-transfer-alt'></i> Swap
                                    </button>
                                </div>
                                <div class="city-autocomplete-wrapper">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-danger border-end-0"><i class='bx bxs-map'></i></span>
                                        <input type="text" class="form-control border-start-0 city-search-input" name="to_city" id="toCityBooking"
                                               value="{{ old('to_city', $package->to_location ?? $package->location ?? '') }}" required autocomplete="off"
                                               data-dropdown="toDropdownBooking">
                                        <button type="button" class="btn btn-light border border-start-0 text-muted city-dropdown-trigger" data-target="toDropdownBooking">
                                            <i class='bx bx-chevron-down'></i>
                                        </button>
                                    </div>
                                    <div class="city-suggestion-menu" id="toDropdownBooking">
                                        <div class="p-2 border-bottom bg-light d-flex justify-content-between align-items-center">
                                            <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.7rem;">Destinations</span>
                                            <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.65rem;">Hot</span>
                                        </div>
                                        <div class="city-suggestion-list"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Journey Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="journey_date" id="journeyDate"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('journey_date', date('Y-m-d')) }}" required>
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                                    <i class='bx bx-info-circle me-1'></i>Today or upcoming dates permitted
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Return Date (Optional)</label>
                                <input type="date" class="form-control" name="return_date" id="returnDate"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('return_date') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Passenger Details -->
                    <div class="bg-white rounded-4 border p-4 shadow-sm mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <div class="brand-icon-box" style="width: 32px; height: 32px; font-size: 1.1rem;">
                                <i class='bx bx-user'></i>
                            </div>
                            <h5 class="fw-bold mb-0">2. Passenger Information</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstname"
                                       value="{{ old('firstname', auth()->user() ? explode(' ', auth()->user()->name)[0] : '') }}" required placeholder="e.g. Tanvir">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname"
                                       value="{{ old('lastname', auth()->user() && count(explode(' ', auth()->user()->name)) > 1 ? explode(' ', auth()->user()->name)[1] : '') }}" placeholder="e.g. Ahmed">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email"
                                       value="{{ old('email', auth()->user() ? auth()->user()->email : '') }}" required placeholder="name@example.com">
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                                    Official e-ticket will be dispatched to this email.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mobile Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone"
                                       placeholder="017xxxxxxxx or +8801xxxxxxxxx"
                                       value="{{ old('phone', auth()->user() ? auth()->user()->phone : '') }}" required>
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                                    Required for boarding SMS and cancellation OTP.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Seats & Class -->
                    <div class="bg-white rounded-4 border p-4 shadow-sm mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <div class="brand-icon-box" style="width: 32px; height: 32px; font-size: 1.1rem;">
                                <i class='bx bx-chair'></i>
                            </div>
                            <h5 class="fw-bold mb-0">3. Seats & Cabin Class</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Allocated Seats / Passengers <span class="text-danger">*</span></label>
                                <select name="seats" class="form-select" id="seatsSelect" required>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('seats', 1) == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'Passenger (1 Seat)' : 'Passengers ('.$i.' Seats)' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Cabin Class / Tier <span class="text-danger">*</span></label>
                                <select name="room_type" class="form-select" required>
                                    <option value="AC Business Class">AC Business Class / Shovon Chair</option>
                                    <option value="Economy Class">Economy Non-AC Chair</option>
                                    <option value="Sleeper / Deluxe Cabin">Sleeper / Deluxe Cabin</option>
                                    <option value="Standard Package Room">Standard Room (Tour)</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Special Requests (Optional)</label>
                                <textarea name="additional" rows="2" class="form-control" placeholder="Luggage details, window seat preference, or boarding station notes...">{{ old('additional') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sticky Summary Column -->
                <div class="col-lg-4">
                    <div class="booking-summary-card p-4">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom">Fare Breakdown</h5>

                        <div class="d-flex justify-content-between text-secondary small mb-2">
                            <span>Base Ticket Fare</span>
                            <span class="fw-semibold text-dark" id="displayUnitPrice">৳{{ number_format($package ? $package->price : 1000, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between text-secondary small mb-2">
                            <span>Passenger Count</span>
                            <span class="fw-semibold text-dark" id="displaySeatCount">1 Seat</span>
                        </div>

                        <div class="d-flex justify-content-between text-secondary small mb-2">
                            <span>Online Reservation Fee</span>
                            <span class="text-success fw-bold">FREE (৳0)</span>
                        </div>

                        <div class="d-flex justify-content-between text-secondary small mb-3 pb-3 border-bottom">
                            <span>Applicable Taxes & VAT</span>
                            <span class="fw-semibold text-dark">৳0.00</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="fw-bold text-dark fs-6 d-block">Total Payable:</span>
                                <small class="text-muted" style="font-size: 0.75rem;">Instant E-Ticket issuance</small>
                            </div>
                            <h3 class="fw-bold text-primary mb-0" id="totalPriceDisplay">
                                ৳{{ number_format($package ? $package->price : 1000, 2) }}
                            </h3>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient w-100 py-3 mb-3">
                            <span>Proceed to Payment</span>
                            <i class='bx bx-credit-card fs-5'></i>
                        </button>

                        <!-- Trust Guarantees -->
                        <div class="p-3 rounded-3 bg-light border text-start small">
                            <div class="d-flex align-items-center gap-2 mb-1.5 text-dark fw-semibold">
                                <i class='bx bx-check-shield text-success fs-5'></i>
                                <span>100% Refundable</span>
                            </div>
                            <p class="text-secondary mb-2" style="font-size: 0.775rem; line-height: 1.5;">
                                Easily cancel your ticket up to 24 hours prior to journey date directly from your user dashboard.
                            </p>
                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.75rem;">
                                <i class='bx bx-lock-alt text-primary'></i>
                                <span>SSL Encrypted Checkout</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const seatsSelect = document.getElementById('seatsSelect');
        const hiddenUnitPrice = document.getElementById('hiddenUnitPrice');
        const displaySeatCount = document.getElementById('displaySeatCount');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const journeyDate = document.getElementById('journeyDate');
        const returnDate = document.getElementById('returnDate');

        function updateTotal() {
            const seats = parseInt(seatsSelect.value) || 1;
            const unitPrice = parseFloat(hiddenUnitPrice.value) || 1000;
            const total = seats * unitPrice;

            if (displaySeatCount) {
                displaySeatCount.innerText = `${seats} ${seats === 1 ? 'Seat' : 'Seats'}`;
            }
            if (totalPriceDisplay) {
                totalPriceDisplay.innerText = `৳${total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }
        }

        if (seatsSelect) {
            seatsSelect.addEventListener('change', updateTotal);
        }

        if (journeyDate && returnDate) {
            journeyDate.addEventListener('change', function() {
                returnDate.min = this.value;
                if (returnDate.value && returnDate.value < this.value) {
                    returnDate.value = this.value;
                }
            });
        }
    });
</script>
@endpush

@endsection
