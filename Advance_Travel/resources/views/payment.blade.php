@extends('layouts.app')

@section('title', 'Payment Gateway | Advance Travel & Tourism')

@section('content')
<div class="py-4 py-md-5 bg-slate-50" style="min-height: calc(100vh - 220px); display: flex; align-items: center; justify-content: center;">
    <div class="container px-3 d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded-4 text-center p-4 p-md-5" style="max-width: 460px; width: 100%; box-sizing: border-box;">
            <div class="mb-3">
                <span class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle d-inline-flex fs-2">
                    💳
                </span>
            </div>
            <h4 class="fw-bold text-dark mb-2">Complete Your Payment</h4>
            <p class="text-muted small mb-4">Secure instant payment via SSLCommerz gateway for tour reservations.</p>

            {{-- Display session success or error messages --}}
            @if(session('success'))
                <div class="alert alert-success rounded-3 mb-3 small">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger rounded-3 mb-3 small">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('payment.pay') }}" class="w-100 d-flex justify-content-center mb-3">
                @csrf
                <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm py-2.5 px-4 text-wrap" style="max-width: 100%;">
                    Pay Now via SSLCommerz 🔒
                </button>
            </form>

            <div class="text-muted small d-flex align-items-center justify-content-center gap-1" style="font-size: 0.8rem;">
                <span>🔒 128-bit SSL Encrypted & Instant Confirmation</span>
            </div>
        </div>
    </div>
</div>
@endsection
