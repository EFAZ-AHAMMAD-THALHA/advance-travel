@extends('layouts.admin')

@section('title', 'Create Tour Package')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0 text-dark">Create New Tour Package 🎒</h5>
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

            <form method="POST" action="{{ route('packages.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Package Title</label>
                    <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. Saint Martin Coral Island Escape" value="{{ old('title') }}" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Destination Location</label>
                        <input type="text" name="location" class="form-control rounded-3" placeholder="e.g. Saint Martin, Cox's Bazar" value="{{ old('location') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (৳ BDT)</label>
                        <input type="number" step="0.01" name="price" class="form-control rounded-3" placeholder="e.g. 12500.00" value="{{ old('price') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control rounded-3" rows="4" placeholder="Enter full tour details, inclusions, and highlights..." required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Package Image</label>
                    <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    <small class="text-muted">Supported formats: JPG, PNG, WEBP (Max: 2MB)</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">
                        <i class='bx bx-check me-1'></i> Save Package
                    </button>
                    <a href="{{ route('packages.index') }}" class="btn btn-light border px-4 rounded-3">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
