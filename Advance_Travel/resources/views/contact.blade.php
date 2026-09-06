@extends('layouts.app')

@section('title', 'Contact Us | Advance Travel & Tourism')

@section('content')

<div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">

            <div class="card shadow p-4">
                <div class="text-center mb-4">
                    <h2>Contact <span class="text-primary">Us</span></h2>
                    <hr class="mb-3">
                    <p class="text-muted">
                        We value your feedback, inquiries, and suggestions. Whether you have a question about our services,
                        need assistance, or simply want to share your thoughts, reach out here.
                    </p>
                </div>

                <form action="#" method="POST">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="myname" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone *</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Subject *</label>
                            <input type="text" class="form-control" name="subject" placeholder="What brings you here?" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message *</label>
                        <textarea class="form-control" name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5 text-nowrap"
                            onclick="alert('Thank you! \nYour response was submitted')">
                            Submit
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

@endsection
