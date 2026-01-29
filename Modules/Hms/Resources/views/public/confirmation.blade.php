<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - {{ $business->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $business->name }}</h1>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">Booking Confirmed!</h2>
            <p class="text-gray-600 mb-6">Your reservation has been submitted successfully.</p>

            <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-500">Booking Reference</span>
                        <p class="font-semibold text-lg">{{ $booking->ref_no }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Status</span>
                        <p class="font-semibold text-lg capitalize">
                            <span class="px-3 py-1 rounded-full text-sm
                                {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $booking->status }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Check-in</span>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->hms_booking_arrival_date_time)->format('M d, Y - h:i A') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Check-out</span>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->hms_booking_departure_date_time)->format('M d, Y - h:i A') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                <h3 class="font-semibold mb-4">Guest Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-500">Name</span>
                        <p class="font-medium">{{ $booking->contact->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Email</span>
                        <p class="font-medium">{{ $booking->contact->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Phone</span>
                        <p class="font-medium">{{ $booking->contact->mobile ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                <h3 class="font-semibold mb-4">Room Details</h3>
                @foreach($booking->booking_lines as $line)
                <div class="flex justify-between py-2 border-b last:border-0">
                    <div>
                        <p class="font-medium">{{ $line->roomType->type ?? 'Room' }}</p>
                        <p class="text-sm text-gray-500">Room {{ $line->room->room_number ?? '' }} | {{ $line->adults }} Adults, {{ $line->childrens ?? 0 }} Children</p>
                    </div>
                    <p class="font-medium">{{ number_format($line->total_price, 2) }}</p>
                </div>
                @endforeach
            </div>

            @if($booking->booking_extras && $booking->booking_extras->count() > 0)
            <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                <h3 class="font-semibold mb-4">Additional Services</h3>
                @foreach($booking->booking_extras as $extra)
                <div class="flex justify-between py-2 border-b last:border-0">
                    <span>{{ $extra->extra->name ?? 'Extra' }} x{{ $extra->quantity }}</span>
                    <span>{{ number_format($extra->price * $extra->quantity, 2) }}</span>
                </div>
                @endforeach
            </div>
            @endif

            <div class="bg-blue-50 rounded-lg p-6 text-left">
                <h3 class="font-semibold mb-4">Payment Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>{{ number_format($booking->total_before_tax + $booking->discount_amount, 2) }}</span>
                    </div>
                    @if($booking->discount_amount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount</span>
                        <span>-{{ number_format($booking->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    @if($booking->tax_amount > 0)
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>{{ number_format($booking->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between font-bold text-lg pt-2 border-t">
                        <span>Total Amount</span>
                        <span>{{ number_format($booking->final_total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <p class="text-gray-600 mb-4">A confirmation email has been sent to your email address.</p>
                <a href="/book/{{ $business->slug ?? $business->id }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Make Another Booking
                </a>
            </div>
        </div>
    </main>
</body>
</html>
