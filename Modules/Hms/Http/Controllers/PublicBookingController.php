<?php

namespace Modules\Hms\Http\Controllers;

use App\Business;
use App\Contact;
use App\TaxRate;
use App\Utils\BusinessUtil;
use App\Utils\ContactUtil;
use App\Utils\ModuleUtil;
use App\Utils\NotificationUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Hms\Entities\HmsBookingExtra;
use Modules\Hms\Entities\HmsBookingLine;
use Modules\Hms\Entities\HmsExtra;
use Modules\Hms\Entities\HmsRoom;
use Modules\Hms\Entities\HmsRoomType;
use Modules\Hms\Entities\HmsRoomTypePricing;
use Modules\Hms\Entities\HmsTransactionClass;
use Modules\Hms\Entities\HmsCoupon;
use Modules\Hms\Notifications\CustomerNotification;
use Notification;

class PublicBookingController extends Controller
{
    protected $commonUtil;
    protected $notificationUtil;
    protected $contactUtil;
    protected $transactionUtil;
    protected $moduleUtil;
    protected $businessUtil;

    public function __construct(
        Util $commonUtil,
        NotificationUtil $notificationUtil,
        ContactUtil $contactUtil,
        TransactionUtil $transactionUtil,
        ModuleUtil $moduleUtil,
        BusinessUtil $businessUtil
    ) {
        $this->commonUtil = $commonUtil;
        $this->notificationUtil = $notificationUtil;
        $this->contactUtil = $contactUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->businessUtil = $businessUtil;
    }

    /**
     * Find business by slug or ID
     */
    private function findBusiness($identifier)
    {
        // Try to find by slug first, then by ID
        return Business::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->first();
    }

    /**
     * Display the public booking page
     */
    public function index($business_slug)
    {
        $business = $this->findBusiness($business_slug);

        if (!$business) {
            abort(404, 'Business not found');
        }

        $business_id = $business->id;

        // Check if HMS module is installed
        if (!$this->moduleUtil->isModuleInstalled('Hms')) {
            abort(404, 'Booking not available');
        }

        // Check if public booking is enabled
        $hms_settings = $this->getHmsSettings($business_id);
        if (empty($hms_settings['enable_public_booking'])) {
            abort(404, 'Online booking is not available');
        }

        // Get room types with images
        $room_types = HmsRoomType::where('business_id', $business_id)
            ->with(['media', 'Rooms'])
            ->get()
            ->map(function ($type) {
                $type->available_rooms_count = $type->Rooms->count();
                $type->amenities_list = !empty($type->amenities) ? json_decode($type->amenities, true) : [];
                $type->image_url = $type->media->first() ? $type->media->first()->display_url : null;
                return $type;
            });

        // Get extras
        $extras = HmsExtra::where('business_id', $business_id)->get();

        return view('hms::public.booking', compact(
            'business',
            'room_types',
            'extras',
            'hms_settings'
        ));
    }

    /**
     * Check room availability (AJAX)
     */
    public function checkAvailability(Request $request, $business_slug)
    {
        $business = $this->findBusiness($business_slug);

        if (!$business) {
            return response()->json(['success' => false, 'message' => 'Business not found'], 404);
        }

        $business_id = $business->id;

        $validator = Validator::make($request->all(), [
            'arrival_date' => 'required|date|after_or_equal:today',
            'departure_date' => 'required|date|after:arrival_date',
            'room_type_id' => 'nullable|exists:hms_room_types,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $arrival_date = Carbon::parse($request->arrival_date)->format('Y-m-d');
        $departure_date = Carbon::parse($request->departure_date)->format('Y-m-d');
        $arrival_datetime = $arrival_date . ' 14:00:00';
        $departure_datetime = $departure_date . ' 11:00:00';

        $room_types = HmsRoomType::where('business_id', $business_id)
            ->with(['media', 'Pricings'])
            ->get();

        $available_rooms = [];

        foreach ($room_types as $type) {
            if ($request->room_type_id && $type->id != $request->room_type_id) {
                continue;
            }

            $non_booked_rooms = HmsRoom::non_booking_rooms(
                $type->id,
                $arrival_datetime,
                $departure_datetime,
                [],
                $arrival_date,
                $departure_date
            );

            $nights = Carbon::parse($arrival_date)->diffInDays(Carbon::parse($departure_date));
            $price_per_night = $this->getRoomPrice($type, $arrival_date, $departure_date, $business_id);
            $total_price = $price_per_night * $nights;

            $available_rooms[] = [
                'id' => $type->id,
                'type' => $type->type,
                'description' => $type->description,
                'max_occupancy' => $type->max_occupancy,
                'no_of_adult' => $type->no_of_adult,
                'no_of_child' => $type->no_of_child,
                'amenities' => !empty($type->amenities) ? json_decode($type->amenities, true) : [],
                'available_count' => count($non_booked_rooms),
                'price_per_night' => $price_per_night,
                'total_price' => $total_price,
                'nights' => $nights,
                'image_url' => $type->media->first() ? $type->media->first()->display_url : null,
                'rooms' => $non_booked_rooms
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $available_rooms,
            'arrival_date' => $arrival_date,
            'departure_date' => $departure_date,
            'nights' => Carbon::parse($arrival_date)->diffInDays(Carbon::parse($departure_date))
        ]);
    }

    /**
     * Get room price considering special pricing
     */
    private function getRoomPrice($room_type, $arrival_date, $departure_date, $business_id)
    {
        $special_pricing = HmsRoomTypePricing::where('hms_room_type_id', $room_type->id)
            ->where('start_date', '<=', $arrival_date)
            ->where('end_date', '>=', $departure_date)
            ->first();

        if ($special_pricing) {
            return $special_pricing->price;
        }

        return $room_type->price ?? 0;
    }

    /**
     * Calculate booking total (AJAX)
     */
    public function calculateTotal(Request $request, $business_slug)
    {
        $business = $this->findBusiness($business_slug);

        if (!$business) {
            return response()->json(['success' => false, 'message' => 'Business not found'], 404);
        }

        $business_id = $business->id;

        $rooms = $request->input('rooms', []);
        $extras = $request->input('extras', []);
        $coupon_code = $request->input('coupon_code');
        $arrival_date = $request->input('arrival_date');
        $departure_date = $request->input('departure_date');

        $nights = Carbon::parse($arrival_date)->diffInDays(Carbon::parse($departure_date));

        $room_total = 0;
        $room_details = [];

        foreach ($rooms as $room) {
            $room_type = HmsRoomType::find($room['room_type_id']);
            if ($room_type) {
                $price = $this->getRoomPrice($room_type, $arrival_date, $departure_date, $business_id);
                $quantity = $room['quantity'] ?? 1;
                $subtotal = $price * $nights * $quantity;
                $room_total += $subtotal;

                $room_details[] = [
                    'room_type' => $room_type->type,
                    'quantity' => $quantity,
                    'price_per_night' => $price,
                    'nights' => $nights,
                    'subtotal' => $subtotal
                ];
            }
        }

        $extras_total = 0;
        $extras_details = [];

        foreach ($extras as $extra_id => $quantity) {
            if ($quantity > 0) {
                $extra = HmsExtra::find($extra_id);
                if ($extra) {
                    $subtotal = $extra->price * $quantity;
                    $extras_total += $subtotal;

                    $extras_details[] = [
                        'name' => $extra->name,
                        'quantity' => $quantity,
                        'price' => $extra->price,
                        'subtotal' => $subtotal
                    ];
                }
            }
        }

        $subtotal = $room_total + $extras_total;
        $discount = 0;
        $coupon_valid = false;
        $coupon_message = '';

        if ($coupon_code) {
            $coupon = HmsCoupon::where('business_id', $business_id)
                ->where('code', $coupon_code)
                ->where('status', 'active')
                ->first();

            if ($coupon) {
                if ($coupon->discount_type == 'percentage') {
                    $discount = ($subtotal * $coupon->discount_value) / 100;
                    if ($coupon->max_discount && $discount > $coupon->max_discount) {
                        $discount = $coupon->max_discount;
                    }
                } else {
                    $discount = $coupon->discount_value;
                }
                $coupon_valid = true;
                $coupon_message = 'Coupon applied successfully!';
            } else {
                $coupon_message = 'Invalid or expired coupon code';
            }
        }

        $hms_settings = $this->getHmsSettings($business_id);
        $tax_rate = 0;
        $tax_amount = 0;

        if (!empty($hms_settings['tax_id'])) {
            $tax = TaxRate::find($hms_settings['tax_id']);
            if ($tax) {
                $tax_rate = $tax->amount;
                $tax_amount = (($subtotal - $discount) * $tax_rate) / 100;
            }
        }

        $total = $subtotal - $discount + $tax_amount;

        return response()->json([
            'success' => true,
            'data' => [
                'rooms' => $room_details,
                'extras' => $extras_details,
                'room_total' => round($room_total, 2),
                'extras_total' => round($extras_total, 2),
                'subtotal' => round($subtotal, 2),
                'discount' => round($discount, 2),
                'tax_rate' => $tax_rate,
                'tax_amount' => round($tax_amount, 2),
                'total' => round($total, 2),
                'coupon_valid' => $coupon_valid,
                'coupon_message' => $coupon_message
            ]
        ]);
    }

    /**
     * Store a new public booking
     */
    public function store(Request $request, $business_slug)
    {
        $business = $this->findBusiness($business_slug);

        if (!$business) {
            return response()->json(['success' => false, 'message' => 'Business not found'], 404);
        }

        $business_id = $business->id;

        $validator = Validator::make($request->all(), [
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'arrival_date' => 'required|date|after_or_equal:today',
            'departure_date' => 'required|date|after:arrival_date',
            'rooms' => 'required|array|min:1',
            'rooms.*.room_type_id' => 'required|exists:hms_room_types,id',
            'rooms.*.adults' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $arrival_date = Carbon::parse($request->arrival_date)->format('Y-m-d');
            $departure_date = Carbon::parse($request->departure_date)->format('Y-m-d');
            $arrival_datetime = $arrival_date . ' 14:00:00';
            $departure_datetime = $departure_date . ' 11:00:00';
            $nights = Carbon::parse($arrival_date)->diffInDays(Carbon::parse($departure_date));

            // Create or find contact
            $contact = Contact::where('business_id', $business_id)
                ->where(function ($q) use ($request) {
                    $q->where('email', $request->guest_email)
                        ->orWhere('mobile', $request->guest_phone);
                })
                ->first();

            if (!$contact) {
                $contact = Contact::create([
                    'business_id' => $business_id,
                    'type' => 'customer',
                    'name' => $request->guest_name,
                    'email' => $request->guest_email,
                    'mobile' => $request->guest_phone,
                    'address_line_1' => $request->guest_address ?? '',
                    'created_by' => null,
                    'contact_status' => 'active'
                ]);
            }

            $room_total = 0;
            $booking_lines = [];

            foreach ($request->rooms as $room_data) {
                $room_type = HmsRoomType::find($room_data['room_type_id']);
                $price = $this->getRoomPrice($room_type, $arrival_date, $departure_date, $business_id);

                $available_rooms = HmsRoom::non_booking_rooms(
                    $room_data['room_type_id'],
                    $arrival_datetime,
                    $departure_datetime,
                    array_column($booking_lines, 'hms_room_id'),
                    $arrival_date,
                    $departure_date
                );

                if (empty($available_rooms)) {
                    throw new \Exception("No rooms available for {$room_type->type}");
                }

                $room_id = array_key_first($available_rooms);
                $total_price = $price * $nights;
                $room_total += $total_price;

                $booking_lines[] = [
                    'hms_room_id' => $room_id,
                    'hms_room_type_id' => $room_data['room_type_id'],
                    'adults' => $room_data['adults'],
                    'childrens' => $room_data['children'] ?? 0,
                    'price' => $price,
                    'total_price' => $total_price
                ];
            }

            $extras_total = 0;
            $booking_extras = [];

            if ($request->has('extras')) {
                foreach ($request->extras as $extra_id => $quantity) {
                    if ($quantity > 0) {
                        $extra = HmsExtra::find($extra_id);
                        if ($extra) {
                            $subtotal = $extra->price * $quantity;
                            $extras_total += $subtotal;

                            $booking_extras[] = [
                                'hms_extra_id' => $extra_id,
                                'quantity' => $quantity,
                                'price' => $extra->price
                            ];
                        }
                    }
                }
            }

            $subtotal = $room_total + $extras_total;
            $discount = 0;

            if ($request->coupon_code) {
                $coupon = HmsCoupon::where('business_id', $business_id)
                    ->where('code', $request->coupon_code)
                    ->where('status', 'active')
                    ->first();

                if ($coupon) {
                    if ($coupon->discount_type == 'percentage') {
                        $discount = ($subtotal * $coupon->discount_value) / 100;
                        if ($coupon->max_discount && $discount > $coupon->max_discount) {
                            $discount = $coupon->max_discount;
                        }
                    } else {
                        $discount = $coupon->discount_value;
                    }
                }
            }

            $hms_settings = $this->getHmsSettings($business_id);
            $tax_amount = 0;

            if (!empty($hms_settings['tax_id'])) {
                $tax = TaxRate::find($hms_settings['tax_id']);
                if ($tax) {
                    $tax_amount = (($subtotal - $discount) * $tax->amount) / 100;
                }
            }

            $final_total = $subtotal - $discount + $tax_amount;

            $ref_count = HmsTransactionClass::where('business_id', $business_id)
                ->where('type', 'hms_booking')
                ->count() + 1;
            $ref_no = 'BK-' . str_pad($ref_count, 5, '0', STR_PAD_LEFT);

            $transaction = HmsTransactionClass::create([
                'business_id' => $business_id,
                'location_id' => $business->locations->first()->id ?? null,
                'type' => 'hms_booking',
                'status' => 'pending',
                'contact_id' => $contact->id,
                'ref_no' => $ref_no,
                'transaction_date' => now(),
                'hms_booking_arrival_date_time' => $arrival_datetime,
                'hms_booking_departure_date_time' => $departure_datetime,
                'total_before_tax' => $subtotal - $discount,
                'tax_amount' => $tax_amount,
                'tax_id' => $hms_settings['tax_id'] ?? null,
                'discount_type' => 'fixed',
                'discount_amount' => $discount,
                'final_total' => $final_total,
                'additional_notes' => $request->special_requests ?? '',
                'hms_reason_for_trip' => $request->reason_for_trip ?? '',
                'created_by' => null,
                'is_public_booking' => 1
            ]);

            foreach ($booking_lines as $line) {
                HmsBookingLine::create([
                    'transaction_id' => $transaction->id,
                    'hms_room_id' => $line['hms_room_id'],
                    'hms_room_type_id' => $line['hms_room_type_id'],
                    'adults' => $line['adults'],
                    'childrens' => $line['childrens'],
                    'price' => $line['price'],
                    'total_price' => $line['total_price']
                ]);
            }

            foreach ($booking_extras as $extra) {
                HmsBookingExtra::create([
                    'transaction_id' => $transaction->id,
                    'hms_extra_id' => $extra['hms_extra_id'],
                    'quantity' => $extra['quantity'],
                    'price' => $extra['price']
                ]);
            }

            DB::commit();

            try {
                $this->sendBookingNotification($transaction, $business, $contact);
            } catch (\Exception $e) {
                Log::error('Failed to send booking notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking submitted successfully!',
                'data' => [
                    'booking_ref' => $ref_no,
                    'transaction_id' => $transaction->id,
                    'total' => $final_total
                ],
                'redirect_url' => url("/book/{$business_slug}/confirmation/{$ref_no}")
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Public booking failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show booking confirmation page
     */
    public function confirmation($business_slug, $ref_no)
    {
        $business = $this->findBusiness($business_slug);

        if (!$business) {
            abort(404, 'Business not found');
        }

        $booking = HmsTransactionClass::where('business_id', $business->id)
            ->where('ref_no', $ref_no)
            ->with(['contact', 'booking_lines.room', 'booking_lines.roomType', 'booking_extras.extra'])
            ->first();

        if (!$booking) {
            abort(404, 'Booking not found');
        }

        return view('hms::public.confirmation', compact('business', 'booking'));
    }

    /**
     * Get HMS settings for a business
     */
    private function getHmsSettings($business_id)
    {
        $business = Business::find($business_id);
        $settings = $business->hms_settings ?? [];

        if (is_string($settings)) {
            $settings = json_decode($settings, true) ?? [];
        }

        return $settings;
    }

    /**
     * Send booking notification
     */
    private function sendBookingNotification($transaction, $business, $contact)
    {
        if ($contact->email) {
            try {
                Notification::route('mail', $contact->email)
                    ->notify(new CustomerNotification($transaction));
            } catch (\Exception $e) {
                Log::error('Guest notification failed: ' . $e->getMessage());
            }
        }

        $owner = $business->owner;
        if ($owner && $owner->email) {
            try {
                Notification::route('mail', $owner->email)
                    ->notify(new CustomerNotification($transaction));
            } catch (\Exception $e) {
                Log::error('Owner notification failed: ' . $e->getMessage());
            }
        }
    }
}
