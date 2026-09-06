@extends('layouts.admin')

@section('title', 'Add Travel Service / Ticket')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold m-0 text-dark">Add New Travel Service 🎒</h5>
                    <small class="text-muted">Create a new bus route, train journey, or tour package</small>
                </div>
                <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class='bx bx-arrow-back me-1'></i> Back to List
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('packages.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Service Type *</label>
                        <select name="type" class="form-select rounded-3" required>
                            <option value="bus" {{ old('type') == 'bus' ? 'selected' : '' }}>🚌 Bus Ticket</option>
                            <option value="train" {{ old('type') == 'train' ? 'selected' : '' }}>🚆 Train Ticket</option>
                            <option value="tour" {{ old('type') == 'tour' ? 'selected' : '' }}>🏖️ Tour Package</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Title / Service Name *</label>
                        <input type="text" name="title" class="form-control rounded-3"
                               placeholder="e.g. Green Line AC Deluxe / Suborno Express / Saint Martin Island Tour"
                               value="{{ old('title') }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">From (Origin City) *</label>
                        <input type="text" name="from_location" class="form-control rounded-3"
                               placeholder="e.g. Dhaka" value="{{ old('from_location', 'Dhaka') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">To (Destination City) *</label>
                        <input type="text" name="to_location" class="form-control rounded-3"
                               placeholder="e.g. Chittagong, Cox's Bazar, Sylhet" value="{{ old('to_location') }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Fare / Price (৳ BDT) *</label>
                        <input type="number" step="0.01" name="price" class="form-control rounded-3"
                               placeholder="e.g. 1200.00" value="{{ old('price') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Departure Time</label>
                        <input type="text" name="departure_time" class="form-control rounded-3"
                               placeholder="e.g. 07:30 AM / 10:45 PM" value="{{ old('departure_time') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Available Seat Capacity</label>
                        <input type="number" name="available_seats" class="form-control rounded-3"
                               placeholder="e.g. 40" value="{{ old('available_seats', 40) }}" min="1">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Service Description & Highlights *</label>
                    <textarea name="description" class="form-control rounded-3" rows="4"
                              placeholder="Enter route details, boarding points, coach amenities, resort inclusions..." required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Cover Thumbnail Image</label>
                    <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    <small class="text-muted">Supported formats: JPG, PNG, WEBP (Max: 3MB)</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">
                        <i class='bx bx-check me-1'></i> Create Travel Service
                    </button>
                    <a href="{{ route('packages.index') }}" class="btn btn-light border px-4 rounded-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
