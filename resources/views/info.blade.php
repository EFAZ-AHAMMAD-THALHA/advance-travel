@extends('layouts.app')

@section('title', 'About Project & Team | Advance Travel & Tourism')

@section('content')

<div class="py-5 bg-slate-50">
    <div class="container-xl">

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-5" style="max-width: 750px; margin: 0 auto;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-2 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Project</li>
                </ol>
            </nav>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fw-bold text-uppercase mb-2">
                University Capstone Project Showcase
            </span>
            <h1 class="display-6 fw-bold mb-2">Advance Travel & Tourism Platform</h1>
            <p class="text-secondary small">
                An intelligent, multi-modal web engineering project engineered by students of the Department of Computer Science & Engineering, Sonargaon University.
            </p>
        </div>

        <!-- Academic & Architecture Overview -->
        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="bg-white rounded-4 border p-4 p-md-5 shadow-sm h-100">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-icon-box">
                            <i class='bx bx-code-alt'></i>
                        </div>
                        <h4 class="fw-bold mb-0">Project Mission & Architecture</h4>
                    </div>

                    <p class="text-secondary" style="line-height: 1.7;">
                        <strong>Advance Travel & Tourism</strong> was developed to modernize transportation booking systems across Bangladesh. The platform unites intercity luxury bus fleets, intercity express railway services, and all-inclusive guided tour packages into a single unified portal.
                    </p>

                    <p class="text-secondary" style="line-height: 1.7;">
                        Engineered with strict academic best practices: zero duplicate booking vulnerabilities, robust date verification gates (<code class="bg-light text-primary px-1 rounded">after_or_equal:today</code>), RFC-compliant email validation, Bangladeshi phone format verification, dynamic seat calculation, automated cancellation with refund processing, and airline-grade digital boarding pass generation with printable stylesheet support.
                    </p>

                    <hr class="my-4">

                    <!-- Tech Stack Badges -->
                    <h6 class="fw-bold mb-3 text-dark"><i class='bx bx-layer text-primary me-1'></i>Core Engineering Stack</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1.5 fw-semibold">
                            <i class='bx bxl-php me-1'></i>PHP 8.2+
                        </span>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1.5 fw-semibold">
                            <i class='bx bxl-laravel me-1'></i>Laravel 12 MVC
                        </span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fw-semibold">
                            <i class='bx bxl-bootstrap me-1'></i>Bootstrap 5.3
                        </span>
                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-1.5 fw-semibold">
                            <i class='bx bx-data me-1'></i>SQLite / Eloquent ORM
                        </span>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1.5 fw-semibold">
                            <i class='bx bx-shield-quarter me-1'></i>CSRF & Bcrypt Auth
                        </span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1.5 fw-semibold">
                            <i class='bx bx-check-shield me-1'></i>PHPUnit Feature Tests
                        </span>
                    </div>
                </div>
            </div>

            <!-- Academic Info Card -->
            <div class="col-lg-4">
                <div class="bg-white rounded-4 border p-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1 fw-bold small mb-3">
                            Academic Profile
                        </span>
                        <h5 class="fw-bold mb-1">Sonargaon University</h5>
                        <div class="text-primary fw-semibold small mb-3">Department of Computer Science & Engineering</div>

                        <ul class="list-unstyled small text-secondary mb-4">
                            <li class="mb-2">
                                <i class='bx bx-book-bookmark text-primary me-2'></i>
                                <strong>Course:</strong> Final Capstone Web Project
                            </li>
                            <li class="mb-2">
                                <i class='bx bx-group text-primary me-2'></i>
                                <strong>Section:</strong> 27M2
                            </li>
                            <li class="mb-2">
                                <i class='bx bx-calendar text-primary me-2'></i>
                                <strong>Academic Year:</strong> 2026
                            </li>
                            <li class="mb-2">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                <strong>Status:</strong> Complete Production Ready
                            </li>
                        </ul>
                    </div>

                    <div class="p-3 rounded-3 bg-light border">
                        <div class="fw-bold text-dark small mb-1">Administrative Demo Access:</div>
                        <div class="text-secondary small">Email: <code>admin@travel.com</code></div>
                        <div class="text-secondary small">Password: <code>password123</code></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Engineering Team Cards -->
        <div class="mb-5">
            <div class="text-center mb-4">
                <span class="badge badge-pill badge-bus mb-2">Contributors</span>
                <h3 class="fw-bold mb-1">Project Development Team</h3>
                <p class="text-secondary small">Department of Computer Science & Engineering, Section 27M2</p>
            </div>

            <div class="row g-4">
                <!-- Member 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="travel-card text-center p-4">
                        <div class="mx-auto mb-3" style="width: 120px; height: 120px;">
                            <img src="{{ asset('assets/files/misty.jpeg') }}" 
                                 class="rounded-circle shadow-sm border border-3 border-primary w-100 h-100 object-fit-cover" 
                                 alt="Md. Amir Shorif Misty"
                                 onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80'">
                        </div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small fw-bold mb-2">Full-Stack Developer</span>
                        <h5 class="fw-bold text-dark mb-1">Md. Amir Shorif Misty</h5>
                        <div class="text-secondary small mb-1"><strong>ID:</strong> CSE-2203027142</div>
                        <div class="text-secondary small mb-3">Sec: 27M2, Dept. of CSE</div>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-light text-secondary border px-2.5 py-1 small">Architecture</span>
                            <span class="badge bg-light text-secondary border px-2.5 py-1 small">Controllers</span>
                        </div>
                    </div>
                </div>

                <!-- Member 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="travel-card text-center p-4">
                        <div class="mx-auto mb-3" style="width: 120px; height: 120px;">
                            <img src="{{ asset('assets/files/rakib.jpeg') }}" 
                                 class="rounded-circle shadow-sm border border-3 border-info w-100 h-100 object-fit-cover" 
                                 alt="Md. Abdur Rakib"
                                 onerror="this.src='https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80'">
                        </div>
                        <span class="badge bg-info-subtle text-info rounded-pill px-3 py-1 small fw-bold mb-2">Database & Security</span>
                        <h5 class="fw-bold text-dark mb-1">Md. Abdur Rakib</h5>
                        <div class="text-secondary small mb-1"><strong>ID:</strong> CSE-2203027141</div>
                        <div class="text-secondary small mb-3">Sec: 27M2, Dept. of CSE</div>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-light text-secondary border px-2.5 py-1 small">Database Schema</span>
                            <span class="badge bg-light text-secondary border px-2.5 py-1 small">Auth Logic</span>
                        </div>
                    </div>
                </div>

                <!-- Member 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="travel-card text-center p-4">
                        <div class="mx-auto mb-3" style="width: 120px; height: 120px;">
                            <img src="{{ asset('assets/files/thalha.jpeg') }}" 
                                 class="rounded-circle shadow-sm border border-3 border-warning w-100 h-100 object-fit-cover" 
                                 alt="Md. Efaz Ahammad Thalha"
                                 onerror="this.src='https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80'">
                        </div>
                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1 small fw-bold mb-2">Frontend & UI/UX</span>
                        <h5 class="fw-bold text-dark mb-1">Md. Efaz Ahammad Thalha</h5>
                        <div class="text-secondary small mb-1"><strong>ID:</strong> CSE-2203027172</div>
                        <div class="text-secondary small mb-3">Sec: 27M2, Dept. of CSE</div>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-light text-secondary border px-2.5 py-1 small">Blade Templates</span>
                            <span class="badge bg-light text-secondary border px-2.5 py-1 small">Modern UI/UX</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
