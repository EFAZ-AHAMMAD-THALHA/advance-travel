/**
 * Advance Travel & Tourism - City Autocomplete & Search Suggestions
 * High-performance, accessible dropdown suggestions for origin & destination inputs.
 */

const BD_CITIES = [
    { name: 'Dhaka', desc: 'Kamalapur Rail, Gabtoli, Mohakhali, Sayedabad', icon: 'bx-building', tag: 'Central Hub' },
    { name: 'Chattogram', desc: 'Dampara, GEC Circle, BR Railway Station', icon: 'bx-train', tag: 'Port City' },
    { name: 'Cox\'s Bazar', desc: 'Kolatoli Beach, Dolphin Mor, Marine Drive', icon: 'bx-water', tag: 'Top Tourist' },
    { name: 'Sylhet', desc: 'Kadamtoli Terminal, Amberkhana, Rail Station', icon: 'bx-leaf', tag: 'Tea Valley' },
    { name: 'Rajshahi', desc: 'Siroil Central, Railway Station', icon: 'bx-train', tag: 'Silk City' },
    { name: 'Khulna', desc: 'Sonadanga Central, Rupsha Terminal', icon: 'bx-anchor', tag: 'Sundarbans' },
    { name: 'Sajek Valley', desc: 'Ruilui Para, Rangamati Hill Tracts', icon: 'bx-cloud', tag: 'Cloud Queen' },
    { name: 'Sreemangal', desc: 'Tea Resort Area, Sreemangal Station', icon: 'bx-coffee', tag: 'Rainforest' },
    { name: 'Saint Martin', desc: 'Teknaf Jetty, Coral Island', icon: 'bx-sun', tag: 'Island' },
    { name: 'Bogura', desc: 'Charmatha Central, Thana Mor', icon: 'bx-map-pin', tag: 'North Hub' },
    { name: 'Rangpur', desc: 'Modern Mor Terminal, Kamarpara', icon: 'bx-map-pin', tag: 'Division' },
    { name: 'Barisal', desc: 'Nathullabad Terminal, Launch Ghat', icon: 'bx-water', tag: 'River Hub' },
    { name: 'Kuakata', desc: 'Zero Point Beach, Kalapara', icon: 'bx-sun', tag: 'Sea Beach' },
    { name: 'Bandarban', desc: 'Traffic Mor, Nilgiri, Chimbuk', icon: 'bx-landscape', tag: 'Hill District' },
    { name: 'Comilla', desc: 'Paduar Bazar, Shashongachha', icon: 'bx-map-pin', tag: 'East Hub' },
    { name: 'Mymensingh', desc: 'Maskanda Bus Terminal', icon: 'bx-map-pin', tag: 'Division' },
    { name: 'Jessore', desc: 'Chowrasta, Benapole Border Port', icon: 'bx-bus', tag: 'Border City' },
    { name: 'Dinajpur', desc: 'Medical Mor, Central Terminal', icon: 'bx-map-pin', tag: 'North' }
];

function initCityAutocomplete() {
    const inputs = document.querySelectorAll('.city-search-input');

    inputs.forEach(input => {
        const dropdownId = input.getAttribute('data-dropdown');
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return;

        const listContainer = dropdown.querySelector('.city-suggestion-list');

        function renderList(query = '') {
            const q = query.trim().toLowerCase();
            const filtered = q === '' 
                ? BD_CITIES 
                : BD_CITIES.filter(c => c.name.toLowerCase().includes(q) || c.desc.toLowerCase().includes(q));

            if (filtered.length === 0) {
                listContainer.innerHTML = `
                    <div class="p-3 text-center text-muted small">
                        <i class='bx bx-search-alt fs-5 d-block mb-1 opacity-50'></i>
                        No destinations matching "${query}".
                    </div>
                `;
                return;
            }

            listContainer.innerHTML = filtered.map((c, idx) => `
                <div class="city-suggestion-item" data-city="${c.name}" tabindex="0">
                    <div class="city-item-icon">
                        <i class='bx ${c.icon}'></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="city-item-name">${c.name}</span>
                            <span class="badge bg-light text-secondary border rounded-pill" style="font-size: 0.65rem;">${c.tag}</span>
                        </div>
                        <div class="city-item-desc text-truncate">${c.desc}</div>
                    </div>
                </div>
            `).join('');

            // Attach click listeners to items
            listContainer.querySelectorAll('.city-suggestion-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const cityName = this.getAttribute('data-city');
                    input.value = cityName;
                    dropdown.classList.remove('show');
                    // Dispatch change event
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });
        }

        // Show on focus / click
        input.addEventListener('focus', function() {
            renderList(this.value);
            dropdown.classList.add('show');
        });

        input.addEventListener('click', function(e) {
            e.stopPropagation();
            renderList(this.value);
            dropdown.classList.add('show');
        });

        // Filter on input
        input.addEventListener('input', function() {
            renderList(this.value);
            dropdown.classList.add('show');
        });

        // Keyboard arrow navigation
        input.addEventListener('keydown', function(e) {
            if (!dropdown.classList.contains('show')) {
                if (e.key === 'ArrowDown') {
                    dropdown.classList.add('show');
                    renderList(this.value);
                }
                return;
            }

            const items = listContainer.querySelectorAll('.city-suggestion-item');
            const activeItem = listContainer.querySelector('.city-suggestion-item.active-item');
            let index = Array.from(items).indexOf(activeItem);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (index < items.length - 1) {
                    if (activeItem) activeItem.classList.remove('active-item');
                    items[index + 1].classList.add('active-item');
                    items[index + 1].scrollIntoView({ block: 'nearest' });
                } else if (items.length > 0 && index === -1) {
                    items[0].classList.add('active-item');
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (index > 0) {
                    if (activeItem) activeItem.classList.remove('active-item');
                    items[index - 1].classList.add('active-item');
                    items[index - 1].scrollIntoView({ block: 'nearest' });
                }
            } else if (e.key === 'Enter') {
                if (activeItem) {
                    e.preventDefault();
                    input.value = activeItem.getAttribute('data-city');
                    dropdown.classList.remove('show');
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            } else if (e.key === 'Escape') {
                dropdown.classList.remove('show');
            }
        });
    });

    // Dropdown trigger toggle buttons
    document.querySelectorAll('.city-dropdown-trigger').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const targetId = this.getAttribute('data-target');
            const dropdown = document.getElementById(targetId);
            if (!dropdown) return;
            const input = dropdown.closest('.city-autocomplete-wrapper').querySelector('.city-search-input');

            const isShown = dropdown.classList.contains('show');
            // Close all first
            document.querySelectorAll('.city-suggestion-menu').forEach(d => d.classList.remove('show'));

            if (!isShown) {
                dropdown.classList.add('show');
                if (input) {
                    input.focus();
                }
            }
        });
    });

    // Close on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.city-autocomplete-wrapper')) {
            document.querySelectorAll('.city-suggestion-menu').forEach(d => d.classList.remove('show'));
        }
    });
}

// Location swap helper
function swapCities(fromInputId = 'fromInput', toInputId = 'toInput') {
    const fromEl = document.getElementById(fromInputId);
    const toEl = document.getElementById(toInputId);
    if (!fromEl || !toEl) return;

    const temp = fromEl.value;
    fromEl.value = toEl.value;
    toEl.value = temp;

    fromEl.dispatchEvent(new Event('input', { bubbles: true }));
    fromEl.dispatchEvent(new Event('change', { bubbles: true }));
    toEl.dispatchEvent(new Event('input', { bubbles: true }));
    toEl.dispatchEvent(new Event('change', { bubbles: true }));
}

// Quick Destination selector function
function selectDestination(destinationName, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    const toInput = document.getElementById('toInput') || document.getElementById('toInputExplore');

    if (toInput) {
        toInput.value = destinationName;
        toInput.dispatchEvent(new Event('input', { bubbles: true }));
        toInput.dispatchEvent(new Event('change', { bubbles: true }));

        // Visual focus & outline feedback
        toInput.focus();
        toInput.classList.add('ring-highlight');
        setTimeout(() => {
            toInput.classList.remove('ring-highlight');
        }, 1800);

        // Smooth scroll to search form
        const searchContainer = document.getElementById('heroSearchForm') || 
                                document.querySelector('.search-widget-card') || 
                                document.querySelector('form[action*="explore"]');
        if (searchContainer) {
            searchContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } else {
        // Redirect to explore page with destination set if not on search page
        window.location.href = "/explore?to=" + encodeURIComponent(destinationName);
    }
}

// Quick Route setter function (From & To)
function setQuickRoute(from, to, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    const fromInput = document.getElementById('fromInput') || document.getElementById('fromInputExplore');
    const toInput = document.getElementById('toInput') || document.getElementById('toInputExplore');

    if (fromInput && toInput) {
        fromInput.value = from;
        toInput.value = to;
        fromInput.dispatchEvent(new Event('input', { bubbles: true }));
        fromInput.dispatchEvent(new Event('change', { bubbles: true }));
        toInput.dispatchEvent(new Event('input', { bubbles: true }));
        toInput.dispatchEvent(new Event('change', { bubbles: true }));

        toInput.focus();
        toInput.classList.add('ring-highlight');
        setTimeout(() => {
            toInput.classList.remove('ring-highlight');
        }, 1800);

        const searchContainer = document.getElementById('heroSearchForm') || 
                                document.querySelector('.search-widget-card') || 
                                document.querySelector('form[action*="explore"]');
        if (searchContainer) {
            searchContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

document.addEventListener('DOMContentLoaded', initCityAutocomplete);

