<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Accounts: Administrator and Verified Traveler
        $admin = User::updateOrCreate(
            ['email' => 'admin@travel.com'],
            [
                'name'     => 'System Administrator',
                'phone'    => '01700000000',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        $traveler = User::updateOrCreate(
            ['email' => 'user@travel.com'],
            [
                'name'     => 'Efaz Ahammad',
                'phone'    => '01812345678',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ]
        );

        // 2. Seed Multi-Modal Travel Services (Bus, Train & Tour Packages)
        $services = [
            // BUS TICKETS
            [
                'type'            => 'bus',
                'title'           => 'Green Line AC Business Class',
                'from_location'   => 'Dhaka',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '08:00 AM',
                'available_seats' => 32,
                'price'           => 1600.00,
                'description'     => 'Super luxury air-conditioned sleeper coach with reclining ergonomic seats, onboard water, and express highway route.',
                'image'           => 'pac2.1.jpg',
                'location'        => "Cox's Bazar",
            ],
            [
                'type'            => 'bus',
                'title'           => 'Shohagh Scania Elite Sleeper',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Chattogram (Chittagong)',
                'departure_time'  => '10:30 PM',
                'available_seats' => 28,
                'price'           => 1200.00,
                'description'     => 'Overnight express Scania multi-axle bus with comfortable night travel blankets and smooth journey.',
                'image'           => 'pack2.2.jpg',
                'location'        => 'Chattogram',
            ],
            [
                'type'            => 'bus',
                'title'           => 'Hanif Enterprise Hino 1J AC',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '07:30 AM',
                'available_seats' => 36,
                'price'           => 950.00,
                'description'     => 'Daily morning highway coach service from Sayedabad/Arambagh to Kadamtoli Terminal, Sylhet.',
                'image'           => 'pac2.3.jpg',
                'location'        => 'Sylhet',
            ],
            [
                'type'            => 'bus',
                'title'           => 'Saintmartin Paribahan Luxury Coach',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Teknaf',
                'departure_time'  => '09:00 PM',
                'available_seats' => 30,
                'price'           => 1850.00,
                'description'     => 'Direct highway bus connecting Dhaka to Teknaf ship jetty for Saint Martin island ferry connection.',
                'image'           => 'pac2.5.jpg',
                'location'        => 'Teknaf',
            ],

            // TRAIN TICKETS
            [
                'type'            => 'train',
                'title'           => 'Suborno Express (701) - AC Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Chattogram (Chittagong)',
                'departure_time'  => '04:30 PM',
                'available_seats' => 45,
                'price'           => 780.00,
                'description'     => 'Bangladesh Railway prestigious non-stop intercity express from Kamalapur to Chittagong Railway Station.',
                'image'           => 'pack5.1.jpg',
                'location'        => 'Chattogram',
            ],
            [
                'type'            => 'train',
                'title'           => 'Sonar Bangla Express (788)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Chattogram (Chittagong)',
                'departure_time'  => '07:00 AM',
                'available_seats' => 50,
                'price'           => 820.00,
                'description'     => 'Morning non-stop high-speed train service with onboard food catering and comfortable AC coach compartments.',
                'image'           => 'pack5.2.jpg',
                'location'        => 'Chattogram',
            ],
            [
                'type'            => 'train',
                'title'           => 'Parabat Express (709)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '06:20 AM',
                'available_seats' => 40,
                'price'           => 650.00,
                'description'     => 'Scenic intercity train journey passing through tea gardens, Sreemangal valley, and hills.',
                'image'           => 'package3.1.jpg',
                'location'        => 'Sylhet',
            ],

            // TOUR PACKAGES
            [
                'type'            => 'tour',
                'title'           => 'Saint Martin Coral Island Escape',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Saint Martin',
                'departure_time'  => '06:00 AM',
                'available_seats' => 20,
                'price'           => 12500.00,
                'description'     => '3 Days & 2 Nights on premier coral island with beachside resort accommodation, cruise ferry tickets, and BBQ dinner.',
                'image'           => 'pac2.1.jpg',
                'location'        => 'Saint Martin',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Sajek Valley Cloud Kingdom Retreat',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sajek Valley, Rangamati',
                'departure_time'  => '08:00 AM',
                'available_seats' => 18,
                'price'           => 11000.00,
                'description'     => 'Stay above the clouds in Sajek Valley with breathtaking mountain valley views, 4x4 Chander Gari transport, and cottage stay.',
                'image'           => 'package_3.2.jpg',
                'location'        => 'Sajek Valley',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Sylhet Tea Estate & Ratargul Swamp Tour',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '07:00 AM',
                'available_seats' => 25,
                'price'           => 8500.00,
                'description'     => 'Explore lush green tea estates, fresh water Ratargul Swamp Forest boat cruise, and crystal-clear Jaflong rivers.',
                'image'           => 'pac2.3.jpg',
                'location'        => 'Sylhet',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Sundarbans Wild Mangrove Safari',
                'from_location'   => 'Khulna',
                'to_location'     => 'Sundarbans',
                'departure_time'  => '08:30 AM',
                'available_seats' => 15,
                'price'           => 15000.00,
                'description'     => 'Cruise deep into the UNESCO World Heritage mangrove forest to spot deer, crocodiles, and Royal Bengal Tigers.',
                'image'           => 'pack2.2.jpg',
                'location'        => 'Sundarbans',
            ],
        ];

        $packageModels = [];
        foreach ($services as $serviceData) {
            $packageModels[$serviceData['title']] = Package::updateOrCreate(
                ['title' => $serviceData['title']],
                $serviceData
            );
        }

        // 3. Seed Realistic Bookings for Traveler
        // A. Upcoming Trip 1: Green Line Bus to Cox's Bazar (PAID)
        $booking1 = Booking::create([
            'user_id'          => $traveler->id,
            'package_id'       => $packageModels['Green Line AC Business Class']->id,
            'booking_code'     => 'TKT-2026-BUS101',
            'transport_type'   => 'bus',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::tomorrow()->toDateString(),
            'return_date'      => Carbon::tomorrow()->addDays(3)->toDateString(),
            'check_in_date'    => Carbon::tomorrow()->toDateString(),
            'check_out_date'   => Carbon::tomorrow()->addDays(3)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => "Cox's Bazar",
            'destination'      => "Cox's Bazar",
            'accommodation'    => 'Standard',
            'rooms'            => 2,
            'seats'            => 2,
            'room_type'        => 'AC Business Class',
            'unit_price'       => 1600.00,
            'total_price'      => 3200.00,
            'package_price'    => 1600.00,
            'package_title'    => 'Green Line AC Business Class',
            'package_location' => "Cox's Bazar",
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
            'special_notes'    => 'Front row seats A1 and A2 requested.',
        ]);

        Payment::create([
            'booking_id'     => $booking1->id,
            'user_id'        => $traveler->id,
            'tran_id'        => 'TRX_DEMO_99812',
            'amount'         => 3200.00,
            'status'         => 'Success',
            'payment_method' => 'SSLCommerz',
        ]);

        // B. Upcoming Trip 2: Train Ticket to Chittagong (UNPAID / Cash on Boarding)
        $booking2 = Booking::create([
            'user_id'          => $traveler->id,
            'package_id'       => $packageModels['Suborno Express (701) - AC Snigdha']->id,
            'booking_code'     => 'TKT-2026-TRN202',
            'transport_type'   => 'train',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::today()->addDays(5)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(5)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Chittagong',
            'destination'      => 'Chittagong',
            'accommodation'    => 'Standard',
            'rooms'            => 1,
            'seats'            => 1,
            'room_type'        => 'AC Snigdha Chair',
            'unit_price'       => 780.00,
            'total_price'      => 780.00,
            'package_price'    => 780.00,
            'package_title'    => 'Suborno Express (701) - AC Snigdha',
            'package_location' => 'Chittagong',
            'status'           => 'confirmed',
            'payment_status'   => 'unpaid',
            'refund_status'    => 'none',
        ]);

        // C. Past Journey (Completed): Sajek Valley Tour
        $booking3 = Booking::create([
            'user_id'          => $traveler->id,
            'package_id'       => $packageModels['Sajek Valley Cloud Kingdom Retreat']->id,
            'booking_code'     => 'TKT-2026-TOU303',
            'transport_type'   => 'tour',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::today()->subDays(20)->toDateString(),
            'return_date'      => Carbon::today()->subDays(17)->toDateString(),
            'check_in_date'    => Carbon::today()->subDays(20)->toDateString(),
            'check_out_date'   => Carbon::today()->subDays(17)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Rangamati',
            'destination'      => 'Rangamati',
            'accommodation'    => 'Eco Resort Cottage',
            'rooms'            => 1,
            'seats'            => 1,
            'room_type'        => 'Standard Package Room',
            'unit_price'       => 11000.00,
            'total_price'      => 11000.00,
            'package_price'    => 11000.00,
            'package_title'    => 'Sajek Valley Cloud Kingdom Retreat',
            'package_location' => 'Rangamati',
            'status'           => 'completed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $booking3->id,
            'user_id'        => $traveler->id,
            'tran_id'        => 'TRX_DEMO_55410',
            'amount'         => 11000.00,
            'status'         => 'Success',
            'payment_method' => 'SSLCommerz',
        ]);

        // D. Cancelled Ticket with Pending Refund Claim (for Admin Refund testing!)
        $booking4 = Booking::create([
            'user_id'             => $traveler->id,
            'package_id'          => $packageModels['Parabat Express (709)']->id,
            'booking_code'        => 'TKT-2026-REF404',
            'transport_type'      => 'train',
            'passenger_name'      => 'Efaz Ahammad Thalha',
            'firstname'           => 'Efaz',
            'lastname'            => 'Thalha',
            'email'               => 'user@travel.com',
            'phone'               => '01812345678',
            'journey_date'        => Carbon::today()->addDays(7)->toDateString(),
            'check_in_date'       => Carbon::today()->addDays(7)->toDateString(),
            'from_city'           => 'Dhaka',
            'to_city'             => 'Sylhet',
            'destination'         => 'Sylhet',
            'accommodation'       => 'Standard',
            'rooms'               => 2,
            'seats'               => 2,
            'room_type'           => 'AC Chair',
            'unit_price'          => 650.00,
            'total_price'         => 1300.00,
            'package_price'       => 650.00,
            'package_title'       => 'Parabat Express (709)',
            'package_location'    => 'Sylhet',
            'status'              => 'cancelled',
            'payment_status'      => 'paid',
            'refund_status'       => 'requested',
            'cancellation_reason' => 'Emergency university exam schedule conflicting with travel date.',
        ]);

        Payment::create([
            'booking_id'     => $booking4->id,
            'user_id'        => $traveler->id,
            'tran_id'        => 'TRX_DEMO_REF441',
            'amount'         => 1300.00,
            'status'         => 'Success',
            'payment_method' => 'SSLCommerz',
        ]);

        // 4. Seed Inquiries
        ContactMessage::create([
            'name'    => 'Dr. Kazi Rahman',
            'email'   => 'kazi.rahman@university.edu',
            'phone'   => '01711223344',
            'subject' => 'Group reservation for university study tour',
            'message' => 'We are organizing an educational field trip to Sylhet for 45 students. Do you provide bus charter packages with student discounts?',
        ]);

        ContactMessage::create([
            'name'    => 'Nusrat Jahan',
            'email'   => 'nusrat@gmail.com',
            'phone'   => '01988776655',
            'subject' => 'Saint Martin Island ship schedule inquiry',
            'message' => 'Could you please confirm if Teknaf to Saint Martin ferry tickets are included in your 3-day island package?',
        ]);
    }
}
