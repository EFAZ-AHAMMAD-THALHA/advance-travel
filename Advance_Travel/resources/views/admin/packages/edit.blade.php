@extends('layouts.admin')

@section('title', 'Edit Tour Package')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0 text-dark">Edit Package: {{ $package->title }} ✏️</h5>
                <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class='bx bx-arrow-back me-1'></i> Back to Packages
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

                <div class="mb-3">
                    <label class="form-label fw-semibold">Package Title</label>
                    <input type="text" name="title" class="form-control rounded-3" value="{{ old('title', $package->title) }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Destination Location</label>
                        <input type="text" name="location" class="form-control rounded-3" value="{{ old('location', $package->location) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (৳ BDT)</label>
                        <input type="number" step="0.01" name="price" class="form-control rounded-3" value="{{ old('price', $package->price) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control rounded-3" rows="4" required>{{ old('description', $package->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Current Image</label>
                    <div class="mb-2">
                        @php
                            $imgSrc = asset('assets/files/pac2.1.jpg');
                            if ($package->image) {
                                if (file_exists(public_path('uploads/packages/' . $package->image))) {
                                    $imgSrc = asset('uploads/packages/' . $package->image);
                                } elseif (file_exists(public_path('assets/files/' . $package->image))) {
                                    $imgSrc = asset('assets/files/' . $package->image);
                                }
                            }
                        @endphp
                        <img src="{{ $imgSrc }}" alt="{{ $package->title }}" class="rounded-3 shadow-sm" style="width: 140px; height: 90px; object-fit: cover;">
                    </div>

                    <label class="form-label fw-semibold">Change Image (Optional)</label>
                    <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">
                        <i class='bx bx-check me-1'></i> Update Package
                    </button>
                    <a href="{{ route('packages.index') }}" class="btn btn-light border px-4 rounded-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
