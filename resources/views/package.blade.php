@extends('layouts.app')

@section('title', 'Holiday Tour Packages | Advance Travel & Tourism')

@section('content')

<div class="py-5 bg-slate-50">
    <div class="container-xl">

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 700px; margin: 0 auto;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tour Packages</li>
                </ol>
            </nav>
            <span class="badge badge-pill badge-tour mb-2">Curated Experiences</span>
            <h1 class="display-6 fw-bold mb-2">Top Stays & Guided Holiday Packages</h1>
            <p class="text-secondary small">
                Hand-picked domestic retreats and international vacation getaways with guaranteed accommodations and verified itineraries.
            </p>
        </div>

        <!-- Promo Banner -->
        <div class="rounded-4 p-4 mb-5 text-white position-relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
            <div class="row align-items-center justify-content-between g-3 position-relative" style="z-index: 2;">
                <div class="col-md-8">
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold small text-uppercase mb-2">
                        🔥 Special Discount
                    </span>
                    <h4 class="fw-bold mb-1">Get 15% Off Your Next Group Tour</h4>
                    <p class="small text-white-50 mb-0">Use promo code <strong class="text-white">ADVANCE15</strong> at checkout for instant deduction on all weekend packages.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('explore', ['type' => 'tour']) }}" class="btn btn-warning px-4 py-2 rounded-pill fw-bold text-dark shadow-sm">
                        View All Deals
                    </a>
                </div>
            </div>
        </div>

        <!-- DYNAMIC DATABASE PACKAGES -->
        @if(isset($packages) && $packages->count() > 0)
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold fs-4 mb-0">Featured Seasonal Tours</h3>
                    <span class="badge bg-light text-secondary border px-3 py-1.5 rounded-pill">{{ $packages->count() }} Available</span>
                </div>

                <div class="row g-4">
                    @foreach($packages as $pkg)
                        <div class="col-lg-4 col-md-6">
                            <div class="travel-card">
                                <div class="travel-card-img-wrap">
                                    <img src="{{ $pkg->image_url }}" alt="{{ $pkg->title }}" onerror="this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80'">
                                    <div class="travel-card-badge">
                                        <span class="badge badge-pill badge-tour">Guided Tour</span>
                                    </div>
                                    <div class="travel-card-price">
                                        ৳{{ number_format($pkg->price, 0) }}
                                    </div>
                                </div>

                                <div class="travel-card-body">
                                    <div class="d-flex align-items-center gap-1 text-secondary small fw-semibold mb-2">
                                        <i class='bx bxs-map text-primary'></i>
                                        <span>{{ $pkg->to_location ?? $pkg->location }}</span>
                                    </div>

                                    <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $pkg->title }}">
                                        {{ $pkg->title }}
                                    </h5>

                                    <p class="text-secondary small mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $pkg->description ?? 'Experience luxury hotel stays, round-trip transport, and guided sightseeing.' }}
                                    </p>

                                    <!-- Inclusions -->
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        <span class="badge bg-light text-secondary border px-2 py-1 small"><i class='bx bx-hotel me-1'></i>Hotel</span>
                                        <span class="badge bg-light text-secondary border px-2 py-1 small"><i class='bx bx-car me-1'></i>Transport</span>
                                        <span class="badge bg-light text-secondary border px-2 py-1 small"><i class='bx bx-restaurant me-1'></i>Meals</span>
                                    </div>

                                    <a href="{{ route('booking', ['package_id' => $pkg->id]) }}" class="btn btn-primary-gradient w-100 py-2">
                                        Book This Package ➔
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- POPULAR WEEKEND GETAWAYS -->
        <div class="mb-5">
            <h3 class="fw-bold fs-4 mb-4">Weekend Getaways & Escapes</h3>
            <div class="row g-4">
                @php
                    $escapes = [
                        ['title' => 'Cox’s Bazar Beach Breeze', 'price' => 6700, 'loc' => 'Cox’s Bazar', 'img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80', 'duration' => '3 Days / 2 Nights'],
                        ['title' => 'Sundarbans Eco Cruise', 'price' => 8999, 'loc' => 'Sundarbans', 'img' => 'https://images.unsplash.com/photo-1518495973542-4542c06a5843?auto=format&fit=crop&w=600&q=80', 'duration' => '2 Days / 1 Night'],
                        ['title' => 'Sylhet Tea Valley Trek', 'price' => 7500, 'loc' => 'Sylhet', 'img' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=600&q=80', 'duration' => '3 Days / 2 Nights'],
                        ['title' => 'Bandarban Nilgiri Clouds', 'price' => 12500, 'loc' => 'Bandarban', 'img' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=600&q=80', 'duration' => '3 Days / 2 Nights'],
                        ['title' => 'Srimangal Rainforest Trail', 'price' => 5800, 'loc' => 'Moulvibazar', 'img' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=600&q=80', 'duration' => '2 Days / 1 Night'],
                        ['title' => 'Saint Martin Coral Cruise', 'price' => 11000, 'loc' => 'Saint Martin', 'img' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?auto=format&fit=crop&w=600&q=80', 'duration' => '3 Days / 2 Nights'],
                    ];
                @endphp

                @foreach($escapes as $esc)
                    <div class="col-lg-4 col-md-6">
                        <div class="travel-card">
                            <div class="travel-card-img-wrap">
                                <img src="{{ $esc['img'] }}" alt="{{ $esc['title'] }}">
                                <div class="travel-card-badge">
                                    <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-2.5 py-1 small">
                                        <i class='bx bx-time-five me-1'></i>{{ $esc['duration'] }}
                                    </span>
                                </div>
                                <div class="travel-card-price">
                                    ৳{{ number_format($esc['price'], 0) }}
                                </div>
                            </div>
                            <div class="travel-card-body">
                                <div class="text-secondary small fw-semibold mb-1">
                                    <i class='bx bxs-map text-danger me-1'></i>{{ $esc['loc'] }}
                                </div>
                                <h5 class="fw-bold text-dark mb-2">{{ $esc['title'] }}</h5>
                                <p class="text-secondary small mb-3 flex-grow-1">
                                    Includes hotel stay with breakfast, deluxe AC transport, and experienced tour coordinator.
                                </p>
                                <a href="{{ route('booking', ['title' => $esc['title'], 'location' => $esc['loc'], 'price' => $esc['price']]) }}" class="btn btn-outline-primary w-100 rounded-3 py-2 fw-semibold">
                                    Book Now ➔
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- FAQ ACCORDION -->
        <div class="bg-white rounded-4 border p-4 p-md-5 shadow-sm mt-5">
            <div class="text-center max-w-xl mx-auto mb-4" style="max-width: 600px; margin: 0 auto;">
                <h3 class="fw-bold mb-1">Frequently Asked Questions</h3>
                <p class="text-secondary small">Everything you need to know about our holiday booking policies and inclusions.</p>
            </div>

            <div class="accordion" id="tourFaqAccordion">
                @php
                    $faqs = [
                        ['q' => 'What is included in the holiday tour packages?', 'a' => 'Our all-inclusive packages generally include round-trip transport (AC Bus or Train), hotel accommodation with daily breakfast, local sightseeing transfers, and entrance permits.'],
                        ['q' => 'Can I customize an itinerary for private family groups?', 'a' => 'Yes! For customized group bookings of 5 or more travelers, contact our 24/7 helpline or drop a message from the Contact page.'],
                        ['q' => 'What is the package cancellation and refund policy?', 'a' => 'You can cancel any booking directly from your User Dashboard. Full refunds are processed when cancelled at least 48 hours prior to the travel date.'],
                        ['q' => 'Do I receive a printable boarding pass and voucher?', 'a' => 'Yes, once payment is verified, your e-Ticket and tour voucher become available immediately in your dashboard for download or printing.']
                    ];
                @endphp

                @foreach($faqs as $idx => $faq)
                    <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                        <h2 class="accordion-header" id="heading{{ $idx }}">
                            <button class="accordion-button {{ $idx !== 0 ? 'collapsed' : '' }} fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idx }}">
                                {{ $faq['q'] }}
                            </button>
                        </h2>
                        <div id="collapse{{ $idx }}" class="accordion-collapse collapse {{ $idx === 0 ? 'show' : '' }}" data-bs-parent="#tourFaqAccordion">
                            <div class="accordion-body text-secondary small" style="line-height: 1.6;">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection
