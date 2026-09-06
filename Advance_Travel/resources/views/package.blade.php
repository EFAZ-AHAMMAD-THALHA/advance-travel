@extends('layouts.app')

@section('title', 'Packages | Advance Travel & Tourism')

@section('content')

<div class="container my-5">

    <!-- HEADING -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Top Stays In & Around for a Weekend Getaway</h1>
        <p class="text-muted">
            Need a break from the daily drill? Pick from these hand-picked destinations near the city.
        </p>
    </div>

    <!-- FLASH DEAL -->
    <div class="alert alert-warning text-center mb-5">
        <h5 class="mb-1">🔥 Flash Deal is Live</h5>
        <p class="mb-0">Extra discount on best sellers — Code: <strong>FLASHDEAL</strong></p>
    </div>

    <!-- PACKAGE GRID (Admin-added) -->
    @if(isset($packages) && $packages->count() > 0)
    <div class="row g-4 mb-5">
        @foreach($packages as $pkg)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ file_exists(public_path('uploads/packages/'.$pkg->image)) ? asset('uploads/packages/'.$pkg->image) : asset('assets/files/'.$pkg->image) }}" class="card-img-top img-fluid" style="height:220px; object-fit:cover;">
                <div class="card-body text-center d-flex flex-column">
                    <h5 class="fw-bold">{{ $pkg->title }}</h5>
                    <p class="text-muted small mb-2">📍 {{ $pkg->location }}</p>
                    <p class="text-secondary small flex-grow-1">{{ Str::limit($pkg->description, 80) }}</p>
                    <h6 class="text-primary fw-bold">Starting at ৳{{ number_format($pkg->price, 2) }}</h6>
                    <a href="{{ route('booking', [
                        'title' => $pkg->title,
                        'location' => $pkg->location,
                        'price' => $pkg->price
                    ]) }}" class="btn btn-primary mt-2">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- STATIC PACKAGES: Top Stays -->
    <div class="row g-4 mb-5">
        @foreach([
            ['pac2.1.jpg','Tk.6,700','Weekend Getaway','Cox’s Bazar'],
            ['pack2.2.jpg','Tk.4,999','Romantic Escape','Sundarbans'],
            ['pac2.3.jpg','Tk.9,999','Adventure Trip','Sylhet'],
            ['pac2.4.webp','Tk.39,000','Luxury Retreat','Bandarban'],
            ['pac2.5.jpg','Tk.3,700','City Break','Dhaka']
        ] as $pkg)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/files/'.$pkg[0]) }}" class="card-img-top img-fluid">
                <div class="card-body text-center">
                    <h5>Starting at {{ $pkg[1] }}</h5>
                    <a href="{{ route('booking', [
                        'title' => $pkg[2],
                        'location' => $pkg[3],
                        'price' => preg_replace('/[^\d]/','',$pkg[1])
                    ]) }}" class="btn btn-primary mt-2">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- STATIC PACKAGES: Explore the Unexplored -->
    <h2 class="text-center mb-4">Explore the Unexplored</h2>
    <div class="row g-4 mb-5">
        @foreach([
            ['package3.1.jpg','Tk.1,06,999','Heritage Tour','Paharpur'],
            ['package 3.2.jpg','Tk.1,39,000','Nature Escape','Rangamati'],
            ['package3.3.jpg','Tk.1,30,700','Wildlife Safari','Chittagong']
        ] as $pkg)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/files/'.$pkg[0]) }}" class="card-img-top img-fluid">
                <div class="card-body text-center">
                    <h5>Starting at {{ $pkg[1] }}</h5>
                    <a href="{{ route('booking', [
                        'title' => $pkg[2],
                        'location' => $pkg[3],
                        'price' => preg_replace('/[^\d]/','',$pkg[1])
                    ]) }}" class="btn btn-primary mt-2">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- STATIC PACKAGES: International Destinations -->
    <h2 class="text-center mb-4">International Destinations</h2>
    <div class="row g-4 mb-5">
        @foreach([
            ['pack2.2.jpg','Tk.4,999','Beach Paradise','Maldives'],
            ['pac2.3.jpg','Tk.9,999','City Lights','Singapore'],
            ['pac2.4.webp','Tk.39,000','Luxury Cruise','Dubai']
        ] as $pkg)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/files/'.$pkg[0]) }}" class="card-img-top img-fluid">
                <div class="card-body text-center">
                    <h5>Starting at {{ $pkg[1] }}</h5>
                    <a href="{{ route('booking', [
                        'title' => $pkg[2],
                        'location' => $pkg[3],
                        'price' => preg_replace('/[^\d]/','',$pkg[1])
                    ]) }}" class="btn btn-primary mt-2">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- FAQ -->
    <div class="card shadow-sm p-4">
        <h2 class="text-center mb-4">FAQs – Frequently Asked Questions</h2>

        <div class="accordion" id="faqAccordion">

            @foreach([
                ['What kind of destinations can I choose?', 'You can choose adventure, romantic, wildlife, beach, heritage or pilgrimage destinations.'],
                ['Can I opt for a budget-friendly holiday?', 'Yes. You can choose packages from Tk.10,000 to Tk.50,000 by planning in advance.'],
                ['Which time is best for booking?', 'Holidays can be booked throughout the year depending on your selected month.'],
                ['What will I get in a holiday idea?', 'Details of destinations, hotels, experiences and activities.']
            ] as $i => $faq)

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $i ? 'collapsed' : '' }}" data-bs-toggle="collapse"
                            data-bs-target="#faq{{ $i }}">
                        {{ $faq[0] }}
                    </button>
                </h2>
                <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i==0 ? 'show' : '' }}">
                    <div class="accordion-body">
                        {{ $faq[1] }}
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>

</div>

@endsection
