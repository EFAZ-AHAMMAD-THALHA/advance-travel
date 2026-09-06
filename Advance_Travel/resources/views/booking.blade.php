@extends('layouts.app')

@section('title', 'Booking | Advance Travel & Tourism')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow p-4">

                <!-- Heading -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Booking Online Now</h2>
                    <p class="text-muted">
                        Please fill out the form with the required information
                    </p>
                </div>

                <!-- Package Info -->
                @if($package)
                <div class="mb-4 p-3 border rounded bg-light text-center">
                    <h5>Booking Package:</h5>
                    <p><strong>{{ $package->title }}</strong></p>
                    <p>Location: {{ $package->location }}</p>
                    <p>Price: ৳{{ $package->price }}</p>
                </div>
                @endif

                <!-- Booking Form -->
                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf

                    @if($package)
                        <input type="hidden" name="package_title" value="{{ $package->title }}">
                        <input type="hidden" name="package_location" value="{{ $package->location }}">
                        <input type="hidden" name="package_price" value="{{ $package->price }}">

                        <input type="hidden" name="destination" value="{{ $package->location }}">
                    @endif

                    <!-- Personal Info -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name *</label>
                            <input type="text" class="form-control" name="firstname" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name *</label>
                            <input type="text" class="form-control" name="lastname" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone *</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                    </div>

                    <!-- Date Info -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Check-in Date *</label>
                            <input type="date" class="form-control" name="check_in_date" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Check-out Date *</label>
                            <input type="date" class="form-control" name="check_out_date" required>
                        </div>
                    </div>

                    <!-- Accommodation -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Accommodation Type *</label>
                            <select class="form-select" name="accommodation" required>
                                <option value="">Select One</option>
                                <option value="hotel">Hotel</option>
                                <option value="self">Self-Catered</option>
                                <option value="hostel">Hostel</option>
                                <option value="guesthouse">Guesthouse</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Number of Rooms *</label>
                            <input type="number" class="form-control" name="rooms" min="1" required>
                        </div>
                    </div>

                    <!-- Room Type -->
                    <div class="mb-3">
                        <label class="form-label d-block">Room Type *</label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="room_type" value="single" required>
                            <label class="form-check-label">Single Room</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="room_type" value="double">
                            <label class="form-check-label">Double Room</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="room_type" value="triple">
                            <label class="form-check-label">Triple Room</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="room_type" value="quad">
                            <label class="form-check-label">Quad Bedroom</label>
                        </div>
                    </div>

                    <!-- Additional Message -->
                    <div class="mb-4">
                        <label class="form-label">Additional Requests</label>
                        <textarea
                            class="form-control"
                            name="additional"
                            rows="4"
                            placeholder="Your message..."
                        ></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5 text-nowrap">
                            Submit
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
