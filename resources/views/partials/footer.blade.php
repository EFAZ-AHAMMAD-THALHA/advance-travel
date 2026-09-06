<footer class="site-footer">
    <div class="container-xl">
        <div class="row g-4">

            <!-- Brand & Mission -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="brand-icon-box">
                        <i class='bx bxs-compass'></i>
                    </div>
                    <span class="fw-bold fs-4 text-white">Advance<span style="color: #38bdf8;">Travel</span></span>
                </div>
                <p class="small text-secondary pe-lg-4 mb-4" style="line-height: 1.6;">
                    The next-generation smart transportation and tourism platform in Bangladesh. Book intercity bus seats, express train journeys, and curated holiday packages with instant digital boarding passes and guaranteed refunds.
                </p>
                <div class="d-flex gap-2">
                    <a href="https://www.facebook.com" target="_blank" class="btn btn-sm btn-dark rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);">
                        <i class='bx bxl-facebook fs-5'></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="btn btn-sm btn-dark rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);">
                        <i class='bx bxl-instagram fs-5'></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="btn btn-sm btn-dark rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);">
                        <i class='bx bxl-twitter fs-5'></i>
                    </a>
                    <a href="https://github.com" target="_blank" class="btn btn-sm btn-dark rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);">
                        <i class='bx bxl-github fs-5'></i>
                    </a>
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6>Navigation</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('explore') }}">Bus & Train Tickets</a></li>
                    <li><a href="{{ route('package') }}">Holiday Packages</a></li>
                    <li><a href="{{ route('locations') }}">Destinations</a></li>
                    <li><a href="{{ route('my.bookings') }}">My Bookings</a></li>
                    <li><a href="{{ route('info') }}">About Project</a></li>
                </ul>
            </div>

            <!-- Popular Routes -->
            <div class="col-lg-3 col-md-6 col-6">
                <h6>Popular Routes</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('explore', ['search' => 'Cox\'s Bazar']) }}"><i class='bx bx-right-arrow-alt me-1 text-primary'></i>Dhaka ➔ Cox's Bazar</a></li>
                    <li><a href="{{ route('explore', ['search' => 'Sylhet']) }}"><i class='bx bx-right-arrow-alt me-1 text-primary'></i>Dhaka ➔ Sylhet Express</a></li>
                    <li><a href="{{ route('explore', ['search' => 'Chattogram']) }}"><i class='bx bx-right-arrow-alt me-1 text-primary'></i>Dhaka ➔ Chattogram</a></li>
                    <li><a href="{{ route('explore', ['search' => 'Rajshahi']) }}"><i class='bx bx-right-arrow-alt me-1 text-primary'></i>Dhaka ➔ Rajshahi Silk City</a></li>
                    <li><a href="{{ route('explore', ['search' => 'Sajek']) }}"><i class='bx bx-right-arrow-alt me-1 text-primary'></i>Chittagong ➔ Sajek Valley</a></li>
                </ul>
            </div>

            <!-- Capstone Team & Support -->
            <div class="col-lg-3 col-md-6">
                <h6>Capstone Project Team</h6>
                <ul class="list-unstyled small mb-3 text-secondary">
                    <li class="mb-1"><i class='bx bx-user-circle me-1 text-info'></i>Md. Amir Shorif Misty</li>
                    <li class="mb-1"><i class='bx bx-user-circle me-1 text-info'></i>Md. Abdur Rakib</li>
                    <li class="mb-1"><i class='bx bx-user-circle me-1 text-info'></i>Md. Efaz Ahammad Thalha</li>
                </ul>
                <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="small fw-bold text-white mb-1"><i class='bx bx-phone-call me-1 text-success'></i>24/7 Passenger Support</div>
                    <div class="small text-secondary">+880 1700-000000</div>
                    <div class="small text-secondary">support@advancetravel.com</div>
                </div>
            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="text-secondary small">
                © 2026 Advance Travel & Tourism System. All rights reserved. Capstone CSE Project.
            </div>
            <div class="d-flex align-items-center gap-3 text-secondary small">
                <span class="badge bg-dark border border-secondary border-opacity-25 px-2 py-1">bKash</span>
                <span class="badge bg-dark border border-secondary border-opacity-25 px-2 py-1">Nagad</span>
                <span class="badge bg-dark border border-secondary border-opacity-25 px-2 py-1">Rocket</span>
                <span class="badge bg-dark border border-secondary border-opacity-25 px-2 py-1">Visa / Master</span>
            </div>
        </div>
    </div>
</footer>
