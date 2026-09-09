@extends('layouts.app')

@section('title', 'e-Ticket #' . $booking->booking_code . ' | Advance Travel')

@section('content')
<div class="py-5 bg-slate-50">
    <div class="container-xl ticket-wrapper">

        <!-- Action Bar (Hidden on Print) -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 no-print">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('my.bookings') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-1.5 fw-semibold">
                    <i class='bx bx-arrow-back me-1'></i> Back to My Bookings
                </a>
                <!-- Tab Mode Toggle -->
                <div class="btn-group bg-white p-1 rounded-pill border shadow-xs" role="group">
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold active" id="btnShowTicket" onclick="switchView('ticket')">
                        <i class='bx bx-id-card me-1'></i> Boarding Pass
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill px-3 fw-semibold text-secondary" id="btnShowRadar" onclick="switchView('radar')">
                        <i class='bx bx-radar me-1 text-danger'></i> Live Fleet Radar
                    </button>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('booking.verify', $booking->booking_code) }}" target="_blank" class="btn btn-light border rounded-pill px-3 py-1.5 fw-semibold text-dark shadow-xs">
                    <i class='bx bx-check-shield text-success me-1'></i> Verify Ticket
                </a>
                <button onclick="window.print()" class="btn btn-primary-gradient rounded-pill px-4 py-1.5 fw-semibold shadow-sm">
                    <i class='bx bx-printer me-1'></i> Print / Save as PDF
                </button>
                @if($booking->payment_status === 'unpaid' && $booking->status !== 'cancelled')
                    <a href="{{ route('payment.checkout', $booking->id) }}" class="btn btn-success rounded-pill px-3.5 py-1.5 fw-bold">
                        💳 Pay ৳{{ number_format($booking->total_price, 0) }}
                    </a>
                @endif
            </div>
        </div>

        <!-- VIEW 1: Official Boarding Pass -->
        <div id="viewTicketCard" class="boarding-pass">
            <!-- Ticket Header -->
            <div class="ticket-header d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="brand-icon-box" style="width: 44px; height: 44px; font-size: 1.4rem;">
                        <i class='bx bxs-compass'></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white">Advance Travel & Tourism</h4>
                        <small class="text-white-50">Official Electronic Boarding Pass & Reservation Voucher</small>
                    </div>
                </div>
                <div class="text-end mt-2 mt-sm-0">
                    <span class="badge {{ $booking->transport_type === 'flight' ? 'badge-flight' : ($booking->transport_type === 'bus' ? 'badge-bus' : ($booking->transport_type === 'train' ? 'badge-train' : 'badge-tour')) }} badge-pill mb-1">
                        {{ strtoupper($booking->transport_type) }} TICKET
                    </span>
                    <div class="font-monospace text-light small">PNR: <strong>{{ $booking->booking_code }}</strong></div>
                </div>
            </div>

            <!-- Route Banner Bar -->
            <div class="bg-light px-4 py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="fw-bold text-dark fs-5">{{ $booking->from_city }}</div>
                    <div class="text-primary fs-4 d-flex align-items-center">
                        <i class='bx bx-right-arrow-alt'></i>
                    </div>
                    <div class="fw-bold text-dark fs-5">{{ $booking->to_city }}</div>
                </div>
                <div>
                    <span class="badge {{ $booking->status === 'confirmed' ? 'badge-status-confirmed' : ($booking->status === 'cancelled' ? 'badge-status-cancelled' : 'badge-status-pending') }} badge-pill">
                        STATUS: {{ strtoupper($booking->status) }}
                    </span>
                </div>
            </div>

            <!-- Ticket Details Grid -->
            <div class="p-4 p-md-5">
                <div class="row g-4">
                    <!-- Main Itinerary -->
                    <div class="col-md-8">
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Passenger Name</span>
                                <h5 class="fw-bold text-dark mb-0 mt-1">{{ $booking->passenger_name }}</h5>
                                <small class="text-secondary"><i class='bx bx-phone me-1'></i>{{ $booking->phone }}</small>
                            </div>

                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Contact Email</span>
                                <div class="fw-semibold text-dark mt-1 text-truncate">{{ $booking->email }}</div>
                                <small class="text-secondary">E-Ticket Confirmed</small>
                            </div>

                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Date of Journey</span>
                                <div class="fs-5 fw-bold text-primary mt-1">
                                    {{ \Carbon\Carbon::parse($booking->journey_date ?? $booking->check_in_date)->format('D, M d, Y') }}
                                </div>
                                @if($booking->return_date)
                                    <small class="text-secondary">Return: {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</small>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Seats & Class</span>
                                <div class="fs-5 fw-bold text-dark mt-1">
                                    @if($booking->selected_seats)
                                        <span class="badge bg-primary text-white fs-6 px-2.5 py-1 me-1">{{ $booking->selected_seats }}</span>
                                        <small class="text-muted fw-normal">({{ $booking->seats }} Seat{{ $booking->seats > 1 ? 's' : '' }})</small>
                                    @else
                                        {{ $booking->seats }} Seat(s)
                                    @endif
                                </div>
                                <small class="text-secondary">{{ $booking->room_type }}</small>
                            </div>

                            <div class="col-12">
                                <span class="text-secondary small fw-bold text-uppercase d-block">Package / Operator Service</span>
                                <div class="fw-bold text-dark mt-1">{{ $booking->package_title ?? 'Advance Travel Intercity Express' }}</div>
                            </div>
                        </div>

                        <!-- Boarding Notice -->
                        <div class="p-3 rounded-3 bg-light border small text-secondary">
                            <div class="fw-bold text-dark mb-1"><i class='bx bx-info-circle text-primary me-1'></i>Passenger Notice:</div>
                            Please arrive at the station terminal at least 20 minutes before scheduled departure. Present this digital e-ticket or a printed copy along with a valid National ID or Student ID.
                        </div>
                    </div>

                    <!-- Right Stub / Verification Column -->
                    <div class="col-md-4 border-start-md ps-md-4">
                        <div class="text-center p-3 rounded-3 bg-light border mb-3">
                            <!-- Clickable / Scannable QR Code -->
                            <a href="{{ route('booking.verify', $booking->booking_code) }}" target="_blank" title="Click or Scan to Verify Official Ticket" class="d-inline-block text-decoration-none">
                                <div class="bg-white p-2 rounded-3 shadow-xs border mb-2 hover-scale" style="transition: transform 0.2s ease;">
                                    <svg width="110" height="110" viewBox="0 0 100 100" fill="none">
                                        <rect width="100" height="100" fill="white"/>
                                        <!-- QR pattern simulator -->
                                        <rect x="10" y="10" width="25" height="25" fill="#0f172a"/>
                                        <rect x="15" y="15" width="15" height="15" fill="white"/>
                                        <rect x="18" y="18" width="9" height="9" fill="#0f172a"/>
                                        <rect x="65" y="10" width="25" height="25" fill="#0f172a"/>
                                        <rect x="70" y="15" width="15" height="15" fill="white"/>
                                        <rect x="73" y="18" width="9" height="9" fill="#0f172a"/>
                                        <rect x="10" y="65" width="25" height="25" fill="#0f172a"/>
                                        <rect x="15" y="70" width="15" height="15" fill="white"/>
                                        <rect x="18" y="73" width="9" height="9" fill="#0f172a"/>
                                        <rect x="42" y="12" width="6" height="6" fill="#0f172a"/>
                                        <rect x="52" y="20" width="6" height="6" fill="#0f172a"/>
                                        <rect x="42" y="42" width="16" height="16" fill="#0f172a"/>
                                        <rect x="65" y="45" width="8" height="8" fill="#0f172a"/>
                                        <rect x="78" y="55" width="8" height="8" fill="#0f172a"/>
                                        <rect x="45" y="75" width="12" height="12" fill="#0f172a"/>
                                        <rect x="68" y="78" width="18" height="8" fill="#0f172a"/>
                                    </svg>
                                </div>
                            </a>
                            <div class="small fw-bold text-dark font-monospace">{{ $booking->booking_code }}</div>
                            <div class="text-primary small fw-semibold" style="font-size: 0.75rem;">
                                <i class='bx bx-check-shield me-0.5'></i> Click to Verify Clearance
                            </div>
                        </div>

                        <!-- Financial Summary -->
                        <div class="mb-3">
                            @if($booking->discount_amount > 0)
                                <div class="d-flex justify-content-between small text-secondary mb-1">
                                    <span>Base Fare:</span>
                                    <span>৳{{ number_format(($booking->unit_price * $booking->seats), 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between small text-success mb-1">
                                    <span>Discount ({{ $booking->promo_code }}):</span>
                                    <span>-৳{{ number_format($booking->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between small text-secondary mb-1">
                                <span>Total Fare:</span>
                                <strong class="text-success fs-6">৳{{ number_format($booking->total_price, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between small text-secondary mb-1">
                                <span>Payment Mode:</span>
                                <span class="fw-semibold text-dark">{{ strtoupper($booking->payment_method ?? 'ONLINE') }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-secondary">
                                <span>Payment Status:</span>
                                <span class="badge {{ $booking->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-2">
                                    {{ $booking->payment_status === 'paid' ? 'VERIFIED PAID' : 'UNPAID / PENDING' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perforated Divider -->
            <div class="ticket-divider"></div>

            <!-- Bottom Barcode Strip -->
            <div class="p-4 bg-light text-center">
                <div class="barcode-strip mx-auto mb-2" style="max-width: 480px;"></div>
                <div class="font-monospace text-secondary small">
                    *{{ $booking->booking_code }}* • ISSUED BY ADVANCE TRAVEL & TOURISM BANGLADESH
                </div>
            </div>
        </div>

        <!-- VIEW 2: Live Fleet Radar & GPS Tracking Module -->
        <div id="viewRadarCard" class="bg-white rounded-4 border shadow-sm overflow-hidden d-none no-print">
            <!-- Radar Header -->
            <div class="p-4 bg-slate-900 text-white d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="radar-pulse-icon">
                        <i class='bx bx-radar fs-3 text-warning'></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-white">Live Fleet GPS Radar</h4>
                        <small class="text-slate-300">Satellite-synced vehicle tracking & checkpoint telemetry</small>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-1.5 fw-bold">
                        ● LIVE TRANSMITTING
                    </span>
                </div>
            </div>

            <!-- Telemetry Metrics Bar -->
            <div class="bg-light px-4 py-3 border-bottom row g-3 text-center text-sm-start align-items-center">
                <div class="col-sm-3 col-6">
                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Assigned Fleet Unit</div>
                    <div class="fw-bold text-dark font-monospace">AT-{{ substr(md5($booking->booking_code), 0, 4) }} ({{ strtoupper($booking->transport_type) }})</div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Current Cruise Speed</div>
                    <div class="fw-bold text-primary"><span id="speedIndicator">68</span> km/h • Highway Speed</div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Estimated Arrival (ETA)</div>
                    <div class="fw-bold text-success" id="etaIndicator">1 hr 15 min Remaining</div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">GPS Coordinates</div>
                    <div class="fw-bold text-dark font-monospace small" id="coordsIndicator">23.8103° N, 90.4125° E</div>
                </div>
            </div>

            <!-- Route Checkpoints Progress Timeline -->
            <div class="p-4 p-md-5">
                <h5 class="fw-bold text-dark mb-4">Route Checkpoints & Transit Status</h5>

                <div class="tracking-timeline position-relative ps-4 ps-md-5">
                    <!-- Vertical connecting line -->
                    <div class="timeline-line"></div>

                    <!-- Step 1: Origin Terminal -->
                    <div class="timeline-item mb-4 position-relative">
                        <div class="timeline-dot completed">
                            <i class='bx bx-check'></i>
                        </div>
                        <div class="timeline-content p-3 rounded-3 bg-light border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold text-dark mb-0">{{ $booking->from_city }} Central Terminal</h6>
                                <span class="badge bg-success-subtle text-success rounded-pill">DEPARTED</span>
                            </div>
                            <p class="text-secondary small mb-0">Vehicle cleared boarding inspection and departed terminal on scheduled time.</p>
                        </div>
                    </div>

                    <!-- Step 2: Tollway Hub -->
                    <div class="timeline-item mb-4 position-relative">
                        <div class="timeline-dot completed">
                            <i class='bx bx-check'></i>
                        </div>
                        <div class="timeline-content p-3 rounded-3 bg-light border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold text-dark mb-0">National Expressway Toll Plaza Gate</h6>
                                <span class="badge bg-success-subtle text-success rounded-pill">PASSED</span>
                            </div>
                            <p class="text-secondary small mb-0">Automated RFID fast-tag pass recorded at expressway toll checkpoint.</p>
                        </div>
                    </div>

                    <!-- Step 3: Mid-Way Checkpoint (Current Location) -->
                    <div class="timeline-item mb-4 position-relative">
                        <div class="timeline-dot current">
                            <i class='bx bx-current-location bx-spin'></i>
                        </div>
                        <div class="timeline-content p-3 rounded-3 bg-primary-subtle border border-primary border-opacity-25">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold text-primary mb-0">Highway Oasis Transit Hub (Mid-way)</h6>
                                <span class="badge bg-primary text-white rounded-pill pulse-badge">CURRENT POSITION</span>
                            </div>
                            <p class="text-primary-emphasis small mb-0">Vehicle is en route between transit waypoints. Speed steady with smooth traffic flow.</p>
                        </div>
                    </div>

                    <!-- Step 4: Destination Arrival -->
                    <div class="timeline-item position-relative">
                        <div class="timeline-dot pending">
                            <i class='bx bx-flag'></i>
                        </div>
                        <div class="timeline-content p-3 rounded-3 bg-light border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold text-dark mb-0">{{ $booking->to_city }} Destination Terminal</h6>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">UPCOMING</span>
                            </div>
                            <p class="text-secondary small mb-0">Expected arrival at terminal bay. Baggage claim assistance will be available upon arrival.</p>
                        </div>
                    </div>
                </div>

                <!-- Simulation Info Banner -->
                <div class="mt-4 p-3 rounded-3 bg-light border text-muted small d-flex align-items-center gap-2">
                    <i class='bx bx-info-circle text-primary fs-5'></i>
                    <span>Telemetry simulation is refreshed in real-time based on GPS transponder data emitted by the vehicle unit.</span>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function switchView(mode) {
        const ticketCard = document.getElementById('viewTicketCard');
        const radarCard = document.getElementById('viewRadarCard');
        const btnTicket = document.getElementById('btnShowTicket');
        const btnRadar = document.getElementById('btnShowRadar');

        if (mode === 'ticket') {
            ticketCard.classList.remove('d-none');
            radarCard.classList.add('d-none');
            btnTicket.classList.add('active', 'btn-primary');
            btnTicket.classList.remove('text-secondary');
            btnRadar.classList.remove('active', 'btn-primary');
            btnRadar.classList.add('text-secondary');
        } else {
            ticketCard.classList.add('d-none');
            radarCard.classList.remove('d-none');
            btnRadar.classList.add('active', 'btn-primary');
            btnRadar.classList.remove('text-secondary');
            btnTicket.classList.remove('active', 'btn-primary');
            btnTicket.classList.add('text-secondary');
        }
    }

    // Live Speed and GPS micro-variation simulation
    setInterval(() => {
        const speedEl = document.getElementById('speedIndicator');
        if (speedEl) {
            const currentSpeed = 65 + Math.floor(Math.random() * 8);
            speedEl.textContent = currentSpeed;
        }
    }, 4000);
</script>
@endpush
@endsection
