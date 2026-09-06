@extends('layouts.app')

@section('title', 'Iconic Destinations | Advance Travel & Tourism')

@section('content')

<div class="py-5 bg-slate-50">
    <div class="container-xl">

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 700px; margin: 0 auto;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Destinations</li>
                </ol>
            </nav>
            <span class="badge badge-pill badge-bus mb-2">Global & Domestic Directory</span>
            <h1 class="display-6 fw-bold mb-2">Explore Iconic Travel Destinations</h1>
            <p class="text-secondary small">
                Discover breathtaking landscapes, historic cultural monuments, and vibrant coastal retreats with direct transport and holiday booking options.
            </p>
        </div>

        @php
        $destinations = [
            [
                'name' => 'Cox\'s Bazar',
                'country' => 'Bangladesh',
                'category' => 'Beach & Coast',
                'rating' => 5.0,
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'Nov - Mar',
                'desc' => 'Home to the world\'s longest natural unbroken sea beach, stretching over 120 km along the Bay of Bengal.',
                'tag' => 'Top Pick'
            ],
            [
                'name' => 'Sajek Valley',
                'country' => 'Bangladesh',
                'category' => 'Hill Tracts',
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'Sep - Feb',
                'desc' => 'Known as the Queen of Hills, offering breathtaking views of clouds floating below lush green mountain peaks.',
                'tag' => 'Trending'
            ],
            [
                'name' => 'Sylhet & Ratargul',
                'country' => 'Bangladesh',
                'category' => 'Eco & Nature',
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'Jul - Jan',
                'desc' => 'Endless manicured tea gardens, crystal freshwater swamp forests, and scenic waterfalls of Jaflong.',
                'tag' => 'Eco Resort'
            ],
            [
                'name' => 'Sundarbans Forest',
                'country' => 'Bangladesh',
                'category' => 'Wildlife & Safari',
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1518495973542-4542c06a5843?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'Oct - Mar',
                'desc' => 'The world\'s largest mangrove forest, UNESCO World Heritage site and natural sanctuary of the Royal Bengal Tiger.',
                'tag' => 'UNESCO'
            ],
            [
                'name' => 'Kashmir Valley',
                'country' => 'India',
                'category' => 'Mountains',
                'rating' => 5.0,
                'image' => 'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'Mar - Oct',
                'desc' => 'Often hailed as paradise on earth, surrounded by snow-capped Himalayan ranges and Dal Lake houseboats.',
                'tag' => 'Global'
            ],
            [
                'name' => 'Istanbul',
                'country' => 'Turkey',
                'category' => 'Historical',
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'Apr - Jun',
                'desc' => 'Where Europe and Asia converge across the Bosphorus Strait, rich with centuries of Byzantine and Ottoman history.',
                'tag' => 'Historic'
            ],
            [
                'name' => 'Bali Island',
                'country' => 'Indonesia',
                'category' => 'Tropical Island',
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'May - Sep',
                'desc' => 'World-famous tropical retreat offering emerald volcanic terraced hills, ancient Hindu temples, and surfing.',
                'tag' => 'Tropical'
            ],
            [
                'name' => 'Dubai Marina',
                'country' => 'UAE',
                'category' => 'Modern Luxury',
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
                'best_season' => 'Nov - Apr',
                'desc' => 'Futuristic metropolis of architectural marvels, world-record observation decks, and luxury desert safaris.',
                'tag' => 'Luxury'
            ]
        ];
        @endphp

        <div class="row g-4">
            @foreach ($destinations as $loc)
                <div class="col-lg-3 col-md-6">
                    <div class="travel-card">
                        <div class="travel-card-img-wrap">
                            <img src="{{ $loc['image'] }}" alt="{{ $loc['name'] }}" onerror="this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80'">
                            
                            <div class="travel-card-badge">
                                <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-2.5 py-1 small">
                                    {{ $loc['category'] }}
                                </span>
                            </div>

                            <div class="travel-card-price" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;">
                                <i class='bx bxs-calendar me-1'></i>{{ $loc['best_season'] }}
                            </div>
                        </div>

                        <div class="travel-card-body">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-secondary small fw-bold">
                                    <i class='bx bxs-map text-primary me-1'></i>{{ $loc['country'] }}
                                </span>
                                <div class="d-flex align-items-center gap-1 text-warning small fw-bold">
                                    <i class='bx bxs-star'></i>
                                    <span>{{ number_format($loc['rating'], 1) }}</span>
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">{{ $loc['name'] }}</h5>
                            <p class="text-secondary small mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                {{ $loc['desc'] }}
                            </p>

                            <div class="mt-auto pt-2 border-top">
                                <a href="{{ route('explore', ['q' => $loc['name']]) }}" class="btn btn-primary-gradient w-100 py-1.5 small fw-semibold">
                                    <span>Find Tickets</span>
                                    <i class='bx bx-right-arrow-alt'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection
