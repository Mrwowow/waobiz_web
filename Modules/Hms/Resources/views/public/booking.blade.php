<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Now - {{ $business->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .room-card { transition: all 0.3s ease; }
        .room-card:hover { transform: translateY(-5px); box-shadow: 0 10px 40px rgba(0,0,0,0.15); }
        .room-card.selected { border-color: #3b82f6; background-color: #eff6ff; }
        .step { display: none; }
        .step.active { display: block; }
        .step-indicator { transition: all 0.3s ease; }
        .step-indicator.active { background-color: #3b82f6; color: white; }
        .step-indicator.completed { background-color: #10b981; color: white; }
        .loading { opacity: 0.5; pointer-events: none; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $business->name }}</h1>
                    <p class="text-gray-600">Online Reservation</p>
                </div>
                @if($business->logo)
                    <img src="{{ asset('uploads/business_logos/' . $business->logo) }}" alt="{{ $business->name }}" class="h-12">
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Progress Steps -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4">
                <div class="step-indicator active flex items-center justify-center w-10 h-10 rounded-full bg-gray-200" data-step="1">1</div>
                <div class="w-16 h-1 bg-gray-200"></div>
                <div class="step-indicator flex items-center justify-center w-10 h-10 rounded-full bg-gray-200" data-step="2">2</div>
                <div class="w-16 h-1 bg-gray-200"></div>
                <div class="step-indicator flex items-center justify-center w-10 h-10 rounded-full bg-gray-200" data-step="3">3</div>
            </div>
        </div>

        <form id="booking-form">
            <!-- Step 1: Select Dates & Rooms -->
            <div class="step active" id="step-1">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Select Your Stay Dates</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                            <input type="text" id="arrival_date" name="arrival_date" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Select date" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                            <input type="text" id="departure_date" name="departure_date" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Select date" required>
                        </div>
                    </div>
                    <button type="button" id="check-availability" class="mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Check Availability
                    </button>
                </div>

                <!-- Available Rooms -->
                <div id="rooms-container" class="hidden">
                    <h2 class="text-xl font-semibold mb-4">Available Rooms</h2>
                    <div id="rooms-list" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Rooms will be loaded here -->
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" id="to-step-2" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition disabled:opacity-50" disabled>
                        Continue to Guest Details
                    </button>
                </div>
            </div>

            <!-- Step 2: Guest Details -->
            <div class="step" id="step-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Guest Information</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="guest_name" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="guest_email" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" name="guest_phone" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <input type="text" name="guest_address" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                        <textarea name="special_requests" rows="3" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Any special requirements..."></textarea>
                    </div>

                    @if($extras->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium mb-3">Additional Services</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($extras as $extra)
                            <div class="flex items-center justify-between p-4 border rounded-lg">
                                <div>
                                    <span class="font-medium">{{ $extra->name }}</span>
                                    <span class="text-gray-600 ml-2">{{ number_format($extra->price, 2) }}</span>
                                </div>
                                <input type="number" name="extras[{{ $extra->id }}]" value="0" min="0" max="10" class="w-20 px-3 py-2 border rounded-lg text-center">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" class="back-btn px-8 py-3 border rounded-lg hover:bg-gray-100 transition">Back</button>
                    <button type="button" id="to-step-3" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                        Review Booking
                    </button>
                </div>
            </div>

            <!-- Step 3: Review & Confirm -->
            <div class="step" id="step-3">
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Booking Summary</h2>
                        <div id="booking-summary">
                            <!-- Summary will be loaded here -->
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg p-6 h-fit">
                        <h3 class="text-lg font-semibold mb-4">Price Details</h3>
                        <div id="price-details">
                            <!-- Price details will be loaded here -->
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Code</label>
                            <div class="flex gap-2">
                                <input type="text" name="coupon_code" id="coupon_code" class="flex-1 px-4 py-2 border rounded-lg">
                                <button type="button" id="apply-coupon" class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">Apply</button>
                            </div>
                            <p id="coupon-message" class="text-sm mt-2"></p>
                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span id="total-amount">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="agree_terms" class="mr-2" required>
                        <span class="text-sm text-gray-600">I agree to the terms and conditions</span>
                    </label>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" class="back-btn px-8 py-3 border rounded-lg hover:bg-gray-100 transition">Back</button>
                    <button type="submit" id="submit-booking" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition">
                        Confirm Booking
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const businessSlug = "{{ $business->slug ?? $business->id }}";
        let selectedRooms = [];
        let currentStep = 1;
        let bookingData = {};

        // Initialize date pickers
        flatpickr("#arrival_date", {
            minDate: "today",
            dateFormat: "Y-m-d",
            onChange: function(dates, dateStr) {
                departure_fp.set('minDate', new Date(dates[0].getTime() + 86400000));
            }
        });

        const departure_fp = flatpickr("#departure_date", {
            minDate: new Date().fp_incr(1),
            dateFormat: "Y-m-d"
        });

        // Check availability
        document.getElementById('check-availability').addEventListener('click', async function() {
            const arrival = document.getElementById('arrival_date').value;
            const departure = document.getElementById('departure_date').value;

            if (!arrival || !departure) {
                alert('Please select both dates');
                return;
            }

            this.textContent = 'Checking...';
            this.disabled = true;

            try {
                const response = await fetch(`/book/${businessSlug}/check-availability?arrival_date=${arrival}&departure_date=${departure}`);
                const data = await response.json();

                if (data.success) {
                    renderRooms(data.data, data.nights);
                    document.getElementById('rooms-container').classList.remove('hidden');
                } else {
                    alert(data.message || 'Failed to check availability');
                }
            } catch (error) {
                alert('Error checking availability');
            } finally {
                this.textContent = 'Check Availability';
                this.disabled = false;
            }
        });

        function renderRooms(rooms, nights) {
            const container = document.getElementById('rooms-list');
            container.innerHTML = rooms.map(room => `
                <div class="room-card bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer" data-room-id="${room.id}">
                    ${room.image_url ? `<img src="${room.image_url}" alt="${room.type}" class="w-full h-48 object-cover">` : '<div class="w-full h-48 bg-gray-200 flex items-center justify-center"><span class="text-gray-400">No image</span></div>'}
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">${room.type}</h3>
                        <p class="text-gray-600 text-sm mt-1">${room.description || ''}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span>Max: ${room.max_occupancy} guests</span>
                            <span class="mx-2">|</span>
                            <span>${room.available_count} available</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold">${room.price_per_night.toFixed(2)}</span>
                                <span class="text-gray-500">/night</span>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">${nights} nights</div>
                                <div class="font-semibold">${room.total_price.toFixed(2)} total</div>
                            </div>
                        </div>
                        ${room.available_count > 0 ? `
                        <div class="mt-4 flex items-center gap-2">
                            <label class="text-sm">Adults:</label>
                            <select class="adults-select border rounded px-2 py-1" data-room-id="${room.id}">
                                ${Array.from({length: room.no_of_adult}, (_, i) => `<option value="${i+1}">${i+1}</option>`).join('')}
                            </select>
                            <label class="text-sm ml-2">Children:</label>
                            <select class="children-select border rounded px-2 py-1" data-room-id="${room.id}">
                                ${Array.from({length: (room.no_of_child || 0) + 1}, (_, i) => `<option value="${i}">${i}</option>`).join('')}
                            </select>
                        </div>
                        <button type="button" class="add-room-btn mt-3 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700" data-room='${JSON.stringify(room)}'>
                            Add Room
                        </button>
                        ` : '<button class="mt-3 w-full bg-gray-300 text-gray-500 py-2 rounded-lg cursor-not-allowed" disabled>Not Available</button>'}
                    </div>
                </div>
            `).join('');

            // Add click handlers
            document.querySelectorAll('.add-room-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const room = JSON.parse(this.dataset.room);
                    const card = this.closest('.room-card');
                    const adults = card.querySelector('.adults-select').value;
                    const children = card.querySelector('.children-select').value;

                    selectedRooms.push({
                        room_type_id: room.id,
                        type: room.type,
                        price: room.price_per_night,
                        total: room.total_price,
                        adults: parseInt(adults),
                        children: parseInt(children)
                    });

                    card.classList.add('selected');
                    this.textContent = 'Added';
                    this.disabled = true;

                    document.getElementById('to-step-2').disabled = false;
                });
            });
        }

        // Navigation
        document.getElementById('to-step-2').addEventListener('click', () => goToStep(2));
        document.getElementById('to-step-3').addEventListener('click', () => {
            updateBookingSummary();
            goToStep(3);
        });

        document.querySelectorAll('.back-btn').forEach(btn => {
            btn.addEventListener('click', () => goToStep(currentStep - 1));
        });

        function goToStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
            document.getElementById(`step-${step}`).classList.add('active');

            document.querySelectorAll('.step-indicator').forEach(ind => {
                const s = parseInt(ind.dataset.step);
                ind.classList.remove('active', 'completed');
                if (s < step) ind.classList.add('completed');
                if (s === step) ind.classList.add('active');
            });

            currentStep = step;
            window.scrollTo(0, 0);
        }

        async function updateBookingSummary() {
            const arrival = document.getElementById('arrival_date').value;
            const departure = document.getElementById('departure_date').value;
            const extras = {};

            document.querySelectorAll('input[name^="extras"]').forEach(input => {
                const id = input.name.match(/\d+/)[0];
                extras[id] = parseInt(input.value) || 0;
            });

            const response = await fetch(`/book/${businessSlug}/calculate-total`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    rooms: selectedRooms,
                    extras: extras,
                    arrival_date: arrival,
                    departure_date: departure,
                    coupon_code: document.getElementById('coupon_code').value
                })
            });

            const data = await response.json();

            if (data.success) {
                renderSummary(data.data);
                bookingData = data.data;
            }
        }

        function renderSummary(data) {
            const arrival = document.getElementById('arrival_date').value;
            const departure = document.getElementById('departure_date').value;
            const guestName = document.querySelector('input[name="guest_name"]').value;
            const guestEmail = document.querySelector('input[name="guest_email"]').value;

            document.getElementById('booking-summary').innerHTML = `
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium">Stay Dates</h4>
                        <p class="text-gray-600">${arrival} to ${departure}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium">Guest</h4>
                        <p class="text-gray-600">${guestName || 'Not provided'}</p>
                        <p class="text-gray-600">${guestEmail || 'Not provided'}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium">Rooms</h4>
                        ${data.rooms.map(r => `
                            <div class="flex justify-between py-2 border-b">
                                <span>${r.room_type} (${r.quantity}x)</span>
                                <span>${r.subtotal.toFixed(2)}</span>
                            </div>
                        `).join('')}
                    </div>
                    ${data.extras.length > 0 ? `
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium">Extras</h4>
                        ${data.extras.map(e => `
                            <div class="flex justify-between py-2 border-b">
                                <span>${e.name} (${e.quantity}x)</span>
                                <span>${e.subtotal.toFixed(2)}</span>
                            </div>
                        `).join('')}
                    </div>
                    ` : ''}
                </div>
            `;

            document.getElementById('price-details').innerHTML = `
                <div class="space-y-2">
                    <div class="flex justify-between"><span>Rooms</span><span>${data.room_total.toFixed(2)}</span></div>
                    <div class="flex justify-between"><span>Extras</span><span>${data.extras_total.toFixed(2)}</span></div>
                    <div class="flex justify-between"><span>Subtotal</span><span>${data.subtotal.toFixed(2)}</span></div>
                    ${data.discount > 0 ? `<div class="flex justify-between text-green-600"><span>Discount</span><span>-${data.discount.toFixed(2)}</span></div>` : ''}
                    ${data.tax_amount > 0 ? `<div class="flex justify-between"><span>Tax (${data.tax_rate}%)</span><span>${data.tax_amount.toFixed(2)}</span></div>` : ''}
                </div>
            `;

            document.getElementById('total-amount').textContent = data.total.toFixed(2);
        }

        // Apply coupon
        document.getElementById('apply-coupon').addEventListener('click', async function() {
            await updateBookingSummary();
            const msg = document.getElementById('coupon-message');
            if (bookingData.coupon_valid) {
                msg.textContent = bookingData.coupon_message;
                msg.className = 'text-sm mt-2 text-green-600';
            } else {
                msg.textContent = bookingData.coupon_message;
                msg.className = 'text-sm mt-2 text-red-600';
            }
        });

        // Submit booking
        document.getElementById('booking-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!document.querySelector('input[name="agree_terms"]').checked) {
                alert('Please agree to the terms and conditions');
                return;
            }

            const submitBtn = document.getElementById('submit-booking');
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;

            const formData = new FormData(this);
            const data = {
                guest_name: formData.get('guest_name'),
                guest_email: formData.get('guest_email'),
                guest_phone: formData.get('guest_phone'),
                guest_address: formData.get('guest_address'),
                arrival_date: formData.get('arrival_date'),
                departure_date: formData.get('departure_date'),
                rooms: selectedRooms,
                extras: {},
                coupon_code: formData.get('coupon_code'),
                special_requests: formData.get('special_requests')
            };

            document.querySelectorAll('input[name^="extras"]').forEach(input => {
                const id = input.name.match(/\d+/)[0];
                data.extras[id] = parseInt(input.value) || 0;
            });

            try {
                const response = await fetch(`/book/${businessSlug}/store`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = result.redirect_url;
                } else {
                    alert(result.message || 'Booking failed. Please try again.');
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
            } finally {
                submitBtn.textContent = 'Confirm Booking';
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
