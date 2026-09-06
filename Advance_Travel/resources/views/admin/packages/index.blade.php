@extends('layouts.admin')

@section('title', 'Manage Packages')

@section('content')

<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold m-0 text-dark">Travel & Tour Packages 🎒</h5>
            <small class="text-muted">Manage available tour packages displayed on the website</small>
        </div>
        <a href="{{ route('packages.create') }}" class="btn btn-primary rounded-3 px-3 fw-bold">
            <i class='bx bx-plus me-1'></i> Add New Package
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Thumbnail</th>
                    <th class="py-3">Package Title</th>
                    <th class="py-3">Location</th>
                    <th class="py-3">Price</th>
                    <th class="py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                    <tr>
                        <td style="width: 90px;">
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
                            <img src="{{ $imgSrc }}" alt="{{ $package->title }}" class="rounded-3 shadow-sm" style="width: 70px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $package->title }}
                            <div class="text-muted fw-normal small text-truncate" style="max-width: 280px;">
                                {{ $package->description }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2.5 py-1.5 rounded-2 fw-semibold">
                                📍 {{ $package->location }}
                            </span>
                        </td>
                        <td class="fw-bold text-success">
                            ৳{{ number_format($package->price, 2) }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-outline-primary rounded-2 me-1">
                                <i class='bx bx-edit-alt'></i> Edit
                            </a>

                            <form action="{{ route('packages.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this package?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                    <i class='bx bx-trash'></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class='bx bx-package fs-1 d-block mb-2 text-secondary opacity-50'></i>
                            No travel packages created yet. Click "Add New Package" to get started!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
