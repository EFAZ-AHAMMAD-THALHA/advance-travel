@extends('layouts.app')

@section('title', 'Advance Travel & Tourism | Smart Bus, Train & Tour Booking Platform')

@section('content')

<!-- MODERN HERO SECTION -->
<section class="modern-hero">
    <div class="hero-glow"></div>
    <div class="hero-glow-secondary"></div>

    <div class="container-xl position-relative" style="z-index: 2;">
        <div class="row align-items-center justify-content-between g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 text-white small fw-bold mb-4 shadow-sm">
                    <span class="badge bg-primary text-white rounded-pill px-2 py-0.5">NEW</span>
                    <span>Multi-Modal Intelligent Travel Ticketing System</span>
                </div>

                <h1 class="display-4 fw-extrabold text-white mb-3" style="letter-spacing: -0.03em; line-height: 1.15;">
                    Travel Across Bangladesh with <span style="background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Ease & Confidence</span>
                </h1>

                <p class="lead text-slate-300 mb-4 pe-lg-5" style="color: #cbd5e1; font-size: 1.15rem; line-height: 1.6;">
                    Reserve confirmed seats on top-tier AC buses, intercity express trains, and all-inclusive holiday packages with real-time seat availability and instant e-ticket issuance.
                </p>

                <!-- Hero Action Buttons -->
                <div class="d-flex flex-wrap gap-3 mb-4 justify-content-center justify-content-lg-start">
                    <a href="{{ route('explore') }}" class="btn btn-primary-gradient btn-lg px-4 py-2.5 rounded-pill shadow-lg d-inline-flex align-items-center gap-2">
                        <i class='bx bx-compass fs-4'></i>
                        <span class="fw-bold">Explore All Trips</span>
                    </a>
                    <a href="{{ route('booking') }}" class="btn btn-outline-light btn-lg px-4 py-2.5 rounded-pill d-inline-flex align-items-center gap-2">
                        <i class='bx bx-calendar-check fs-4'></i>
                        <span>Book a Journey</span>
                    </a>
                </div>

                <!-- Trust Stats Pill Bar -->
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-4 pt-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class='bx bxs-check-shield fs-4 text-warning'></i>
                        <div class="text-start">
                            <div class="fw-bold text-white small">100% Verified</div>
                            <div class="small text-secondary" style="font-size: 0.75rem;">Licensed Fleets</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class='bx bxs-zap fs-4 text-info'></i>
                        <div class="text-start">
                            <div class="fw-bold text-white small">Instant Ticket</div>
                            <div class="small text-secondary" style="font-size: 0.75rem;">SMS & Boarding Pass</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class='bx bxs-refresh fs-4 text-success'></i>
                        <div class="text-start">
                            <div class="fw-bold text-white small">Easy Refunds</div>
                            <div class="small text-secondary" style="font-size: 0.75rem;">Hassle-Free Policy</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Visual / Quick Actions Card -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="glass-radar-card p-4 rounded-4 shadow-2xl position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge badge-neon-success rounded-pill px-3 py-1.5 fw-bold d-flex align-items-center gap-1.5">
                                <span class="beacon-dot"></span>
                                <i class='bx bx-radar me-0.5'></i>Live Flight & Fleet Radar
                            </span>
                            <button id="btnRefreshFlightStatus" class="btn btn-xs btn-outline-light rounded-circle p-1" title="Refresh Live Flight Status">
                                <i class='bx bx-refresh fs-6'></i>
                            </button>
                        </div>
                        <span id="flightLastUpdatedText" class="text-white-50 small" style="font-size: 0.72rem;">
                            <i class='bx bx-time-five me-1'></i>Updated Live
                        </span>
                    </div>

                    <!-- Live Flight Quick Search Bar -->
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text bg-white bg-opacity-10 text-info border-white border-opacity-15">
                            <i class='bx bxs-plane-alt'></i>
                        </span>
                        <input type="text" id="flightSearchInput" class="form-control bg-white bg-opacity-10 text-white border-white border-opacity-15 placeholder-white-50" placeholder="Search Flight No. (e.g. BG-401, BS-201)..." style="font-size: 0.8rem;">
                        <button id="btnSearchFlight" class="btn btn-primary btn-sm px-3 fw-bold shadow-sm" type="button">
                            <i class='bx bx-search-alt me-0.5'></i>Status
                        </button>
                    </div>

                    <!-- Dynamic Live Status Container -->
                    <div id="liveFlightStatusContainer" style="min-height: 220px;">
                        <div class="p-4 text-center text-white-50">
                            <i class='bx bx-loader-alt bx-spin fs-2 mb-2 text-info d-block'></i>
                            <span class="small">Connecting to live flight radar...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SMART SEARCH & FILTER WIDGET -->
<div class="container-xl" id="heroSearchForm">
    <div class="search-widget-card">
        <form action="{{ route('explore') }}" method="GET">
            <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3 mb-3 gap-2">
                <div class="search-tabs">
                    <ul class="nav nav-pills gap-2" role="tablist">
                        <li class="nav-item">
                            <input type="radio" class="btn-check" name="type" id="searchAll" value="all" checked>
                            <label class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" for="searchAll">
                                <i class='bx bx-grid-alt me-1'></i>All Modes
                            </label>
                        </li>
                        <li class="nav-item">
                            <input type="radio" class="btn-check" name="type" id="searchFlight" value="flight">
                            <label class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" for="searchFlight">
                                <i class='bx bxs-plane-alt me-1'></i>Air Flight
                            </label>
                        </li>
                        <li class="nav-item">
                            <input type="radio" class="btn-check" name="type" id="searchBus" value="bus">
                            <label class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" for="searchBus">
                                <i class='bx bx-bus me-1'></i>Luxury Bus
                            </label>
                        </li>
                        <li class="nav-item">
                            <input type="radio" class="btn-check" name="type" id="searchTrain" value="train">
                            <label class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" for="searchTrain">
                                <i class='bx bx-train me-1'></i>Express Train
                            </label>
                        </li>
                        <li class="nav-item">
                            <input type="radio" class="btn-check" name="type" id="searchTour" value="tour">
                            <label class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" for="searchTour">
                                <i class='bx bx-sun me-1'></i>Holiday Packages
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="text-muted small fw-medium">
                    <i class='bx bx-shield-quarter text-success me-1 align-middle'></i>Guaranteed Seat Allocation
                </div>
            </div>

            <div class="row g-3 align-items-end">
                <!-- From (Departure) with Dropdown Suggestions -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label d-flex justify-content-between align-items-center">
                        <span><i class='bx bx-radio-circle-marked text-primary me-1'></i>From (Departure)</span>
                        <span class="text-primary small" style="font-size: 0.72rem; cursor: pointer;" onclick="document.getElementById('fromInput').focus()">Suggestions ▼</span>
                    </label>
                    <div class="city-autocomplete-wrapper">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-primary border-end-0"><i class='bx bxs-navigation'></i></span>
                            <input type="text" name="from" id="fromInput" class="form-control border-start-0 city-search-input" 
                                   placeholder="Select or type departure..." autocomplete="off" value="{{ request('from', 'Dhaka') }}"
                                   data-dropdown="fromDropdownHome">
                            <button type="button" class="btn btn-light border border-start-0 text-muted city-dropdown-trigger" data-target="fromDropdownHome">
                                <i class='bx bx-chevron-down'></i>
                            </button>
                        </div>
                        <div class="city-suggestion-menu" id="fromDropdownHome">
                            <div class="p-2 border-bottom bg-light d-flex justify-content-between align-items-center">
                                <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.7rem;">Popular Departure Hubs</span>
                                <span class="badge bg-primary-subtle text-primary rounded-pill" style="font-size: 0.65rem;">Top Fleets</span>
                            </div>
                            <div class="city-suggestion-list"></div>
                        </div>
                    </div>
                </div>

                <!-- To (Destination) with Dropdown Suggestions & Swap -->
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">
                            <i class='bx bxs-map-pin text-danger me-1'></i>To (Destination)
                        </label>
                        <button type="button" class="btn btn-link text-primary p-0 text-decoration-none small fw-semibold d-inline-flex align-items-center gap-1" onclick="swapCities('fromInput', 'toInput')" title="Swap Origin & Destination">
                            <i class='bx bx-transfer-alt'></i> Swap
                        </button>
                    </div>
                    <div class="city-autocomplete-wrapper">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-danger border-end-0"><i class='bx bxs-map'></i></span>
                            <input type="text" name="to" id="toInput" class="form-control border-start-0 city-search-input" 
                                   placeholder="Select or type destination..." autocomplete="off" value="{{ request('to') }}"
                                   data-dropdown="toDropdownHome">
                            <button type="button" class="btn btn-light border border-start-0 text-muted city-dropdown-trigger" data-target="toDropdownHome">
                                <i class='bx bx-chevron-down'></i>
                            </button>
                        </div>
                        <div class="city-suggestion-menu" id="toDropdownHome">
                            <div class="p-2 border-bottom bg-light d-flex justify-content-between align-items-center">
                                <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.7rem;">Popular Destinations</span>
                                <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.65rem;">Hot Routes</span>
                            </div>
                            <div class="city-suggestion-list"></div>
                        </div>
                    </div>
                </div>

                <!-- Max Budget Range -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">
                        <i class='bx bx-wallet text-success me-1'></i>Max Budget: ৳<span id="priceDisplay">15,000</span>
                    </label>
                    <input type="range" name="max_price" class="form-range" min="500" max="30000" step="500" value="15000"
                           oninput="document.getElementById('priceDisplay').innerText = parseInt(this.value).toLocaleString()">
                </div>

                <!-- Submit Button -->
                <div class="col-lg-3 col-md-6">
                    <button type="submit" class="btn btn-primary-gradient w-100 py-2.5">
                        <i class='bx bx-search-alt-2 fs-5'></i>
                        <span>Search Tickets</span>
                    </button>
                </div>
            </div>

            <!-- Quick Popular Route Chips -->
            <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top small text-secondary">
                <span class="fw-bold text-dark"><i class='bx bx-trending-up text-primary me-1'></i>Popular Routes:</span>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-0.5 small fw-medium" onclick="setQuickRoute('Dhaka', 'Cox\'s Bazar')">
                    Dhaka ➔ Cox's Bazar
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-0.5 small fw-medium" onclick="setQuickRoute('Dhaka', 'Sylhet')">
                    Dhaka ➔ Sylhet
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-0.5 small fw-medium" onclick="setQuickRoute('Dhaka', 'Chattogram')">
                    Dhaka ➔ Chattogram
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-0.5 small fw-medium" onclick="setQuickRoute('Dhaka', 'Sajek Valley')">
                    Dhaka ➔ Sajek Valley
                </button>
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-0.5 small fw-medium" onclick="setQuickRoute('Dhaka', 'Rajshahi')">
                    Dhaka ➔ Rajshahi
                </button>
            </div>

        </form>
    </div>
</div>

<!-- FEATURE HIGHLIGHTS -->
<section class="py-5 my-3">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon-wrapper">
                        <i class='bx bx-bus-school'></i>
                    </div>
                    <h5 class="fw-bold mb-2">Verified Fleets</h5>
                    <p class="text-secondary small mb-0">
                        Top operators including Green Line, Hanif, Shohagh, and Bangladesh Railway certified coaches.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon-wrapper">
                        <i class='bx bx-check-double'></i>
                    </div>
                    <h5 class="fw-bold mb-2">Instant Seat Lock</h5>
                    <p class="text-secondary small mb-0">
                        Select your preferred seats in real-time with zero double-booking or allocation latency.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon-wrapper">
                        <i class='bx bx-refresh'></i>
                    </div>
                    <h5 class="fw-bold mb-2">Easy Cancellation</h5>
                    <p class="text-secondary small mb-0">
                        Plans changed? Cancel your ticket effortlessly from your user portal with quick refund approval.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-icon-wrapper">
                        <i class='bx bx-support'></i>
                    </div>
                    <h5 class="fw-bold mb-2">24/7 Care</h5>
                    <p class="text-secondary small mb-0">
                        Dedicated passenger support hotline ready to assist with routing, stations, and luggage inquiries.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- POPULAR BUS & TRAIN SERVICES -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container-xl">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
            <div>
                <span class="badge badge-pill badge-bus mb-2">
                    <i class='bx bx-trending-up'></i> High Demand
                </span>
                <h2 class="fw-bold mb-1">Popular Flights, Buses & Trains</h2>
                <p class="text-secondary small mb-0">Daily scheduled departures connecting major divisions, airports, and tourist hubs</p>
            </div>
            <a href="{{ route('explore') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold">
                Explore All Fleet <i class='bx bx-right-arrow-alt align-middle'></i>
            </a>
        </div>

        <div class="row g-4">
            @php
                $flightsToDisplay = ($featuredFlights ?? collect())->take(2);
                $busesToDisplay = ($featuredBuses ?? collect())->take(2);
                $trainsToDisplay = ($featuredTrains ?? collect())->take(2);
                $popularTransit = $flightsToDisplay->concat($busesToDisplay)->concat($trainsToDisplay);
            @endphp
            @forelse($popularTransit as $ticket)
                <div class="col-lg-4 col-md-6">
                    <div class="travel-card">
                        <div class="travel-card-img-wrap">
                            <img src="{{ $ticket->image_url }}" alt="{{ $ticket->title }}">
                            
                            <div class="travel-card-badge">
                                @if($ticket->type === 'flight')
                                    <span class="badge badge-pill badge-flight"><i class='bx bxs-plane-alt'></i> Flight</span>
                                @elseif($ticket->type === 'bus')
                                    <span class="badge badge-pill badge-bus"><i class='bx bx-bus'></i> Bus</span>
                                @elseif($ticket->type === 'train')
                                    <span class="badge badge-pill badge-train"><i class='bx bx-train'></i> Train</span>
                                @else
                                    <span class="badge badge-pill badge-tour"><i class='bx bx-map-pin'></i> Tour</span>
                                @endif
                            </div>

                            <div class="travel-card-price">
                                ৳{{ number_format($ticket->price, 0) }}
                            </div>
                        </div>

                        <div class="travel-card-body">
                            <div class="d-flex align-items-center gap-1 text-secondary small fw-semibold mb-2">
                                <i class='bx bxs-map-pin text-primary'></i>
                                <span>{{ $ticket->from_location ?? 'Dhaka' }}</span>
                                <i class='bx bx-right-arrow-alt mx-1'></i>
                                <span>{{ $ticket->to_location ?? $ticket->location }}</span>
                            </div>

                            <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $ticket->title }}">
                                {{ $ticket->title }}
                            </h5>

                            <div class="d-flex justify-content-between align-items-center text-secondary small mb-3 pb-2 border-bottom">
                                <span><i class='bx bx-time me-1'></i>{{ $ticket->departure_time ?? '08:00 AM' }}</span>
                                <span class="badge bg-success-subtle text-success rounded-pill fw-bold">
                                    <i class='bx bx-check-circle me-1'></i>Available
                                </span>
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('booking', ['package_id' => $ticket->id]) }}" class="btn btn-primary-gradient w-100 py-2">
                                    <span>Book Seat</span>
                                    <i class='bx bx-arrow-to-right'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class='bx bx-bus fs-1 text-slate-400 mb-2'></i>
                    <p class="text-secondary">Services are currently being updated by the transport authority.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- FEATURED HOLIDAY PACKAGES -->
<section class="py-5" id="packages">
    <div class="container-xl">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
            <div>
                <span class="badge badge-pill badge-tour mb-2">
                    <i class='bx bx-sun'></i> Vacation Deals
                </span>
                <h2 class="fw-bold mb-1">Curated Holiday Packages</h2>
                <p class="text-secondary small mb-0">All-inclusive transport, luxury resort stays, and guided excursions</p>
            </div>
            <a href="{{ route('package') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold">
                View All Packages <i class='bx bx-right-arrow-alt align-middle'></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($featuredPackages->take(3) as $pkg)
                <div class="col-lg-4 col-md-6">
                    <div class="travel-card">
                        <div class="travel-card-img-wrap">
                            <img src="{{ $pkg->image_url }}" alt="{{ $pkg->title }}">
                            
                            <div class="travel-card-badge">
                                <span class="badge badge-pill badge-tour"><i class='bx bx-star'></i> Tour</span>
                            </div>

                            <div class="travel-card-price">
                                ৳{{ number_format($pkg->price, 0) }}
                            </div>
                        </div>

                        <div class="travel-card-body">
                            <div class="d-flex align-items-center gap-1 text-secondary small fw-semibold mb-2">
                                <i class='bx bxs-map text-success'></i>
                                <span>{{ $pkg->to_location ?? $pkg->location }}</span>
                            </div>

                            <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $pkg->title }}">
                                {{ $pkg->title }}
                            </h5>

                            <p class="text-secondary small mb-3 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $pkg->description ?? 'Experience an unforgettable getaway with all premium transport, meals, and deluxe lodging included.' }}
                            </p>

                            <div class="mt-auto pt-2 border-top">
                                <a href="{{ route('booking', ['package_id' => $pkg->id]) }}" class="btn btn-outline-primary w-100 rounded-3 py-2 fw-semibold">
                                    Reserve Package
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-secondary">Tour packages will appear here once published.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- POPULAR DESTINATIONS SHOWCASE -->
<section class="py-5 bg-white border-top">
    <div class="container-xl">
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 650px; margin: 0 auto;">
            <span class="badge badge-pill badge-tour mb-2">Bangladesh Wonders</span>
            <h2 class="fw-bold mb-2">Iconic Destinations to Explore</h2>
            <p class="text-secondary small">From the longest unbroken sandy sea beach to the mystical cloud-covered hills of Sajek.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-6">
                <div class="travel-card text-center p-3 h-100 position-relative shadow-sm rounded-4 border overflow-hidden d-flex flex-column" 
                     onclick="selectDestination('Cox\'s Bazar', event)" 
                     style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="travel-card-img-wrap rounded-4 mb-3" style="aspect-ratio: 1/1; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" alt="Cox's Bazar" class="w-100 h-100 object-fit-cover">
                    </div>
                    <h6 class="fw-bold mb-1 text-dark">Cox's Bazar</h6>
                    <div class="text-secondary small mb-3">120km Golden Beach</div>
                    <div class="mt-auto d-flex flex-column gap-1">
                        <button type="button" class="btn btn-sm btn-primary-gradient rounded-pill px-3 fw-bold w-100 shadow-sm" 
                                onclick="selectDestination('Cox\'s Bazar', event)">
                            <i class='bx bxs-map-pin me-1'></i>Select Destination
                        </button>
                        <a href="{{ route('explore', ['to' => 'Cox\'s Bazar']) }}" 
                           class="btn btn-sm btn-link text-decoration-none small text-muted py-1" 
                           onclick="event.stopPropagation()">
                            View All Trips <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <div class="travel-card text-center p-3 h-100 position-relative shadow-sm rounded-4 border overflow-hidden d-flex flex-column" 
                     onclick="selectDestination('Sajek Valley', event)" 
                     style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="travel-card-img-wrap rounded-4 mb-3" style="aspect-ratio: 1/1; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=600&q=80" alt="Sajek Valley" class="w-100 h-100 object-fit-cover">
                    </div>
                    <h6 class="fw-bold mb-1 text-dark">Sajek Valley</h6>
                    <div class="text-secondary small mb-3">Kingdom of Clouds</div>
                    <div class="mt-auto d-flex flex-column gap-1">
                        <button type="button" class="btn btn-sm btn-primary-gradient rounded-pill px-3 fw-bold w-100 shadow-sm" 
                                onclick="selectDestination('Sajek Valley', event)">
                            <i class='bx bxs-map-pin me-1'></i>Select Destination
                        </button>
                        <a href="{{ route('explore', ['to' => 'Sajek']) }}" 
                           class="btn btn-sm btn-link text-decoration-none small text-muted py-1" 
                           onclick="event.stopPropagation()">
                            View All Trips <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <div class="travel-card text-center p-3 h-100 position-relative shadow-sm rounded-4 border overflow-hidden d-flex flex-column" 
                     onclick="selectDestination('Sylhet', event)" 
                     style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="travel-card-img-wrap rounded-4 mb-3" style="aspect-ratio: 1/1; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=600&q=80" alt="Sylhet" class="w-100 h-100 object-fit-cover">
                    </div>
                    <h6 class="fw-bold mb-1 text-dark">Sylhet</h6>
                    <div class="text-secondary small mb-3">Lush Tea Gardens & Ratargul</div>
                    <div class="mt-auto d-flex flex-column gap-1">
                        <button type="button" class="btn btn-sm btn-primary-gradient rounded-pill px-3 fw-bold w-100 shadow-sm" 
                                onclick="selectDestination('Sylhet', event)">
                            <i class='bx bxs-map-pin me-1'></i>Select Destination
                        </button>
                        <a href="{{ route('explore', ['to' => 'Sylhet']) }}" 
                           class="btn btn-sm btn-link text-decoration-none small text-muted py-1" 
                           onclick="event.stopPropagation()">
                            View All Trips <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <div class="travel-card text-center p-3 h-100 position-relative shadow-sm rounded-4 border overflow-hidden d-flex flex-column" 
                     onclick="selectDestination('Sundarbans', event)" 
                     style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div class="travel-card-img-wrap rounded-4 mb-3" style="aspect-ratio: 1/1; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1518495973542-4542c06a5843?auto=format&fit=crop&w=600&q=80" alt="Sundarbans" class="w-100 h-100 object-fit-cover">
                    </div>
                    <h6 class="fw-bold mb-1 text-dark">Sundarbans</h6>
                    <div class="text-secondary small mb-3">World Heritage Mangrove</div>
                    <div class="mt-auto d-flex flex-column gap-1">
                        <button type="button" class="btn btn-sm btn-primary-gradient rounded-pill px-3 fw-bold w-100 shadow-sm" 
                                onclick="selectDestination('Sundarbans', event)">
                            <i class='bx bxs-map-pin me-1'></i>Select Destination
                        </button>
                        <a href="{{ route('explore', ['to' => 'Khulna']) }}" 
                           class="btn btn-sm btn-link text-decoration-none small text-muted py-1" 
                           onclick="event.stopPropagation()">
                            View All Trips <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
    <div class="container-xl text-center py-4">
        <h2 class="display-6 fw-bold text-white mb-3">Ready to Embark on Your Next Adventure?</h2>
        <p class="text-slate-300 mb-4 mx-auto" style="max-width: 600px; color: #cbd5e1;">
            Join over 50,000 satisfied travelers. Sign in or register in 30 seconds and secure your digital boarding pass instantly.
        </p>
        <div class="d-flex justify-content-center flex-wrap gap-3">
            <a href="{{ route('explore') }}" class="btn btn-primary-gradient px-4 py-2.5 rounded-pill fw-bold">
                <i class='bx bx-search'></i> Find Your Ticket
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-light px-4 py-2.5 rounded-pill fw-bold">
                Create Free Account
            </a>
        </div>
    </div>
</section>

<!-- LIVE FLIGHT TELEMETRY RADAR MODAL -->
<div class="modal fade telemetry-hud-modal" id="liveFlightModal" tabindex="-1" aria-labelledby="modalFlightTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden" style="background: #090d16; color: #ffffff;">
            <!-- Modal Header -->
            <div class="modal-header border-bottom border-white border-opacity-10 p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="brand-icon-box bg-primary text-white" style="width: 44px; height: 44px; font-size: 1.4rem;">
                        <i class='bx bxs-plane-alt'></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="modal-title fw-bold text-white mb-0" id="modalFlightTitle">Flight Telemetry</h5>
                            <span id="modalFlightStatusBadge" class="badge bg-success rounded-pill px-3 py-1">ON TIME</span>
                        </div>
                        <small class="text-white-50" id="modalFlightRoute">Dhaka (DAC) ➔ Cox's Bazar (CXB)</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <!-- Flight Progress Tracker Bar -->
                <div class="p-3 bg-white bg-opacity-10 rounded-3 mb-4 border border-white border-opacity-10">
                    <div class="d-flex justify-content-between text-white-50 small mb-1">
                        <span><i class='bx bx-radio-circle-marked text-success me-1'></i>Departed: <strong class="text-white" id="modalDepTime">10:15 AM</strong></span>
                        <span><i class='bx bx-flag text-info me-1'></i>Est. Arrival: <strong class="text-white" id="modalArrTime">11:15 AM</strong></span>
                    </div>
                    <div class="progress position-relative my-2" style="height: 10px; background: rgba(255,255,255,0.15);">
                        <div id="modalFlightProgressBar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 45%"></div>
                    </div>
                    <div class="d-flex justify-content-between text-white-50" style="font-size: 0.75rem;">
                        <span id="modalAircraft">Boeing 787-9 Dreamliner</span>
                        <span id="modalSeatsLeft" class="text-success fw-bold">14 seats available</span>
                    </div>
                </div>

                <!-- Telemetry Metrics Grid -->
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3 text-center border border-white border-opacity-10">
                            <small class="text-white-50 d-block mb-1 font-mono">Terminal / Gate</small>
                            <span class="fw-bold text-info fs-6" id="modalGate">T2 / G04</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3 text-center border border-white border-opacity-10">
                            <small class="text-white-50 d-block mb-1 font-mono">Current Altitude</small>
                            <span class="fw-bold text-success fs-6" id="modalAltitude">28,500 ft</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3 text-center border border-white border-opacity-10">
                            <small class="text-white-50 d-block mb-1 font-mono">Air Speed</small>
                            <span class="fw-bold text-warning fs-6" id="modalSpeed">740 km/h</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-3 bg-white bg-opacity-10 rounded-3 text-center border border-white border-opacity-10">
                            <small class="text-white-50 d-block mb-1 font-mono">GPS Radar Sync</small>
                            <span class="fw-bold text-primary fs-6"><i class='bx bx-radar bx-spin text-danger me-1'></i>ACTIVE</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer Action Buttons -->
            <div class="modal-footer border-top border-white border-opacity-10 p-3 bg-dark bg-opacity-50">
                <button type="button" class="btn btn-outline-light px-4 rounded-pill" data-bs-dismiss="modal">Close Radar</button>
                <a id="modalBookFlightBtn" href="/booking" class="btn btn-success px-4 rounded-pill fw-bold">
                    <i class='bx bx-check-circle me-1'></i> Book Flight Now
                </a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/live-flight-tracker.js') }}"></script>
@endsection
