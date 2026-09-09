@extends('layouts.admin')

@section('title', 'Manage Travel Services')

@section('content')

<div class="card-custom">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h5 class="fw-bold m-0 text-dark">Travel & Tour Services 🎒</h5>
            <small class="text-muted">Manage available bus routes, train services, and holiday packages</small>
        </div>
        <a href="{{ route('packages.create') }}" class="btn btn-primary rounded-3 px-3 fw-bold">
            <i class='bx bx-plus me-1'></i> Add New Service
        </a>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('packages.index') }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search Service Name or Route..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-select-sm">
                    <option value="all">All Service Types</option>
                    <option value="flight" {{ request('type') === 'flight' ? 'selected' : '' }}>✈️ Air Flight Tickets</option>
                    <option value="bus" {{ request('type') === 'bus' ? 'selected' : '' }}>🚌 Bus Tickets</option>
                    <option value="train" {{ request('type') === 'train' ? 'selected' : '' }}>🚆 Train Tickets</option>
                    <option value="tour" {{ request('type') === 'tour' ? 'selected' : '' }}>🏖️ Tour Packages</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 px-3 fw-bold w-100">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'type']))
                    <a href="{{ route('packages.index') }}" class="btn btn-outline-danger btn-sm rounded-3" title="Clear Filters">
                        <i class='bx bx-reset'></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Thumbnail</th>
                    <th class="py-3">Type</th>
                    <th class="py-3">Service Name</th>
                    <th class="py-3">Route / Destination</th>
                    <th class="py-3">Schedule & Seats</th>
                    <th class="py-3">Fare / Price</th>
                    <th class="py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                    <tr>
                        <td style="width: 80px;">
                            <img src="{{ $package->image_url }}" alt="{{ $package->title }}" class="rounded-3 shadow-sm" style="width: 70px; height: 50px; object-fit: cover;">
                        </td>
                        <td>
                            <span class="badge {{ $package->type === 'bus' ? 'bg-warning text-dark' : ($package->type === 'train' ? 'bg-danger text-white' : 'bg-primary') }} text-uppercase px-2 py-1 rounded">
                                {{ $package->type }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $package->title }}
                            <div class="text-muted fw-normal small text-truncate" style="max-width: 240px;">
                                {{ $package->description }}
                            </div>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">
                                {{ $package->from_location ?? 'Dhaka' }} ➔ {{ $package->to_location ?? $package->location }}
                            </span>
                        </td>
                        <td>
                            <div class="small fw-medium text-dark">⏰ {{ $package->departure_time ?? 'Scheduled' }}</div>
                            <small class="text-muted">{{ $package->available_seats }} seats available</small>
                        </td>
                        <td class="fw-bold text-success">
                            ৳{{ number_format($package->price, 2) }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-outline-primary rounded-2 me-1">
                                <i class='bx bx-edit-alt'></i> Edit
                            </a>

                            <form action="{{ route('packages.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class='bx bx-package fs-1 d-block mb-2 text-secondary opacity-50'></i>
                            No travel services created yet. Click "Add New Service" to create your first route!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $packages->links() }}
    </div>
</div>

@endsection
