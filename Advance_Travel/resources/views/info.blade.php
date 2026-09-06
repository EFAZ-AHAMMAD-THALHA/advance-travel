@extends('layouts.app')

@section('title', 'About Us | Advance Travel & Tourism')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow p-4">

                <h1 class="text-center">About <span class="text-primary">Us</span></h1>

                <!-- 1st Person -->
                <div class="d-flex align-items-center my-4 about-member">
                    <img 
                        src="{{ asset('assets/files/misty.jpeg') }}" 
                        class="img-fluid rounded-circle" 
                        alt="Admin"
                        style="max-width: 200px;"
                    >
                    <div class="ms-4 member-info">
                        <h5 class="mb-1">Md. Amir Shorif Misty</h5>
                        <p class="mb-0">ID: CSE-2203027142</p>
                        <p class="mb-0">Sec: 27M2, Dept. of CSE</p>
                        <p class="mb-0">Sonargaon University</p>
                    </div>
                </div>

                <!-- 2nd Person -->
                <div class="d-flex align-items-center my-4 about-member">
                    <img 
                        src="{{ asset('assets/files/rakib.jpeg') }}" 
                        class="img-fluid rounded-circle" 
                        alt="Admin"
                        style="max-width: 200px;"
                    >
                    <div class="ms-4 member-info">
                        <h5 class="mb-1">Md. Abdur Rakib </h5>
                        <p class="mb-0">ID: CSE-2203027141</p>
                        <p class="mb-0">Sec: 27M2, Dept. of CSE</p>
                        <p class="mb-0">Sonargaon University</p>
                    </div>
                </div>

                <!-- 3rd Person -->
                <div class="d-flex align-items-center my-4 about-member">
                    <img 
                        src="{{ asset('assets/files/thalha.jpeg') }}" 
                        class="img-fluid rounded-circle" 
                        alt="Admin"
                        style="max-width: 200px;"
                    >
                    <div class="ms-4 member-info">
                        <h5 class="mb-1">Md. Efaz Ahammad Thalha</h5>
                        <p class="mb-0">ID: CSE-2203027172</p>
                        <p class="mb-0">Sec: 27M2, Dept. of CSE</p>
                        <p class="mb-0">Sonargaon University</p>
                    </div>
                </div>

                <hr>

                <p class="text-muted">
                    Adventour is a travel website project developed by Najmul using HTML, CSS, and Laravel.
                    Our team is composed of skilled professionals who are experts in their respective fields.
                    We continuously strive for excellence and innovation, constantly seeking ways to improve
                    and exceed customer expectations.
                    <br><br>

                    We believe in building long-lasting relationships with our customers, partners, and stakeholders.
                    By prioritizing transparency, integrity, and open communication, we foster trust and mutual respect
                    in all our interactions.
                    <br><br>

                    Thank you for taking the time to learn more about us. We appreciate your interest and look forward
                    to the opportunity to serve you. If you have any questions or would like to know more,
                    please don't hesitate to contact us.
                </p>

                <div class="text-center">
                    <a 
                        href="https://linkedin.com/comm/mynetwork/discovery-see-all?usecase=PEOPLE_FOLLOWS&followMember=md-najmul-huda-tutul-71a39530a"
                        class="btn btn-primary my-3"
                        target="_blank"
                    >
                        Connect with me!
                    </a>

                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <a href="https://www.facebook.com/share/1EvVhUbVth/" target="_blank">
                            <i class='bx bxl-facebook fs-3'></i>
                        </a>

                        <a href="https://www.instagram.com/th_najmul_110?igsh=MXE5MjFqeXg2aXplMg==&utm_source=ig_contact_invite" target="_blank">
                            <i class='bx bxl-instagram fs-3'></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
