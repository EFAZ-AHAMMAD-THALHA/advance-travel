/**
 * Advance Travel & Tourism - Live Flight & Fleet Tracker JS Engine
 * Handles dynamic AJAX status loading, search filtering, refresh action, and telemetry radar modal.
 */

document.addEventListener('DOMContentLoaded', function () {
    const statusContainer = document.getElementById('liveFlightStatusContainer');
    const refreshBtn = document.getElementById('btnRefreshFlightStatus');
    const searchInput = document.getElementById('flightSearchInput');
    const searchBtn = document.getElementById('btnSearchFlight');
    const lastUpdatedLabel = document.getElementById('flightLastUpdatedText');

    if (!statusContainer) return;

    let currentFlightData = [];

    // 1. Fetch Flight & Fleet Status Data from API
    function fetchFlightStatus(query = '') {
        if (refreshBtn) {
            const icon = refreshBtn.querySelector('i');
            if (icon) icon.classList.add('bx-spin');
            refreshBtn.disabled = true;
        }

        const url = new URL('/api/flight-status', window.location.origin);
        if (query) {
            url.searchParams.append('query', query);
        }

        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (res.success && Array.isArray(res.data)) {
                currentFlightData = res.data;
                renderFlightCards(res.data);
                if (lastUpdatedLabel) {
                    lastUpdatedLabel.innerHTML = `<i class='bx bx-time-five me-1'></i>Updated Live ${res.timestamp}`;
                }
            } else {
                renderErrorState('Unable to load live flight telemetry.');
            }
        })
        .catch(err => {
            console.error('Flight Status Fetch Error:', err);
            renderErrorState('Network error fetching flight updates.');
        })
        .finally(() => {
            if (refreshBtn) {
                const icon = refreshBtn.querySelector('i');
                if (icon) icon.classList.remove('bx-spin');
                refreshBtn.disabled = false;
            }
        });
    }

    // 2. Render Dynamic Flight Status Cards
    function renderFlightCards(flights) {
        if (flights.length === 0) {
            statusContainer.innerHTML = `
                <div class="p-4 text-center text-white-50 bg-white bg-opacity-10 rounded-3">
                    <i class='bx bx-search-alt fs-2 mb-1 d-block text-warning'></i>
                    <div class="small fw-semibold">No matching flights or fleets found</div>
                    <div class="small opacity-75">Try searching another flight code (e.g. BG-401, BS-201)</div>
                </div>
            `;
            return;
        }

        let html = '';
        flights.forEach(flight => {
            let badgeClass = 'badge-neon-success';
            let statusIcon = 'bx-circle-quarter';
            if (flight.status === 'BOARDING') {
                badgeClass = 'badge-neon-warning';
                statusIcon = 'bx-time';
            } else if (flight.status === 'IN FLIGHT') {
                badgeClass = 'badge-neon-info';
                statusIcon = 'bx-paper-plane';
            } else if (flight.status === 'DELAYED') {
                badgeClass = 'badge-neon-danger';
                statusIcon = 'bx-alarm-exclamation';
            }

            const isBookable = flight.is_bookable && flight.status !== 'BOARDING' && flight.status !== 'IN FLIGHT';
            const actionButtonHtml = isBookable ? `
                <a href="/booking?title=${encodeURIComponent(flight.airline + ' ' + flight.flight_number)}&from_location=${encodeURIComponent(flight.origin.split(' ')[0])}&to_location=${encodeURIComponent(flight.destination.split(' ')[0])}&price=${flight.price}&type=flight" class="btn btn-xs btn-success py-1 px-2.5 rounded-pill font-mono fw-bold" style="font-size: 0.72rem; box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);">
                    <i class='bx bx-check me-0.5'></i>Book
                </a>
            ` : `
                <span class="badge bg-secondary bg-opacity-50 text-white-50 py-1 px-2.5 rounded-pill font-mono border border-white border-opacity-10" style="font-size: 0.7rem;" title="Booking closed past boarding time">
                    <i class='bx bx-lock-alt me-0.5 text-warning'></i>Gate Closed
                </span>
            `;

            html += `
                <div class="flight-card-item p-3 rounded-3 mb-3 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-1 text-white">
                        <div>
                            <div class="small text-info fw-bold d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                <span class="beacon-dot"></span>
                                <i class='bx bxs-plane-alt'></i> ${flight.flight_number} • ${flight.airline}
                            </div>
                            <div class="fw-bold fs-6 mt-1 text-white" style="letter-spacing: -0.01em;">${flight.origin} ➔ ${flight.destination}</div>
                        </div>
                        <div class="text-end">
                            <div class="text-success fw-bold fs-6">৳${Number(flight.price).toLocaleString()}</div>
                            <span class="badge ${badgeClass} rounded-pill px-2.5 py-1" style="font-size: 0.68rem;">
                                <i class='bx ${statusIcon} me-0.5 align-middle'></i> ${flight.status}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center text-white-50 small pt-2 mt-1 border-top border-white border-opacity-10" style="font-size: 0.76rem;">
                        <div class="d-flex gap-3">
                            <span><i class='bx bx-time text-info me-1'></i>Dep: ${flight.departure_time}</span>
                            <span><i class='bx bx-door-open text-warning me-1'></i>Gate: ${flight.gate}</span>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <button type="button" class="btn btn-xs btn-outline-info py-1 px-2.5 rounded-pill font-mono btn-track-flight" data-id="${flight.id}" style="font-size: 0.72rem; backdrop-filter: blur(4px);">
                                <i class='bx bx-radar me-1'></i>Track Radar
                            </button>
                            ${actionButtonHtml}
                        </div>
                    </div>
                </div>
            `;
        });

        statusContainer.innerHTML = html;
        attachTrackModalListeners();
    }

    function renderErrorState(message) {
        statusContainer.innerHTML = `
            <div class="p-3 text-center text-danger-subtle bg-danger bg-opacity-20 rounded-3 border border-danger border-opacity-20">
                <i class='bx bx-error-circle fs-3 mb-1'></i>
                <div class="small fw-semibold">${message}</div>
            </div>
        `;
    }

    // 3. Attach Modal Trigger Listeners for "Track Flight" Action Button
    function attachTrackModalListeners() {
        const trackBtns = statusContainer.querySelectorAll('.btn-track-flight');
        trackBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const flightId = this.getAttribute('data-id');
                const flight = currentFlightData.find(f => f.id === flightId);
                if (flight) {
                    openFlightModal(flight);
                }
            });
        });
    }

    // 4. Open & Populate Flight Telemetry Modal
    function openFlightModal(flight) {
        const modalEl = document.getElementById('liveFlightModal');
        if (!modalEl) return;

        const isBookable = flight.is_bookable && flight.status !== 'BOARDING' && flight.status !== 'IN FLIGHT';

        document.getElementById('modalFlightTitle').textContent = `${flight.airline} (${flight.flight_number})`;
        document.getElementById('modalFlightRoute').textContent = `${flight.origin} ➔ ${flight.destination}`;
        document.getElementById('modalFlightStatusBadge').className = `badge bg-${flight.status_color} rounded-pill px-3 py-1.5 fs-6`;
        document.getElementById('modalFlightStatusBadge').textContent = flight.status;

        document.getElementById('modalAircraft').textContent = flight.aircraft;
        document.getElementById('modalGate').textContent = `${flight.terminal} / ${flight.gate}`;
        document.getElementById('modalAltitude').textContent = flight.altitude;
        document.getElementById('modalSpeed').textContent = flight.speed;
        document.getElementById('modalDepTime').textContent = flight.departure_time;
        document.getElementById('modalArrTime').textContent = flight.arrival_time;
        document.getElementById('modalSeatsLeft').textContent = isBookable ? `${flight.seats_left} seats available` : `Booking Closed (Gate Closed)`;

        const progressBar = document.getElementById('modalFlightProgressBar');
        if (progressBar) {
            progressBar.style.width = `${flight.progress_pct}%`;
        }

        const bookBtn = document.getElementById('modalBookFlightBtn');
        if (bookBtn) {
            if (isBookable) {
                bookBtn.className = 'btn btn-success px-4 rounded-pill fw-bold';
                bookBtn.removeAttribute('disabled');
                bookBtn.removeAttribute('onclick');
                bookBtn.innerHTML = `<i class='bx bx-check-circle me-1'></i> Book Flight Now`;
                bookBtn.href = `/booking?title=${encodeURIComponent(flight.airline + ' ' + flight.flight_number)}&from_location=${encodeURIComponent(flight.origin.split(' ')[0])}&to_location=${encodeURIComponent(flight.destination.split(' ')[0])}&price=${flight.price}&type=flight`;
            } else {
                bookBtn.className = 'btn btn-secondary px-4 rounded-pill fw-bold opacity-75';
                bookBtn.setAttribute('disabled', 'true');
                bookBtn.setAttribute('onclick', 'return false;');
                bookBtn.innerHTML = `<i class='bx bx-lock-alt me-1'></i> Booking Closed (Gate Closed)`;
                bookBtn.href = '#';
            }
        }

        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    }

    // 5. Event Listeners
    if (refreshBtn) {
        refreshBtn.addEventListener('click', () => {
            const query = searchInput ? searchInput.value.trim() : '';
            fetchFlightStatus(query);
        });
    }

    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            fetchFlightStatus(searchInput.value.trim());
        });

        searchInput.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                fetchFlightStatus(searchInput.value.trim());
            }
        });
    }

    // Initial Load
    fetchFlightStatus();
});
