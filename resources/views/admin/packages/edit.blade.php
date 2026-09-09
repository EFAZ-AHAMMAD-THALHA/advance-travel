@extends('layouts.admin')

@section('title', 'Edit Travel Service')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold m-0 text-dark">Edit Travel Service ✏️</h5>
                    <small class="text-muted">Update service details for "{{ $package->title }}"</small>
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

            <form method="POST" action="{{ route('packages.update', $package->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Service Type *</label>
                        <select name="type" class="form-select rounded-3" required>
                            <option value="flight" {{ old('type', $package->type) == 'flight' ? 'selected' : '' }}>✈️ Air Flight Ticket</option>
                            <option value="bus" {{ old('type', $package->type) == 'bus' ? 'selected' : '' }}>🚌 Bus Ticket</option>
                            <option value="train" {{ old('type', $package->type) == 'train' ? 'selected' : '' }}>🚆 Train Ticket</option>
                            <option value="tour" {{ old('type', $package->type) == 'tour' ? 'selected' : '' }}>🏖️ Tour Package</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Title / Service Name *</label>
                        <input type="text" name="title" class="form-control rounded-3"
                               value="{{ old('title', $package->title) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">From (Origin City) *</label>
                        <input type="text" name="from_location" class="form-control rounded-3"
                               value="{{ old('from_location', $package->from_location ?? 'Dhaka') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">To (Destination City) *</label>
                        <input type="text" name="to_location" class="form-control rounded-3"
                               value="{{ old('to_location', $package->to_location ?? $package->location) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Fare / Price (৳ BDT) *</label>
                        <input type="number" step="0.01" name="price" class="form-control rounded-3"
                               value="{{ old('price', $package->price) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Departure Time</label>
                        <input type="text" name="departure_time" class="form-control rounded-3"
                               value="{{ old('departure_time', $package->departure_time) }}" placeholder="e.g. 08:00 AM">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Available Seat Capacity</label>
                        <input type="number" name="available_seats" class="form-control rounded-3"
                               value="{{ old('available_seats', $package->available_seats) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Service Description & Highlights *</label>
                    <textarea name="description" class="form-control rounded-3" rows="4" required>{{ old('description', $package->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Cover Thumbnail Image</label>
                    @if($package->image)
                        <div class="mb-2">
                            @php
                                $imgSrc = asset('assets/files/pac2.1.jpg');
                                if (file_exists(public_path('uploads/packages/' . $package->image))) {
                                    $imgSrc = asset('uploads/packages/' . $package->image);
                                } elseif (file_exists(public_path('assets/files/' . $package->image))) {
                                    $imgSrc = asset('assets/files/' . $package->image);
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" alt="Current Image" class="rounded-3 shadow-sm" style="height: 90px; width: 140px; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    <small class="text-muted">Leave empty to keep current thumbnail</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">
                        <i class='bx bx-check me-1'></i> Update Service
                    </button>
                    <a href="{{ route('packages.index') }}" class="btn btn-light border px-4 rounded-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
