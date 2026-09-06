@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/location.css') }}">
@endpush

@section('content')

<div class="container my-5 location-body">
    <div class="text-center mb-4">
        <h1>Explore The <span class="text-primary">Unexplored!!</span></h1>
        <hr>
    </div>

    @php
    $locations = [
        [
            'id' => 'kashmir',
            'name' => 'Kashmir',
            'rating' => 5,
            'image' => 'l1.jpg',
            'description' => 'Heaven on Earth Kashmir is one of the most beautiful travel destinations...'
        ],
        [
            'id' => 'istanbul',
            'name' => 'Istanbul',
            'rating' => 4.5,
            'image' => 'l2.jpg',
            'description' => 'Istanbul offers unique historical and cultural riches, spanning Europe and Asia...'
        ],
        [
            'id' => 'paris',
            'name' => 'Paris',
            'rating' => 4.5,
            'image' => 'l3.jpg',
            'description' => 'Paris, the city of romance, is visited by millions each year for its iconic sights...'
        ],
        [
            'id' => 'bali',
            'name' => 'Bali',
            'rating' => 4.5,
            'image' => 'l4.jpg',
            'description' => 'Bali offers stunning beaches, resorts, private villas, and cultural experiences...'
        ],
        [
            'id' => 'dubai',
            'name' => 'Dubai',
            'rating' => 5,
            'image' => 'l5.jpg',
            'description' => 'Dubai is an ideal holiday destination for families, with theme parks, beaches, and attractions...'
        ],
        [
            'id' => 'geneva',
            'name' => 'Geneva',
            'rating' => 4.5,
            'image' => 'l6.jpg',
            'description' => 'Geneva is a charming lakeside city, home to international organizations and beautiful landscapes...'
        ],
        [
            'id' => 'port-blair',
            'name' => 'Port Blair',
            'rating' => 4.5,
            'image' => 'l7.jpg',
            'description' => 'Port Blair features clean beaches, coral reefs, museums, and colonial landmarks...'
        ],
        [
            'id' => 'rome',
            'name' => 'Rome',
            'rating' => 4,
            'image' => 'l8.jpg',
            'description' => 'Rome is a city of history, art, and cuisine, with iconic sites like the Colosseum and Vatican...'
        ],
    ];
    @endphp

    <div class="row g-4">
        @foreach ($locations as $loc)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('assets/files/' . $loc['image']) }}" class="card-img-top" alt="{{ $loc['name'] }}">
                <div class="card-body">
                    <h4 class="card-title">{{ $loc['name'] }}</h4>
                    <div class="mb-2">
                        @for ($i = 1; $i <= floor($loc['rating']); $i++)
                            <i class='bx bxs-star text-warning'></i>
                        @endfor
                        @if($loc['rating'] - floor($loc['rating']) > 0)
                            <i class='bx bxs-star-half text-warning'></i>
                        @endif
                    </div>
                    <p class="card-text">{{ $loc['description'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection
