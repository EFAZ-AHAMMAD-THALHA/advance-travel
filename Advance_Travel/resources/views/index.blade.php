@extends('layouts.app')

@section('title', 'Home | Advance Travel & Tourism')

@section('content')

<!-- HERO / VIDEO SECTION -->
<section class="position-relative">
    <video class="w-100 vh-100 object-fit-cover" autoplay muted loop>
        <source src="{{ asset('assets/files/bgvid.mp4') }}" type="video/mp4">
    </video>

    <div class="position-absolute top-50 start-50 translate-middle text-center text-white px-3">
        <h1 class="fw-bold">Advance Travel & Tourism</h1>
        <p class="lead">Explore Amazing Destinations with Budget-Friendly Packages</p>
        <a href="{{ url('/booking') }}" class="btn btn-warning btn-lg mt-3">Book Now</a>
    </div>
</section>

<!-- SEARCH FORM -->
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="card p-4 shadow">
                <h5 class="text-center mb-3">Search Your Destination</h5>

                <input type="text" class="form-control mb-3" placeholder="Enter destination">
                <input type="date" class="form-control mb-3">

                <label class="form-label">Max Price: <span id="priceValue">2500</span></label>
                <input type="range" class="form-range" min="0" max="10000" value="2500"
                       oninput="priceValue.innerText=this.value">
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section class="container my-5">
    <h2 class="text-center mb-4">Our Services</h2>

    <div class="row g-4 text-center">
        @foreach([
            ['1a.jpg','Flight Services','Arrival & Departure'],
            ['2a.jpg','Food Services','Catering'],
            ['3a.jpg','Travel Services','Pick-up / Drop'],
            ['4a.jpg','Hotel Services','Check-in / out']
        ] as $service)
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card h-100 shadow">
                <img src="{{ asset('assets/files/'.$service[0]) }}" class="card-img-top">
                <div class="card-body">
                    <h5>{{ $service[1] }}</h5>
                    <p>{{ $service[2] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>





















<!-- PACKAGES -->
<section class="container my-5" id="package">
    <h2 class="text-center mb-4">Popular Packages</h2>

    <div class="row g-4">
        @foreach([
            ['p1.jpg','Tk.2,700'],
            ['p2.jpg','Tk.4,999'],
            ['p3.jpg','Tk.9,999'],
            ['p4.jpg','Tk.30,000'],
            ['pac1.jpeg','Tk.37,700'],
            ['pac1.jpg','Tk.47,500']
        ] as $pkg)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100 shadow">
                <img src="{{ asset('assets/files/'.$pkg[0]) }}" class="card-img-top">
                <div class="card-body text-center">
                    <h5>Starting at {{ $pkg[1] }}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ url('/package') }}" class="btn btn-primary">Explore More</a>
    </div>
</section>












<!-- LOCATIONS -->
<section class="container my-5" id="locations">
    <h2 class="text-center mb-4">Top Locations</h2>

    <div class="row g-4">
        @foreach([
            ['l1.jpg','India','Kashmir'],
            ['l2.jpg','Turkey','Istanbul'],
            ['l3.jpg','France','Paris'],
            ['l4.jpg','Indonesia','Bali']
        ] as $loc)
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card h-100 shadow text-center">
                <img src="{{ asset('assets/files/'.$loc[0]) }}" class="card-img-top">
                <div class="card-body">
                    <h5>{{ $loc[1] }}</h5>
                    <p>{{ $loc[2] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>







<!-- NEWSLETTER -->
<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2>Newsletter</h2>
        <p>Subscribe for latest offers</p>

        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-10">
                <div class="input-group">
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email"
                    >
                    <button class="btn btn-warning">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

