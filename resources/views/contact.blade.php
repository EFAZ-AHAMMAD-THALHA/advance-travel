@extends('layouts.app')

@section('title', 'Contact Support & Inquiries | Advance Travel & Tourism')

@section('content')

<div class="py-5 bg-slate-50">
    <div class="container-xl">

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 700px; margin: 0 auto;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
            <span class="badge badge-pill badge-bus mb-2">24/7 Passenger Care</span>
            <h1 class="display-6 fw-bold mb-2">Get in Touch with Advance Travel</h1>
            <p class="text-secondary small">
                Have an inquiry about routing, station pickups, ticket cancellations, or refund status? Our team is available 24/7.
            </p>
        </div>

        <div class="row g-4">
            <!-- Left Info Column -->
            <div class="col-lg-5">
                <div class="bg-white rounded-4 border p-4 p-md-5 shadow-sm h-100">
                    <h4 class="fw-bold mb-4">Contact Information</h4>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="stat-icon blue" style="width: 44px; height: 44px; font-size: 1.3rem;">
                            <i class='bx bx-phone-call'></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Passenger Helpline</div>
                            <div class="text-secondary small">+880 1700-000000 (Toll Free)</div>
                            <div class="text-muted small">Available 24 Hours, 7 Days a Week</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="stat-icon green" style="width: 44px; height: 44px; font-size: 1.3rem;">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Official Inquiries</div>
                            <div class="text-secondary small">support@advancetravel.com</div>
                            <div class="text-muted small">Response time within 2 hours</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="stat-icon amber" style="width: 44px; height: 44px; font-size: 1.3rem;">
                            <i class='bx bx-map'></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Operations Office</div>
                            <div class="text-secondary small">Sonargaon University Campus, Dhaka, Bangladesh</div>
                            <div class="text-muted small">Dept. of Computer Science & Engineering</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="stat-icon purple" style="width: 44px; height: 44px; font-size: 1.3rem;">
                            <i class='bx bx-chat'></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Emergency WhatsApp</div>
                            <div class="text-secondary small">+880 1900-112233</div>
                            <div class="text-muted small">Instant messaging support</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="p-3 rounded-3 bg-light border">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class='bx bx-check-shield text-success fs-5'></i>
                            <span class="fw-bold small text-dark">Refund Guarantee</span>
                        </div>
                        <p class="small text-secondary mb-0">
                            Bookings cancelled through the portal are automatically queued for administrative refund approval within 24 hours.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Contact Form Column -->
            <div class="col-lg-7">
                <div class="bg-white rounded-4 border p-4 p-md-5 shadow-sm">
                    <h4 class="fw-bold mb-2">Send Us a Direct Message</h4>
                    <p class="text-secondary small mb-4">Fill in the details below and an operations representative will reach out to you promptly.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 small py-2 px-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required placeholder="e.g. Tanvir Ahmed">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" required placeholder="e.g. traveler@example.com">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="e.g. 017xxxxxxxx">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Inquiry Subject</label>
                                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" placeholder="Ticket, Cancellation, Fleet Inquiry">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Message Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="message" rows="5" placeholder="Please describe how we can assist you..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-gradient px-4 py-2.5 rounded-3 fw-semibold">
                            <i class='bx bx-send me-1'></i>
                            <span>Send Message</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
