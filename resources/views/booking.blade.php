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

            @php
                $defaultUnitPrice = 1200;
                if ($package && !empty($package->price)) {
                    $defaultUnitPrice = $package->price;
                } else {
                    $selectedType = old('transport_type', 'flight');
                    $pricingMap = ['flight' => 3800, 'bus' => 1200, 'train' => 650, 'tour' => 2500];
                    $defaultUnitPrice = $pricingMap[$selectedType] ?? 1200;
                }
            @endphp
            <input type="hidden" name="package_price" id="hiddenUnitPrice" value="{{ $defaultUnitPrice }}">
            <input type="hidden" name="package_title" value="{{ $package ? $package->title : 'Custom Ticket' }}">

            <div class="row g-4">
                <!-- Left Form Column -->
                <div class="col-lg-8">
                    <!-- Selected Service Banner Card -->
                    @if($package)
                        <div class="bg-white rounded-4 border p-4 shadow-sm mb-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                                <span class="badge {{ ($package->type ?? 'tour') === 'flight' ? 'badge-flight' : (($package->type ?? 'tour') === 'bus' ? 'badge-bus' : (($package->type ?? 'tour') === 'train' ? 'badge-train' : 'badge-tour')) }} badge-pill">
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
                            <!-- Trip Mode Selector (One Way vs Round Trip / Return Ticket) -->
                            <div class="col-12 mb-1">
                                <label class="form-label d-block text-secondary small fw-semibold">Journey Type & Return Ticket Option</label>
                                <div class="btn-group w-100" role="group" aria-label="Trip Type">
                                    <input type="radio" class="btn-check" name="trip_mode" id="tripOneWay" value="oneway" {{ empty(old('return_date')) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary py-2 fw-semibold" for="tripOneWay">
                                        <i class='bx bx-right-arrow-alt me-1'></i>One-Way Journey
                                    </label>

                                    <input type="radio" class="btn-check" name="trip_mode" id="tripRoundTrip" value="roundtrip" {{ !empty(old('return_date')) ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary py-2 fw-semibold" for="tripRoundTrip">
                                        <i class='bx bx-refresh me-1'></i>Round-Trip (Include Return Ticket)
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Transport Category <span class="text-danger">*</span></label>
                                <select name="transport_type" class="form-select" id="transportTypeSelect" required>
                                    <option value="flight" {{ (old('transport_type') == 'flight' || ($package->type ?? '') == 'flight') ? 'selected' : '' }}>✈️ Air Flight Express</option>
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
                                    <i class='bx bx-info-circle me-1'></i>Outbound travel departure date
                                </div>
                            </div>

                            <div class="col-md-6" id="returnDateWrapper">
                                <label class="form-label" id="returnDateLabel">Return Date (Return Ticket)</label>
                                <input type="date" class="form-control" name="return_date" id="returnDate"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('return_date') }}">
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                                    <i class='bx bx-refresh me-1'></i>Return journey & ticket departure date
                                </div>
                            </div>

                            <!-- Return Journey Banner Info -->
                            <div class="col-12" id="returnTicketNotice">
                                <div class="alert alert-success border-0 shadow-xs rounded-3 p-3 mb-0 small d-flex align-items-center gap-2">
                                    <i class='bx bxs-check-shield text-success fs-4'></i>
                                    <div>
                                        <strong class="text-dark">Return Ticket Included:</strong>
                                        <span class="text-secondary" id="returnNoticeText">Your reservation includes guaranteed return journey transport back to origin.</span>
                                    </div>
                                </div>
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
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="brand-icon-box" style="width: 32px; height: 32px; font-size: 1.1rem;">
                                    <i class='bx bx-chair'></i>
                                </div>
                                <h5 class="fw-bold mb-0">3. Seats & Cabin Class</h5>
                            </div>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small">
                                Interactive Coach Map
                            </span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Passenger Count <span class="text-danger">*</span></label>
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

                        <!-- Interactive Coach Seat Map Section -->
                        <div class="seat-picker-container p-3 p-md-4 rounded-4 bg-light border">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">Select Your Specific Seat(s)</h6>
                                    <small class="text-secondary">Click on any available seat to reserve your preferred position.</small>
                                </div>
                                <!-- Seat Map Legend -->
                                <div class="d-flex align-items-center gap-3 small">
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="seat-legend-box seat-available"></span>
                                        <span class="text-muted">Available</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="seat-legend-box seat-selected"></span>
                                        <span class="fw-semibold text-primary">Selected</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="seat-legend-box seat-booked"></span>
                                        <span class="text-muted">Occupied</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden input storing comma-separated seat labels -->
                            <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="{{ old('selected_seats', '') }}">

                            <!-- Coach Graphic Wrapper -->
                            <div class="coach-wrapper mx-auto p-3 p-md-4 bg-white rounded-4 border shadow-xs" style="max-width: 440px;">
                                <!-- Driver Cabin Header -->
                                <div class="driver-cabin d-flex justify-content-between align-items-center px-3 py-2 bg-light rounded-3 mb-3 border text-muted small">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class='bx bx-wind text-info'></i>
                                        <span>Front Windscreen</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 text-dark fw-bold">
                                        <i class='bx bx-circle text-primary'></i>
                                        <span>Driver Cabin</span>
                                    </div>
                                </div>

                                <!-- Seat Grid 2x2 with Aisle -->
                                <div class="seat-grid d-flex flex-column gap-2" id="seatGridContainer">
                                    @php
                                        $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                                        $occupiedSeats = ['A3', 'B2', 'C4', 'E1', 'G3', 'H2']; // authentic demo booked seats
                                    @endphp

                                    @foreach($rows as $row)
                                        <div class="seat-row">
                                            <!-- Row Identifier Left -->
                                            <div class="row-label">{{ $row }}</div>

                                            <!-- Left Pair (Window & Aisle) -->
                                            <div class="d-flex gap-1.5">
                                                @php $s1 = $row . '1'; @endphp
                                                <button type="button" class="seat-btn {{ in_array($s1, $occupiedSeats) ? 'occupied' : 'available' }}" data-seat="{{ $s1 }}" title="Seat {{ $s1 }} (Window)">
                                                    {{ $s1 }}
                                                </button>

                                                @php $s2 = $row . '2'; @endphp
                                                <button type="button" class="seat-btn {{ in_array($s2, $occupiedSeats) ? 'occupied' : 'available' }}" data-seat="{{ $s2 }}" title="Seat {{ $s2 }} (Aisle)">
                                                    {{ $s2 }}
                                                </button>
                                            </div>

                                            <!-- Aisle Walkway -->
                                            <div class="aisle-spacer text-muted font-monospace small px-1" style="font-size: 0.65rem;">
                                                <i class='bx bx-walk text-secondary opacity-50'></i>
                                            </div>

                                            <!-- Right Pair (Aisle & Window) -->
                                            <div class="d-flex gap-1.5">
                                                @php $s3 = $row . '3'; @endphp
                                                <button type="button" class="seat-btn {{ in_array($s3, $occupiedSeats) ? 'occupied' : 'available' }}" data-seat="{{ $s3 }}" title="Seat {{ $s3 }} (Aisle)">
                                                    {{ $s3 }}
                                                </button>

                                                @php $s4 = $row . '4'; @endphp
                                                <button type="button" class="seat-btn {{ in_array($s4, $occupiedSeats) ? 'occupied' : 'available' }}" data-seat="{{ $s4 }}" title="Seat {{ $s4 }} (Window)">
                                                    {{ $s4 }}
                                                </button>
                                            </div>

                                            <!-- Row Identifier Right -->
                                            <div class="row-label">{{ $row }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Live Selected Seats Feedback -->
                            <div class="mt-3 p-2.5 rounded-3 bg-white border d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div class="small text-secondary">
                                    <span>Selected Seat(s):</span>
                                    <span class="fw-bold text-primary ms-1" id="selectedSeatsDisplay">Auto-Allocated</span>
                                </div>
                                <button type="button" class="btn btn-link btn-sm p-0 text-muted small text-decoration-none" id="btnClearSeats">
                                    <i class='bx bx-refresh me-1'></i>Reset Map
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sticky Summary Column -->
                <div class="col-lg-4">
                    <!-- 1. Dedicated Promo & Coupon Card -->
                    <div class="bg-white rounded-4 border p-4 shadow-sm mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2 pb-2 border-bottom">
                            <i class='bx bxs-discount text-primary fs-5'></i>
                            <h6 class="fw-bold mb-0 text-dark">Have a Promo Code?</h6>
                        </div>
                        <div class="input-group input-group-sm mb-1.5">
                            <input type="text" class="form-control text-uppercase font-monospace" id="promoCodeInput" placeholder="e.g. STUDENT2026" autocomplete="off">
                            <button type="button" class="btn btn-dark px-3 fw-semibold" id="btnApplyPromo">Apply</button>
                        </div>
                        <div id="promoFeedback" class="small mt-1" style="font-size: 0.725rem;"></div>

                        <!-- Sample Demo Promo Pills for Examiner/User Convenience -->
                        <div class="d-flex flex-wrap gap-1 mt-2">
                            <span class="badge bg-light border text-secondary coupon-pill" onclick="fillPromo('STUDENT2026')">🎓 STUDENT2026 (-20%)</span>
                            <span class="badge bg-light border text-secondary coupon-pill" onclick="fillPromo('ADVANCE15')">🚀 ADVANCE15 (-15%)</span>
                            <span class="badge bg-light border text-secondary coupon-pill" onclick="fillPromo('VIVA500')">🎁 VIVA500 (-৳500)</span>
                        </div>
                        <!-- Hidden input passed to server -->
                        <input type="hidden" name="promo_code" id="appliedPromoCode" value="{{ old('promo_code') }}">
                    </div>

                    <!-- 2. Clean Fare Summary Card -->
                    <div class="booking-summary-card p-4">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom">Fare Breakdown</h5>

                        <div class="d-flex justify-content-between text-secondary small mb-2">
                            <span>Base Ticket Fare</span>
                            <span class="fw-semibold text-dark" id="displayUnitPrice">৳{{ number_format($defaultUnitPrice, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between text-secondary small mb-2">
                            <span>Passenger Count</span>
                            <span class="fw-semibold text-dark" id="displaySeatCount">1 Seat</span>
                        </div>

                        <div class="d-flex justify-content-between text-secondary small mb-2" id="summarySeatsRow" style="display: none !important;">
                            <span>Chosen Seat(s)</span>
                            <span class="badge bg-primary text-white" id="summarySeatsBadge">None</span>
                        </div>

                        <div class="d-flex justify-content-between text-secondary small mb-2" id="summaryTripRow" style="display: none !important;">
                            <span>Journey Type</span>
                            <span class="badge bg-primary text-white" id="summaryTripBadge">One-Way</span>
                        </div>

                        <!-- Promo Code Discount Row (Hidden initially) -->
                        <div class="d-flex justify-content-between text-success small mb-2" id="discountRow" style="display: none;">
                            <span id="discountLabel">Promo Discount</span>
                            <span class="fw-bold" id="discountAmountDisplay">-৳0.00</span>
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
                                ৳{{ number_format($defaultUnitPrice, 2) }}
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
    let selectedSeats = [];
    let appliedPromo = null;
    let discountAmount = 0;

    function fillPromo(code) {
        const input = document.getElementById('promoCodeInput');
        if (input) {
            input.value = code;
            document.getElementById('btnApplyPromo').click();
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const seatsSelect = document.getElementById('seatsSelect');
        const hiddenUnitPrice = document.getElementById('hiddenUnitPrice');
        const displaySeatCount = document.getElementById('displaySeatCount');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const journeyDate = document.getElementById('journeyDate');
        const returnDate = document.getElementById('returnDate');
        const seatBtns = document.querySelectorAll('.seat-btn:not(.occupied)');
        const selectedSeatsInput = document.getElementById('selectedSeatsInput');
        const selectedSeatsDisplay = document.getElementById('selectedSeatsDisplay');
        const summarySeatsRow = document.getElementById('summarySeatsRow');
        const summarySeatsBadge = document.getElementById('summarySeatsBadge');
        const summaryTripRow = document.getElementById('summaryTripRow');
        const summaryTripBadge = document.getElementById('summaryTripBadge');
        const btnClearSeats = document.getElementById('btnClearSeats');
        const btnApplyPromo = document.getElementById('btnApplyPromo');
        const promoCodeInput = document.getElementById('promoCodeInput');
        const promoFeedback = document.getElementById('promoFeedback');
        const discountRow = document.getElementById('discountRow');
        const discountLabel = document.getElementById('discountLabel');
        const discountAmountDisplay = document.getElementById('discountAmountDisplay');
        const appliedPromoCode = document.getElementById('appliedPromoCode');

        const tripOneWay = document.getElementById('tripOneWay');
        const tripRoundTrip = document.getElementById('tripRoundTrip');
        const transportTypeSelect = document.getElementById('transportTypeSelect');
        const returnDateWrapper = document.getElementById('returnDateWrapper');
        const returnTicketNotice = document.getElementById('returnTicketNotice');
        const returnNoticeText = document.getElementById('returnNoticeText');
        const fromCityBooking = document.getElementById('fromCityBooking');
        const toCityBooking = document.getElementById('toCityBooking');

        // Parse any old values
        if (selectedSeatsInput.value) {
            selectedSeats = selectedSeatsInput.value.split(',').map(s => s.trim()).filter(Boolean);
            renderSelectedSeats();
        }

        const isCustomPackage = {{ ($package && !empty($package->id)) ? 'false' : 'true' }};
        const defaultCategoryPrices = {
            flight: 3800,
            bus: 1200,
            train: 650,
            tour: 2500
        };

        function syncTripMode() {
            const isRound = tripRoundTrip && tripRoundTrip.checked;
            const transportType = transportTypeSelect ? transportTypeSelect.value : 'bus';
            const origin = fromCityBooking && fromCityBooking.value ? fromCityBooking.value : 'Departure City';
            const destination = toCityBooking && toCityBooking.value ? toCityBooking.value : 'Destination';

            // If user is booking a custom service (not a preset package), adjust price according to transport category
            if (isCustomPackage && transportTypeSelect) {
                const catPrice = defaultCategoryPrices[transportType] || 1200;
                if (hiddenUnitPrice) hiddenUnitPrice.value = catPrice;
                const displayUnitPrice = document.getElementById('displayUnitPrice');
                if (displayUnitPrice) {
                    displayUnitPrice.innerText = `৳${catPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                }
            }

            if (isRound || transportType === 'tour') {
                if (returnDateWrapper) returnDateWrapper.style.display = 'block';
                if (returnTicketNotice) returnTicketNotice.style.display = 'block';

                if (transportType === 'tour') {
                    if (returnNoticeText) {
                        returnNoticeText.innerHTML = `<strong>Holiday Tour Round-Trip:</strong> Includes outbound journey & return transport back to <strong>${origin}</strong>.`;
                    }
                    if (summaryTripRow && summaryTripBadge) {
                        summaryTripRow.style.removeProperty('display');
                        summaryTripBadge.className = 'badge bg-success text-white';
                        summaryTripBadge.innerText = 'Tour Package (Round-Trip Included)';
                    }
                } else {
                    if (returnNoticeText) {
                        returnNoticeText.innerHTML = `<strong>Round-Trip Ticket:</strong> Guaranteed return journey pass from <strong>${destination}</strong> ➔ <strong>${origin}</strong>.`;
                    }
                    if (summaryTripRow && summaryTripBadge) {
                        summaryTripRow.style.removeProperty('display');
                        summaryTripBadge.className = 'badge bg-primary text-white';
                        summaryTripBadge.innerText = 'Round-Trip (Return Ticket)';
                    }
                }

                // If return date is empty, set default return date based on journey date
                if (journeyDate && journeyDate.value && returnDate && !returnDate.value) {
                    const dt = new Date(journeyDate.value);
                    dt.setDate(dt.getDate() + (transportType === 'tour' ? 3 : 1));
                    returnDate.value = dt.toISOString().split('T')[0];
                }
            } else {
                if (returnNoticeText) {
                    returnNoticeText.innerHTML = 'One-Way journey ticket.';
                }
                if (summaryTripRow) {
                    summaryTripRow.style.setProperty('display', 'none', 'important');
                }
            }

            updateTotal();
        }

        function calculateDiscount(baseTotal) {
            if (!appliedPromo) return 0;
            if (appliedPromo === 'ADVANCE15') {
                return baseTotal * 0.15;
            } else if (appliedPromo === 'STUDENT2026') {
                return baseTotal * 0.20;
            } else if (appliedPromo === 'VIVA500') {
                return Math.min(baseTotal, 500);
            }
            return 0;
        }

        function updateTotal() {
            const seats = parseInt(seatsSelect.value) || 1;
            const unitPrice = parseFloat(hiddenUnitPrice.value) || 1000;
            const isRound = tripRoundTrip && tripRoundTrip.checked;
            const transportType = transportTypeSelect ? transportTypeSelect.value : 'bus';

            // Bus/Train round trips count 2x journeys (outbound + return ticket)
            const multiplier = (transportType !== 'tour' && isRound) ? 2 : 1;
            const baseTotal = seats * unitPrice * multiplier;

            discountAmount = calculateDiscount(baseTotal);
            const netTotal = Math.max(0, baseTotal - discountAmount);

            if (displaySeatCount) {
                displaySeatCount.innerText = `${seats} ${seats === 1 ? 'Seat' : 'Seats'}${multiplier > 1 ? ' (Round-Trip)' : ''}`;
            }

            if (discountRow) {
                if (discountAmount > 0) {
                    discountRow.style.display = 'flex';
                    discountLabel.innerText = `Discount (${appliedPromo})`;
                    discountAmountDisplay.innerText = `-৳${discountAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                } else {
                    discountRow.style.display = 'none';
                }
            }

            if (totalPriceDisplay) {
                totalPriceDisplay.innerText = `৳${netTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }
        }

        function renderSelectedSeats() {
            // Update button visual styles
            seatBtns.forEach(btn => {
                const seat = btn.getAttribute('data-seat');
                if (selectedSeats.includes(seat)) {
                    btn.classList.add('selected');
                } else {
                    btn.classList.remove('selected');
                }
            });

            // Update displays
            if (selectedSeats.length > 0) {
                selectedSeatsInput.value = selectedSeats.join(', ');
                selectedSeatsDisplay.innerText = selectedSeats.join(', ');
                if (summarySeatsRow && summarySeatsBadge) {
                    summarySeatsRow.style.removeProperty('display');
                    summarySeatsBadge.innerText = selectedSeats.join(', ');
                }
            } else {
                selectedSeatsInput.value = '';
                selectedSeatsDisplay.innerText = 'Auto-Allocated';
                if (summarySeatsRow) {
                    summarySeatsRow.style.setProperty('display', 'none', 'important');
                }
            }
        }

        // Seat Click Handler
        seatBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const seat = this.getAttribute('data-seat');
                const allowedCount = parseInt(seatsSelect.value) || 1;

                if (selectedSeats.includes(seat)) {
                    // Deselect
                    selectedSeats = selectedSeats.filter(s => s !== seat);
                } else {
                    // If we haven't reached selected count, add
                    if (selectedSeats.length < allowedCount) {
                        selectedSeats.push(seat);
                    } else if (allowedCount === 1) {
                        // If single passenger, replace seat
                        selectedSeats = [seat];
                    } else {
                        // Increase passenger count automatically up to 10!
                        if (allowedCount < 10) {
                            seatsSelect.value = allowedCount + 1;
                            selectedSeats.push(seat);
                            updateTotal();
                        } else {
                            alert(`Maximum ${allowedCount} seats allowed for this booking.`);
                            return;
                        }
                    }
                }

                // If user selected more seats than select dropdown, increase dropdown
                if (selectedSeats.length > allowedCount && selectedSeats.length <= 10) {
                    seatsSelect.value = selectedSeats.length;
                    updateTotal();
                }

                renderSelectedSeats();
            });
        });

        // Clear Seats
        if (btnClearSeats) {
            btnClearSeats.addEventListener('click', function() {
                selectedSeats = [];
                renderSelectedSeats();
            });
        }

        // Seats Select Dropdown Change
        if (seatsSelect) {
            seatsSelect.addEventListener('change', function() {
                const count = parseInt(this.value);
                if (selectedSeats.length > count) {
                    selectedSeats = selectedSeats.slice(0, count);
                    renderSelectedSeats();
                }
                updateTotal();
            });
        }

        // Promo Code Application
        if (btnApplyPromo) {
            btnApplyPromo.addEventListener('click', function() {
                const code = promoCodeInput.value.trim().toUpperCase();
                if (!code) {
                    promoFeedback.innerHTML = '<span class="text-danger">Please enter a promo code.</span>';
                    return;
                }

                if (code === 'ADVANCE15') {
                    appliedPromo = 'ADVANCE15';
                    appliedPromoCode.value = 'ADVANCE15';
                    promoFeedback.innerHTML = '<span class="text-success fw-bold"><i class="bx bx-check-circle"></i> 15% Discount Applied!</span>';
                } else if (code === 'STUDENT2026') {
                    appliedPromo = 'STUDENT2026';
                    appliedPromoCode.value = 'STUDENT2026';
                    promoFeedback.innerHTML = '<span class="text-success fw-bold"><i class="bx bx-check-circle"></i> 20% University Student Discount Applied!</span>';
                } else if (code === 'VIVA500') {
                    appliedPromo = 'VIVA500';
                    appliedPromoCode.value = 'VIVA500';
                    promoFeedback.innerHTML = '<span class="text-success fw-bold"><i class="bx bx-check-circle"></i> ৳500 Flat Capstone Discount Applied!</span>';
                } else {
                    promoFeedback.innerHTML = '<span class="text-danger"><i class="bx bx-error-circle"></i> Invalid coupon. Try STUDENT2026 or ADVANCE15</span>';
                    appliedPromo = null;
                    appliedPromoCode.value = '';
                }

                updateTotal();
            });
        }

        // Date synchronizer
        if (journeyDate && returnDate) {
            journeyDate.addEventListener('change', function() {
                returnDate.min = this.value;
                if (returnDate.value && returnDate.value < this.value) {
                    returnDate.value = this.value;
                }
                syncTripMode();
            });
            returnDate.addEventListener('change', function() {
                if (this.value && tripRoundTrip) {
                    tripRoundTrip.checked = true;
                    syncTripMode();
                }
            });
        }

        if (tripOneWay) tripOneWay.addEventListener('change', syncTripMode);
        if (tripRoundTrip) tripRoundTrip.addEventListener('change', syncTripMode);
        if (transportTypeSelect) transportTypeSelect.addEventListener('change', syncTripMode);
        if (fromCityBooking) fromCityBooking.addEventListener('change', syncTripMode);
        if (toCityBooking) toCityBooking.addEventListener('change', syncTripMode);

        // Initial setup
        syncTripMode();
    });
</script>
@endpush

@endsection

