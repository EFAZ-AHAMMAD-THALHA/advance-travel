@extends('layouts.app')

@section('title', 'Explore Bus, Train & Tour Tickets | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50">
    <div class="container-xl">

        <!-- Page Header -->
        <div class="mb-4 text-center text-md-start d-md-flex justify-content-between align-items-end">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 small">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Explore Tickets</li>
                    </ol>
                </nav>
                <h1 class="display-6 fw-bold mb-1">Available Travel Services</h1>
                <p class="text-secondary small mb-0">Search and book verified AC buses, intercity trains, and curated tours.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-semibold">
                    <i class='bx bx-check-circle me-1'></i>{{ $items->total() ?? count($items) }} Schedules Found
                </span>
            </div>
        </div>

        <!-- Filter & Search Widget Card -->
        <div class="bg-white rounded-4 border p-4 shadow-sm mb-5">
            <form action="{{ route('explore') }}" method="GET">
                <!-- Transport Mode Pills -->
                <div class="d-flex flex-wrap gap-2 mb-4 border-bottom pb-3">
                    <a href="{{ route('explore', array_merge(request()->except('type', 'page'), ['type' => 'all'])) }}"
                       class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-semibold {{ (!request('type') || request('type') == 'all') ? 'btn-primary' : 'btn-outline-secondary' }}">
                        <i class='bx bx-grid-alt me-1'></i>All Modes
                    </a>
                    <a href="{{ route('explore', array_merge(request()->except('type', 'page'), ['type' => 'bus'])) }}"
                       class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-semibold {{ request('type') == 'bus' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        <i class='bx bx-bus me-1'></i>Bus Tickets
                    </a>
                    <a href="{{ route('explore', array_merge(request()->except('type', 'page'), ['type' => 'train'])) }}"
                       class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-semibold {{ request('type') == 'train' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        <i class='bx bx-train me-1'></i>Train Tickets
                    </a>
                    <a href="{{ route('explore', array_merge(request()->except('type', 'page'), ['type' => 'tour'])) }}"
                       class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-semibold {{ request('type') == 'tour' ? 'btn-primary' : 'btn-outline-secondary' }}">
                        <i class='bx bx-sun me-1'></i>Tour Packages
                    </a>
                    <input type="hidden" name="type" value="{{ request('type', 'all') }}">
                </div>

                <!-- Query Inputs Row -->
                <div class="row g-3 align-items-end mb-3">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Route or Keyword</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class='bx bx-search'></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Search route, city, or fleet..." value="{{ request('q') ?? request('search') ?? request('query') }}">
                        </div>
                    </div>

                    <!-- From (Departure) -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label d-flex justify-content-between">
                            <span>From (Departure)</span>
                            <span class="text-primary small" style="font-size: 0.72rem; cursor: pointer;" onclick="document.getElementById('fromInputExplore').focus()">Suggestions ▼</span>
                        </label>
                        <div class="city-autocomplete-wrapper">
                            <div class="input-group">
                                <span class="input-group-text bg-light text-primary border-end-0"><i class='bx bxs-navigation'></i></span>
                                <input type="text" name="from" id="fromInputExplore" class="form-control border-start-0 city-search-input" 
                                       placeholder="e.g. Dhaka" autocomplete="off" value="{{ request('from') }}"
                                       data-dropdown="fromDropdownExplore">
                                <button type="button" class="btn btn-light border border-start-0 text-muted city-dropdown-trigger" data-target="fromDropdownExplore">
                                    <i class='bx bx-chevron-down'></i>
                                </button>
                            </div>
                            <div class="city-suggestion-menu" id="fromDropdownExplore">
                                <div class="p-2 border-bottom bg-light d-flex justify-content-between align-items-center">
                                    <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.7rem;">Departure Hubs</span>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill" style="font-size: 0.65rem;">Hubs</span>
                                </div>
                                <div class="city-suggestion-list"></div>
                            </div>
                        </div>
                    </div>

                    <!-- To (Destination) -->
                    <div class="col-lg-4 col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0">To (Destination)</label>
                            <button type="button" class="btn btn-link text-primary p-0 text-decoration-none small fw-semibold d-inline-flex align-items-center gap-1" onclick="swapCities('fromInputExplore', 'toInputExplore')" title="Swap Origin & Destination">
                                <i class='bx bx-transfer-alt'></i> Swap
                            </button>
                        </div>
                        <div class="city-autocomplete-wrapper">
                            <div class="input-group">
                                <span class="input-group-text bg-light text-danger border-end-0"><i class='bx bxs-map'></i></span>
                                <input type="text" name="to" id="toInputExplore" class="form-control border-start-0 city-search-input" 
                                       placeholder="e.g. Cox's Bazar" autocomplete="off" value="{{ request('to') }}"
                                       data-dropdown="toDropdownExplore">
                                <button type="button" class="btn btn-light border border-start-0 text-muted city-dropdown-trigger" data-target="toDropdownExplore">
                                    <i class='bx bx-chevron-down'></i>
                                </button>
                            </div>
                            <div class="city-suggestion-menu" id="toDropdownExplore">
                                <div class="p-2 border-bottom bg-light d-flex justify-content-between align-items-center">
                                    <span class="small fw-bold text-muted text-uppercase" style="font-size: 0.7rem;">Destinations</span>
                                    <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 0.65rem;">Hot</span>
                                </div>
                                <div class="city-suggestion-list"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Filters Row -->
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Max Budget (৳)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-success">৳</span>
                            <input type="number" name="max_price" class="form-control" placeholder="e.g. 5000" value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <label class="form-label">Sort Results</label>
                        <select name="sort" class="form-select">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Featured / Latest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="seats" {{ request('sort') == 'seats' ? 'selected' : '' }}>Most Seats Available</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary-gradient flex-grow-1 py-2.5 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                            <i class='bx bx-search-alt-2 fs-5'></i>
                            <span>Filter Results</span>
                        </button>
                        @if(request()->anyFilled(['q', 'from', 'to', 'max_price', 'type', 'sort']))
                            <a href="{{ route('explore') }}" class="btn btn-outline-danger px-3 py-2.5 fw-semibold d-inline-flex align-items-center justify-content-center" title="Reset Filters">
                                <i class='bx bx-reset fs-5 me-1'></i> Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Catalog Grid -->
        <div class="row g-4 mb-5">
            @forelse($items as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="travel-card">
                        <!-- Card Media -->
                        <div class="travel-card-img-wrap">
                            @php
                                $imgSrc = 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80';
                                if ($item->type === 'train') {
                                    $imgSrc = 'https://images.unsplash.com/photo-1474487548417-781cb71495f3?auto=format&fit=crop&w=800&q=80';
                                } elseif ($item->type === 'tour') {
                                    $imgSrc = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';
                                }
                                if ($item->image) {
                                    if (file_exists(public_path('uploads/packages/' . $item->image))) {
                                        $imgSrc = asset('uploads/packages/' . $item->image);
                                    } elseif (file_exists(public_path('assets/files/' . $item->image))) {
                                        $imgSrc = asset('assets/files/' . rawurlencode($item->image));
                                    }
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $item->title }}" onerror="this.src='https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80'">

                            <div class="travel-card-badge">
                                @if($item->type === 'bus')
                                    <span class="badge badge-pill badge-bus"><i class='bx bx-bus'></i> BUS</span>
                                @elseif($item->type === 'train')
                                    <span class="badge badge-pill badge-train"><i class='bx bx-train'></i> TRAIN</span>
                                @else
                                    <span class="badge badge-pill badge-tour"><i class='bx bx-sun'></i> TOUR</span>
                                @endif
                            </div>

                            <div class="travel-card-price">
                                ৳{{ number_format($item->price, 0) }}
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="travel-card-body">
                            <div class="d-flex align-items-center gap-1 text-secondary small fw-semibold mb-2">
                                <i class='bx bxs-map-pin text-primary'></i>
                                <span>{{ $item->from_location ?? 'Dhaka' }}</span>
                                <i class='bx bx-right-arrow-alt mx-1'></i>
                                <span>{{ $item->to_location ?? $item->location }}</span>
                            </div>

                            <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $item->title }}">
                                {{ $item->title }}
                            </h5>

                            <p class="text-secondary small mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $item->description ?? 'Reliable intercity schedule with premium amenities, certified drivers, and passenger insurance included.' }}
                            </p>

                            <!-- Amenities Tags -->
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                <span class="badge bg-light text-secondary border px-2 py-1 small">AC</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 small">WiFi</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 small">Snacks</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 small">Tracking</span>
                            </div>

                            <!-- Meta Footer -->
                            <div class="d-flex justify-content-between align-items-center mb-3 pt-2 border-top">
                                <span class="small text-secondary">
                                    <i class='bx bx-time me-1'></i>{{ $item->departure_time ?? '08:00 AM' }}
                                </span>
                                <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 small fw-bold">
                                    {{ $item->available_seats }} Seats Available
                                </span>
                            </div>

                            <a href="{{ route('booking', ['package_id' => $item->id]) }}" class="btn btn-primary-gradient w-100 py-2">
                                <span>Book Seat Now</span>
                                <i class='bx bx-arrow-to-right'></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-white rounded-4 border p-5 shadow-sm max-w-xl mx-auto" style="max-width: 500px; margin: 0 auto;">
                        <i class='bx bx-search-alt-2 fs-1 text-slate-400 mb-3'></i>
                        <h4 class="fw-bold mb-2">No Matching Services</h4>
                        <p class="text-secondary small mb-4">We couldn't find any trips matching your criteria. Try loosening your departure or price filter.</p>
                        <a href="{{ route('explore') }}" class="btn btn-primary-gradient px-4 py-2 rounded-pill">
                            Clear Filters & View All
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $items->links() }}
        </div>

    </div>
</div>
@endsection
