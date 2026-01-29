<?php

namespace Modules\Hms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Hms\Entities\HmsRoomType;
use Modules\Hms\Entities\HmsRoom;
use Modules\Hms\Entities\HmsRoomTypePricing;
use Modules\Hms\Entities\HmsExtra;

class HmsTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $businessId = 1; // Waobiz admin account
        $createdBy = 1;  // Admin user

        // Create Room Types
        $roomTypes = [
            [
                'type' => 'Standard Room',
                'no_of_adult' => 2,
                'no_of_child' => 1,
                'max_occupancy' => 3,
                'amenities' => 'WiFi,TV,Air Conditioning,Mini Fridge',
                'description' => 'Comfortable standard room with essential amenities. Perfect for solo travelers or couples.',
                'business_id' => $businessId,
                'created_by' => $createdBy,
            ],
            [
                'type' => 'Deluxe Room',
                'no_of_adult' => 2,
                'no_of_child' => 2,
                'max_occupancy' => 4,
                'amenities' => 'WiFi,Smart TV,Air Conditioning,Mini Bar,Safe Box,Coffee Maker',
                'description' => 'Spacious deluxe room with premium amenities and city view.',
                'business_id' => $businessId,
                'created_by' => $createdBy,
            ],
            [
                'type' => 'Executive Suite',
                'no_of_adult' => 2,
                'no_of_child' => 2,
                'max_occupancy' => 4,
                'amenities' => 'WiFi,Smart TV,Air Conditioning,Mini Bar,Safe Box,Coffee Maker,Jacuzzi,Living Area',
                'description' => 'Luxurious executive suite with separate living area and premium amenities.',
                'business_id' => $businessId,
                'created_by' => $createdBy,
            ],
            [
                'type' => 'Family Room',
                'no_of_adult' => 3,
                'no_of_child' => 3,
                'max_occupancy' => 6,
                'amenities' => 'WiFi,TV,Air Conditioning,Mini Fridge,Microwave,Extra Beds',
                'description' => 'Large family room perfect for families with children. Includes extra beds.',
                'business_id' => $businessId,
                'created_by' => $createdBy,
            ],
            [
                'type' => 'Presidential Suite',
                'no_of_adult' => 2,
                'no_of_child' => 2,
                'max_occupancy' => 4,
                'amenities' => 'WiFi,Smart TV,Air Conditioning,Full Bar,Safe Box,Coffee Maker,Jacuzzi,Living Area,Dining Area,Kitchen,Butler Service',
                'description' => 'The ultimate luxury experience with panoramic views, private butler service, and world-class amenities.',
                'business_id' => $businessId,
                'created_by' => $createdBy,
            ],
        ];

        $createdRoomTypes = [];
        foreach ($roomTypes as $roomType) {
            $createdRoomTypes[] = HmsRoomType::create($roomType);
        }

        // Create Rooms for each Room Type
        $roomNumbers = [
            0 => ['101', '102', '103', '104', '105', '201', '202', '203', '204', '205'], // Standard
            1 => ['301', '302', '303', '304', '305', '401', '402', '403'],              // Deluxe
            2 => ['501', '502', '503', '504'],                                          // Executive
            3 => ['601', '602', '603'],                                                  // Family
            4 => ['701', '702'],                                                         // Presidential
        ];

        foreach ($createdRoomTypes as $index => $roomType) {
            foreach ($roomNumbers[$index] as $roomNumber) {
                HmsRoom::create([
                    'hms_room_type_id' => $roomType->id,
                    'room_number' => $roomNumber,
                ]);
            }
        }

        // Create Pricing for each Room Type (Regular and Peak Season)
        $pricing = [
            // Standard Room
            [
                'hms_room_type_id' => $createdRoomTypes[0]->id,
                'season_type' => 'regular',
                'default_price_per_night' => 5000.00,
                'adults' => 2,
                'childrens' => 1,
                'price_monday' => 5000.00,
                'price_tuesday' => 5000.00,
                'price_wednesday' => 5000.00,
                'price_thursday' => 5000.00,
                'price_friday' => 6000.00,
                'price_saturday' => 6500.00,
                'price_sunday' => 5500.00,
            ],
            [
                'hms_room_type_id' => $createdRoomTypes[0]->id,
                'season_type' => 'peak',
                'default_price_per_night' => 7500.00,
                'adults' => 2,
                'childrens' => 1,
                'price_monday' => 7500.00,
                'price_tuesday' => 7500.00,
                'price_wednesday' => 7500.00,
                'price_thursday' => 7500.00,
                'price_friday' => 8500.00,
                'price_saturday' => 9000.00,
                'price_sunday' => 8000.00,
            ],
            // Deluxe Room
            [
                'hms_room_type_id' => $createdRoomTypes[1]->id,
                'season_type' => 'regular',
                'default_price_per_night' => 10000.00,
                'adults' => 2,
                'childrens' => 2,
                'price_monday' => 10000.00,
                'price_tuesday' => 10000.00,
                'price_wednesday' => 10000.00,
                'price_thursday' => 10000.00,
                'price_friday' => 12000.00,
                'price_saturday' => 13000.00,
                'price_sunday' => 11000.00,
            ],
            [
                'hms_room_type_id' => $createdRoomTypes[1]->id,
                'season_type' => 'peak',
                'default_price_per_night' => 15000.00,
                'adults' => 2,
                'childrens' => 2,
                'price_monday' => 15000.00,
                'price_tuesday' => 15000.00,
                'price_wednesday' => 15000.00,
                'price_thursday' => 15000.00,
                'price_friday' => 17000.00,
                'price_saturday' => 18000.00,
                'price_sunday' => 16000.00,
            ],
            // Executive Suite
            [
                'hms_room_type_id' => $createdRoomTypes[2]->id,
                'season_type' => 'regular',
                'default_price_per_night' => 25000.00,
                'adults' => 2,
                'childrens' => 2,
                'price_monday' => 25000.00,
                'price_tuesday' => 25000.00,
                'price_wednesday' => 25000.00,
                'price_thursday' => 25000.00,
                'price_friday' => 28000.00,
                'price_saturday' => 30000.00,
                'price_sunday' => 27000.00,
            ],
            [
                'hms_room_type_id' => $createdRoomTypes[2]->id,
                'season_type' => 'peak',
                'default_price_per_night' => 35000.00,
                'adults' => 2,
                'childrens' => 2,
                'price_monday' => 35000.00,
                'price_tuesday' => 35000.00,
                'price_wednesday' => 35000.00,
                'price_thursday' => 35000.00,
                'price_friday' => 40000.00,
                'price_saturday' => 45000.00,
                'price_sunday' => 38000.00,
            ],
            // Family Room
            [
                'hms_room_type_id' => $createdRoomTypes[3]->id,
                'season_type' => 'regular',
                'default_price_per_night' => 15000.00,
                'adults' => 3,
                'childrens' => 3,
                'price_monday' => 15000.00,
                'price_tuesday' => 15000.00,
                'price_wednesday' => 15000.00,
                'price_thursday' => 15000.00,
                'price_friday' => 18000.00,
                'price_saturday' => 20000.00,
                'price_sunday' => 17000.00,
            ],
            [
                'hms_room_type_id' => $createdRoomTypes[3]->id,
                'season_type' => 'peak',
                'default_price_per_night' => 22000.00,
                'adults' => 3,
                'childrens' => 3,
                'price_monday' => 22000.00,
                'price_tuesday' => 22000.00,
                'price_wednesday' => 22000.00,
                'price_thursday' => 22000.00,
                'price_friday' => 25000.00,
                'price_saturday' => 28000.00,
                'price_sunday' => 24000.00,
            ],
            // Presidential Suite
            [
                'hms_room_type_id' => $createdRoomTypes[4]->id,
                'season_type' => 'regular',
                'default_price_per_night' => 100000.00,
                'adults' => 2,
                'childrens' => 2,
                'price_monday' => 100000.00,
                'price_tuesday' => 100000.00,
                'price_wednesday' => 100000.00,
                'price_thursday' => 100000.00,
                'price_friday' => 120000.00,
                'price_saturday' => 150000.00,
                'price_sunday' => 110000.00,
            ],
            [
                'hms_room_type_id' => $createdRoomTypes[4]->id,
                'season_type' => 'peak',
                'default_price_per_night' => 150000.00,
                'adults' => 2,
                'childrens' => 2,
                'price_monday' => 150000.00,
                'price_tuesday' => 150000.00,
                'price_wednesday' => 150000.00,
                'price_thursday' => 150000.00,
                'price_friday' => 180000.00,
                'price_saturday' => 200000.00,
                'price_sunday' => 170000.00,
            ],
        ];

        foreach ($pricing as $price) {
            HmsRoomTypePricing::create($price);
        }

        // Create Extras/Add-ons
        $extras = [
            [
                'name' => 'Breakfast',
                'price' => 2500.00,
                'price_per' => 'per_person_per_day',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Airport Pickup',
                'price' => 5000.00,
                'price_per' => 'one_time',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Airport Drop-off',
                'price' => 5000.00,
                'price_per' => 'one_time',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Laundry Service',
                'price' => 1500.00,
                'price_per' => 'per_day',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Spa Treatment',
                'price' => 8000.00,
                'price_per' => 'per_person',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Room Service (24hr)',
                'price' => 500.00,
                'price_per' => 'per_order',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Extra Bed',
                'price' => 3000.00,
                'price_per' => 'per_night',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Gym Access',
                'price' => 1000.00,
                'price_per' => 'per_day',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Swimming Pool Access',
                'price' => 1500.00,
                'price_per' => 'per_day',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Late Checkout (until 4PM)',
                'price' => 3000.00,
                'price_per' => 'one_time',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Early Check-in (from 10AM)',
                'price' => 3000.00,
                'price_per' => 'one_time',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
            [
                'name' => 'Parking',
                'price' => 1000.00,
                'price_per' => 'per_day',
                'business_id' => $businessId,
                'created_by' => $createdBy,
                'is_active' => true,
            ],
        ];

        foreach ($extras as $extra) {
            HmsExtra::create($extra);
        }

        $this->command->info('HMS Test Data seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- 5 Room Types (Standard, Deluxe, Executive, Family, Presidential)');
        $this->command->info('- 27 Rooms');
        $this->command->info('- 10 Pricing configurations (Regular & Peak seasons)');
        $this->command->info('- 12 Extras/Add-ons');
    }
}
