@extends('layouts.app')

@section('title', '404 - Page Not Found | Advance Travel & Tourism')

@section('content')
<div class="py-5 bg-slate-50 d-flex align-items-center" style="min-height: calc(100vh - 200px);">
    <div class="container text-center">
        <div class="max-w-md mx-auto p-4 p-md-5 bg-white rounded-4 border shadow-sm" style="max-width: 580px; margin: 0 auto;">
            <div class="brand-icon-box mx-auto mb-3" style="width: 72px; height: 72px; font-size: 2.2rem; background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <i class='bx bx-compass'></i>
            </div>
            
            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1.5 fw-bold mb-3">ERROR 404</span>
            <h2 class="fw-bold mb-2">Destination Off the Map</h2>
            <p class="text-secondary small mb-4">
                The page, travel route, or resource you are looking for has either moved or does not exist. Let's get you back on track.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ url('/') }}" class="btn btn-primary-gradient px-4 py-2 rounded-pill fw-semibold">
                    <i class='bx bx-home-alt me-1'></i> Return to Home
                </a>
                <a href="{{ route('explore') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-semibold">
                    <i class='bx bx-search me-1'></i> Explore Tickets
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
