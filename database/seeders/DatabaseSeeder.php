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
     * Seed the application's database with presentation-ready authentic travel data.
     */
    public function run(): void
    {
        // -------------------------------------------------------------
        // 1. Seed Accounts: Administrator & Realistic Verified Travelers
        // -------------------------------------------------------------
        $admin = User::updateOrCreate(
            ['email' => 'admin@travel.com'],
            [
                'name'              => 'System Administrator',
                'phone'             => '01700000000',
                'address'           => 'House 42, Road 11, Block D, Banani, Dhaka-1213',
                'emergency_contact' => '01711223344',
                'password'          => Hash::make('password123'),
                'is_admin'          => true,
            ]
        );

        $traveler1 = User::updateOrCreate(
            ['email' => 'user@travel.com'],
            [
                'name'              => 'Efaz Ahammad Thalha',
                'phone'             => '01812345678',
                'address'           => 'House 15, Sector 4, Uttara Model Town, Dhaka-1230',
                'emergency_contact' => '01899887766',
                'password'          => Hash::make('password123'),
                'is_admin'          => false,
            ]
        );

        $traveler2 = User::updateOrCreate(
            ['email' => 'tanvir.ahmed@gmail.com'],
            [
                'name'              => 'Tanvir Ahmed',
                'phone'             => '01712345678',
                'address'           => 'Road 27, Dhanmondi R/A, Dhaka-1209',
                'emergency_contact' => '01711002233',
                'password'          => Hash::make('password123'),
                'is_admin'          => false,
            ]
        );

        $traveler3 = User::updateOrCreate(
            ['email' => 'nusrat.jahan@northsouth.edu'],
            [
                'name'              => 'Nusrat Jahan',
                'phone'             => '01823456789',
                'address'           => 'Block G, Bashundhara R/A, Dhaka-1229',
                'emergency_contact' => '01822334455',
                'password'          => Hash::make('password123'),
                'is_admin'          => false,
            ]
        );

        $traveler4 = User::updateOrCreate(
            ['email' => 'arif.hossain@brac.net'],
            [
                'name'              => 'Arif Hossain',
                'phone'             => '01934567890',
                'address'           => 'Commercial Area, Agrabad, Chattogram-4100',
                'emergency_contact' => '01933445566',
                'password'          => Hash::make('password123'),
                'is_admin'          => false,
            ]
        );

        $traveler5 = User::updateOrCreate(
            ['email' => 'sadia.islam@du.ac.bd'],
            [
                'name'              => 'Sadia Islam',
                'phone'             => '01645678901',
                'address'           => 'Curzon Hall Campus Area, Dhaka-1000',
                'emergency_contact' => '01644556677',
                'password'          => Hash::make('password123'),
                'is_admin'          => false,
            ]
        );

        // -------------------------------------------------------------
        // 2. Seed Multi-Modal Travel Services (Flight, Bus, Train & Tour)
        // -------------------------------------------------------------
        // Clear old bookings, payments, and packages for clean presentation state
        Payment::query()->delete();
        Booking::query()->delete();
        Package::query()->delete();

        $services = [
            // =========================================================
            // A. FLIGHT TICKETS (Real Domestic Airlines & Routes)
            // =========================================================
            [
                'type'            => 'flight',
                'title'           => 'Biman Bangladesh BG-433 Dreamliner',
                'from_location'   => 'Dhaka',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '10:15 AM',
                'available_seats' => 24,
                'price'           => 4800.00,
                'description'     => 'Non-stop widebody Boeing 787-9 Dreamliner flight from Hazrat Shahjalal International Airport (DAC) to Cox\'s Bazar Airport (CXB). Includes 20kg check-in baggage and refreshments.',
                'image'           => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=800&q=80',
                'location'        => "Cox's Bazar",
            ],
            [
                'type'            => 'flight',
                'title'           => 'US-Bangla BS-141 Premium Express',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Chattogram',
                'departure_time'  => '11:45 AM',
                'available_seats' => 18,
                'price'           => 3800.00,
                'description'     => 'Direct Boeing 737-800 jet service between Dhaka and Chattogram Shah Amanat International Airport. Fast check-in, priority boarding, and leather business seating.',
                'image'           => 'us_bangla_airplane.jpg',
                'location'        => 'Chattogram',
            ],
            [
                'type'            => 'flight',
                'title'           => 'Novoair VQ-925 Sky Express',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '02:15 PM',
                'available_seats' => 16,
                'price'           => 4200.00,
                'description'     => 'Punctual daily ATR 72-500 flight connecting Dhaka with the spiritual and tea capital Sylhet Osmani Airport. Complimentary snack box and warm tea service.',
                'image'           => 'https://images.unsplash.com/photo-1520437358207-323b43b50729?auto=format&fit=crop&w=800&q=80',
                'location'        => 'Sylhet',
            ],
            [
                'type'            => 'flight',
                'title'           => 'Air Astra 2A-441 Coastal Shuttle',
                'from_location'   => 'Dhaka',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '03:45 PM',
                'available_seats' => 20,
                'price'           => 4600.00,
                'description'     => 'Modern ATR 72-600 eco-friendly flight with 31-inch generous seat pitch and panoramic views of the Bay of Bengal coastline.',
                'image'           => 'https://images.unsplash.com/photo-1569154941061-e231b4725ef1?auto=format&fit=crop&w=800&q=80',
                'location'        => "Cox's Bazar",
            ],
            [
                'type'            => 'flight',
                'title'           => 'Biman Bangladesh BG-601 Northern Wing',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Saidpur',
                'departure_time'  => '08:30 AM',
                'available_seats' => 22,
                'price'           => 3600.00,
                'description'     => 'Morning De Havilland Dash 8-400 service providing fast express access to North Bengal (Saidpur, Rangpur, Dinajpur).',
                'image'           => 'https://images.unsplash.com/photo-1570710891163-6d3b5c47248b?auto=format&fit=crop&w=800&q=80',
                'location'        => 'Saidpur',
            ],
            [
                'type'            => 'flight',
                'title'           => 'US-Bangla BS-155 Southern Wing',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Jashore',
                'departure_time'  => '01:20 PM',
                'available_seats' => 15,
                'price'           => 3400.00,
                'description'     => 'Daily express flight linking Dhaka to Jashore Airport, gateway to Khulna, Benapole international land port, and the Sundarbans.',
                'image'           => 'https://images.unsplash.com/photo-1559268950-2d7ceb2efa3a?auto=format&fit=crop&w=800&q=80',
                'location'        => 'Jashore',
            ],
            [
                'type'            => 'flight',
                'title'           => 'Biman Bangladesh BG-437 Bay Shuttle',
                'from_location'   => 'Chattogram',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '09:30 AM',
                'available_seats' => 25,
                'price'           => 2800.00,
                'description'     => 'Rapid 35-minute coastal hop connecting Chattogram port city with Cox\'s Bazar seaside tourist paradise.',
                'image'           => 'https://images.unsplash.com/photo-1506012787146-f92b2d7d6d96?auto=format&fit=crop&w=800&q=80',
                'location'        => "Cox's Bazar",
            ],

            // =========================================================
            // B. BUS FLEET (Premier AC Sleepers & Business Coaches)
            // =========================================================
            [
                'type'            => 'bus',
                'title'           => 'Green Line Paribahan Scania Double Decker Sleeper',
                'from_location'   => 'Dhaka',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '08:00 PM',
                'available_seats' => 32,
                'price'           => 1900.00,
                'description'     => 'Flagship multi-axle double-decker luxury sleeper coach. Individual entertainment monitors, fast USB chargers, mineral water, and premium pillows.',
                'image'           => 'green_line_bus.jpg',
                'location'        => "Cox's Bazar",
            ],
            [
                'type'            => 'bus',
                'title'           => 'Shohagh Paribahan Scania Elite Business Class',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Chattogram',
                'departure_time'  => '11:00 PM',
                'available_seats' => 28,
                'price'           => 1300.00,
                'description'     => 'Exclusive 1x2 business-class recliner coach via Dhaka-Chattogram 4-lane expressway. Ergonomic calf supports, onboard attendant, and punctual schedule.',
                'image'           => 'shohagh_bus.jpg',
                'location'        => 'Chattogram',
            ],
            [
                'type'            => 'bus',
                'title'           => 'Hanif Enterprise Volvo B11R AC Sleeper',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '07:30 AM',
                'available_seats' => 36,
                'price'           => 1100.00,
                'description'     => 'Multi-axle Volvo air-conditioned coach from Sayedabad to Sylhet Kadamtoli. Air suspension, clean environment, GPS tracking, and certified highway drivers.',
                'image'           => 'hanif_bus.jpg',
                'location'        => 'Sylhet',
            ],
            [
                'type'            => 'bus',
                'title'           => 'Desh Travels Hyundai Universe Noble AC',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Rajshahi',
                'departure_time'  => '09:00 AM',
                'available_seats' => 30,
                'price'           => 1200.00,
                'description'     => 'Executive Korean Hyundai Universe luxury coach connecting Dhaka with Rajshahi via Bangabandhu Jamuna Bridge. Cold AC and cinematic entertainment.',
                'image'           => 'desh_travels_bus.jpg',
                'location'        => 'Rajshahi',
            ],
            [
                'type'            => 'bus',
                'title'           => 'Saintmartin Paribahan Direct Coastal Sleeper',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Teknaf',
                'departure_time'  => '08:30 PM',
                'available_seats' => 30,
                'price'           => 1850.00,
                'description'     => 'Direct highway overnight express coach connecting Dhaka to Teknaf ship ghat for Saint Martin island ferry connection. Cozy 2x1 sleeper berths.',
                'image'           => 'saintmartin_bus.jpg',
                'location'        => 'Teknaf',
            ],
            [
                'type'            => 'bus',
                'title'           => 'Shyamoli NR Travels Multi-Axle Scania AC',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Kuakata',
                'departure_time'  => '07:45 PM',
                'available_seats' => 34,
                'price'           => 1600.00,
                'description'     => 'Direct highway express service via Padma Bridge and Payra Bridge to Kuakata sea beach. Fresh blankets, complimentary refreshments, and smooth ride.',
                'image'           => 'shyamoli_bus.jpg',
                'location'        => 'Kuakata',
            ],
            [
                'type'            => 'bus',
                'title'           => 'London Express MAN Executive Sleeper',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Benapole',
                'departure_time'  => '10:30 PM',
                'available_seats' => 26,
                'price'           => 1500.00,
                'description'     => 'Ultra-luxury German MAN chassis coach to Benapole international land port. Ideal for cross-border commuters and business travelers.',
                'image'           => 'london_express_bus.jpg',
                'location'        => 'Benapole',
            ],
            [
                'type'            => 'bus',
                'title'           => 'Ena Transport Hyundai Premium AC',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sreemangal',
                'departure_time'  => '08:15 AM',
                'available_seats' => 36,
                'price'           => 850.00,
                'description'     => 'Morning highway coach directly to Sreemangal tea paradise. Comfortable push-back seats and rapid transit over Dhaka-Sylhet corridor.',
                'image'           => 'ena_bus.jpg',
                'location'        => 'Sreemangal',
            ],

            // =========================================================
            // C. INTERCITY TRAINS (Bangladesh Railway Prestige Services)
            // =========================================================
            [
                'type'            => 'train',
                'title'           => 'Cox\'s Bazar Express (814) - AC Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '10:30 PM',
                'available_seats' => 48,
                'price'           => 1325.00,
                'description'     => 'Bangladesh Railway flagship non-stop night express traveling over the iconic new coastal railway corridor from Kamalapur to Cox\'s Bazar iconic oyster station.',
                'image'           => 'cox_bazar_train.jpg',
                'location'        => "Cox's Bazar",
            ],
            [
                'type'            => 'train',
                'title'           => 'Tourist Express (816) - AC Chair & Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '06:15 AM',
                'available_seats' => 52,
                'price'           => 1325.00,
                'description'     => 'Scenic morning daytime coastal express train. Breathtaking daytime views of lush green countryside, Karnaphuli river, and hilly landscapes into Cox\'s Bazar.',
                'image'           => 'tourist_express_train.jpg',
                'location'        => "Cox's Bazar",
            ],
            [
                'type'            => 'train',
                'title'           => 'Suborno Express (702) - Non-stop AC Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Chattogram',
                'departure_time'  => '04:30 PM',
                'available_seats' => 45,
                'price'           => 780.00,
                'description'     => 'Bangladesh Railway prestigious non-stop intercity express from Kamalapur to Chattogram Railway Station. 5-hour transit, dining coach, and AC Snigdha chairs.',
                'image'           => 'suborno_train.jpg',
                'location'        => 'Chattogram',
            ],
            [
                'type'            => 'train',
                'title'           => 'Sonar Bangla Express (788) - AC Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Chattogram',
                'departure_time'  => '07:00 AM',
                'available_seats' => 50,
                'price'           => 805.00,
                'description'     => 'Morning non-stop express train equipped with imported Indonesian stainless steel air-conditioned coaches and onboard gourmet breakfast catering.',
                'image'           => 'sonar_bangla_train.jpg',
                'location'        => 'Chattogram',
            ],
            [
                'type'            => 'train',
                'title'           => 'Parabat Express (710) - AC Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '06:20 AM',
                'available_seats' => 42,
                'price'           => 660.00,
                'description'     => 'Picturesque intercity train journey curving through the hills of Brahmanbaria, Sreemangal tea estates, and Lawachara rainforest into Sylhet.',
                'image'           => 'parabat_train.jpg',
                'location'        => 'Sylhet',
            ],
            [
                'type'            => 'train',
                'title'           => 'Upaban Express (740) - AC Berth Sleeper',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '09:50 PM',
                'available_seats' => 30,
                'price'           => 850.00,
                'description'     => 'Overnight sleeper train to Sylhet. Features private AC 2-berth and 4-berth sleeping cabins with fresh bedsheets and secure locking doors.',
                'image'           => 'intercity_sylhet.jpg',
                'location'        => 'Sylhet',
            ],
            [
                'type'            => 'train',
                'title'           => 'Silk City Express (754) - AC Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Rajshahi',
                'departure_time'  => '02:40 PM',
                'available_seats' => 40,
                'price'           => 625.00,
                'description'     => 'Daily afternoon intercity train crossing the majestic Bangabandhu Jamuna Bridge into the historical silk and mango capital Rajshahi.',
                'image'           => 'bangladesh_railway_3000.jpg',
                'location'        => 'Rajshahi',
            ],
            [
                'type'            => 'train',
                'title'           => 'Benapole Express (796) - AC Snigdha',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Benapole',
                'departure_time'  => '11:15 PM',
                'available_seats' => 35,
                'price'           => 950.00,
                'description'     => 'High-speed broad-gauge intercity train connecting Dhaka directly to Benapole border crossing via the newly opened Padma Rail Link corridor.',
                'image'           => 'benapole_train.jpg',
                'location'        => 'Benapole',
            ],

            // =========================================================
            // D. HOLIDAY TOUR PACKAGES (Authentic Bangladesh Expeditions)
            // =========================================================
            [
                'type'            => 'tour',
                'title'           => 'Saint Martin Coral Island Luxury Cruise & Beachfront Resort (3D/2N)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Saint Martin',
                'departure_time'  => '06:00 AM',
                'available_seats' => 20,
                'price'           => 13500.00,
                'description'     => 'All-inclusive 3 Days & 2 Nights holiday package: AC bus to Teknaf, Bay Cruiser ship pass, private beach cottage stay at Chera Dwip view, scuba diving guide, and seaside BBQ dinner.',
                'image'           => 'saint_martin_island.jpg',
                'location'        => 'Saint Martin',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Sajek Valley \'Kingdom of Clouds\' Eco-Resort & 4x4 Chander Gari (3D/2N)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sajek Valley',
                'departure_time'  => '08:00 AM',
                'available_seats' => 18,
                'price'           => 11800.00,
                'description'     => 'Experience breathtaking cloud oceans from Ruilui Para & Konglak Hill. Includes 4x4 Chander Gari mountain convoy, military escort clearance, premium wooden balcony cottage, and tribal bamboo chicken cuisine.',
                'image'           => 'sajek_valley.jpg',
                'location'        => 'Sajek Valley',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Sreemangal Tea Capital, Lawachara Rainforest & Seven-Layer Tea (2D/1N)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sreemangal',
                'departure_time'  => '07:30 AM',
                'available_seats' => 22,
                'price'           => 6900.00,
                'description'     => 'Refreshing weekend nature escape: cycling through Finlay tea gardens, wildlife trek inside Lawachara National Park with Hoolock Gibbons, Baikka Beel bird sanctuary, and authentic 7-color tea tasting.',
                'image'           => 'pack5.2.jpg',
                'location'        => 'Sreemangal',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Sylhet Ratargul Freshwater Swamp Forest, Jaflong & Bisnakandi (3D/2N)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Sylhet',
                'departure_time'  => '07:00 AM',
                'available_seats' => 24,
                'price'           => 8900.00,
                'description'     => 'Explore Amazon of Bangladesh: wooden country boat safari through submerged trees of Ratargul Swamp Forest, crystal waters of Bisnakandi, and Piyain river pebbles overlooking Meghalaya hills.',
                'image'           => 'ratargul_swamp.jpg',
                'location'        => 'Sylhet',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Sundarbans UNESCO Mangrove Cruise - Royal Bengal Tiger Safari (3D/2N)',
                'from_location'   => 'Khulna',
                'to_location'     => 'Sundarbans',
                'departure_time'  => '08:00 AM',
                'available_seats' => 16,
                'price'           => 16500.00,
                'description'     => '3-Day luxury cruise on an air-conditioned river cruiser through Kotka, Kochikhali, and Hiron Point. Armed forest guard escorts, canal dinghy boating, watchtower wildlife spotting, and gourmet seafood.',
                'image'           => 'sundarbans_mangrove.jpg',
                'location'        => 'Sundarbans',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Bandarban Nilgiri Clouds, Golden Temple & Boga Lake Expedition (3D/2N)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Bandarban',
                'departure_time'  => '08:00 PM',
                'available_seats' => 18,
                'price'           => 12500.00,
                'description'     => 'Ascend into the clouds at Nilgiri Army Hill Resort, visit the golden Buddha Dhatu Jadi, tribal Marma villages, Shoilo Propat waterfall, and mountain lake Boga Lake.',
                'image'           => 'bandarban_nilgiri.jpg',
                'location'        => 'Bandarban',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Kuakata \'Daughter of the Sea\' Sunrise & Sunset Beach Holiday (3D/2N)',
                'from_location'   => 'Dhaka',
                'to_location'     => 'Kuakata',
                'departure_time'  => '07:00 PM',
                'available_seats' => 20,
                'price'           => 9500.00,
                'description'     => 'Visit the rare 18km beach where you can observe both sunrise and sunset from the same shore. Includes Padma Bridge luxury bus ride, Rakhine Buddhist temple tour, and Lebur Char mangrove forest.',
                'image'           => 'kuakata_beach.jpg',
                'location'        => 'Kuakata',
            ],
            [
                'type'            => 'tour',
                'title'           => 'Cox\'s Bazar Marine Drive, Inani Beach & Coral Reef Getaway (3D/2N)',
                'from_location'   => 'Dhaka',
                'to_location'     => "Cox's Bazar",
                'departure_time'  => '08:00 AM',
                'available_seats' => 25,
                'price'           => 10500.00,
                'description'     => 'Relax along the world\'s longest unbroken natural sea beach. Includes ocean-view 4-star hotel, private open-hood jeep trip along Marine Drive, Himchari hills, and fresh seafood barbecue.',
                'image'           => 'coxs_bazar_marine_drive.jpg',
                'location'        => "Cox's Bazar",
            ],
        ];

        $packageModels = [];
        foreach ($services as $serviceData) {
            $packageModels[$serviceData['title']] = Package::create($serviceData);
        }

        // -------------------------------------------------------------
        // 3. Seed Realistic Bookings, Promo Codes & Payments
        // -------------------------------------------------------------


        // -------------------------------------------------------------
        // Booking Group 1: Primary Demo Traveler (Efaz Ahammad Thalha)
        // -------------------------------------------------------------

        // 1. FLIGHT: Biman Bangladesh BG-433 Dreamliner to Cox's Bazar (PAID via SSLCommerz bKash)
        $b1 = Booking::create([
            'user_id'          => $traveler1->id,
            'package_id'       => $packageModels['Biman Bangladesh BG-433 Dreamliner']->id,
            'booking_code'     => 'TKT-2026-FL001',
            'transport_type'   => 'flight',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::tomorrow()->toDateString(),
            'check_in_date'    => Carbon::tomorrow()->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => "Cox's Bazar",
            'destination'      => "Cox's Bazar",
            'accommodation'    => 'Flight Cabin',
            'rooms'            => 1,
            'seats'            => 2,
            'selected_seats'   => '12A, 12B',
            'room_type'        => 'AC Business Class',
            'promo_code'       => 'ADVANCE15',
            'discount_amount'  => 1440.00, // 15% off 9600
            'unit_price'       => 4800.00,
            'total_price'      => 8160.00,
            'package_price'    => 4800.00,
            'package_title'    => 'Biman Bangladesh BG-433 Dreamliner',
            'package_location' => "Cox's Bazar",
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
            'special_notes'    => 'Window seats 12A and 12B booked. Web check-in completed.',
        ]);

        Payment::create([
            'booking_id'     => $b1->id,
            'user_id'        => $traveler1->id,
            'tran_id'        => 'TRX_SSLCZ_DAC_CXB_481',
            'amount'         => 8160.00,
            'status'         => 'Success',
            'payment_method' => 'bKash',
            'raw_data'       => json_encode(['bank_tran_id' => 'BKASH-20260909-8812', 'card_brand' => 'bKash Mobile Banking', 'val_id' => 'VAL_99212']),
        ]);

        // 2. BUS: Green Line Scania Double Decker Sleeper Round-Trip (PAID via SSLCommerz Card)
        $b2 = Booking::create([
            'user_id'          => $traveler1->id,
            'package_id'       => $packageModels['Green Line Paribahan Scania Double Decker Sleeper']->id,
            'booking_code'     => 'TKT-2026-BUS102',
            'transport_type'   => 'bus',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::today()->addDays(3)->toDateString(),
            'return_date'      => Carbon::today()->addDays(6)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(3)->toDateString(),
            'check_out_date'   => Carbon::today()->addDays(6)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => "Cox's Bazar",
            'destination'      => "Cox's Bazar",
            'accommodation'    => 'Standard Coach',
            'rooms'            => 1,
            'seats'            => 2,
            'selected_seats'   => 'L1, L2',
            'room_type'        => 'Sleeper / Deluxe Cabin',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 1900.00,
            'total_price'      => 7600.00, // 2 seats * 1900 * 2 (Round-Trip)
            'package_price'    => 1900.00,
            'package_title'    => 'Green Line Paribahan Scania Double Decker Sleeper',
            'package_location' => "Cox's Bazar",
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
            'special_notes'    => 'Lower deck front sleeper cabins L1 and L2.',
        ]);

        Payment::create([
            'booking_id'     => $b2->id,
            'user_id'        => $traveler1->id,
            'tran_id'        => 'TRX_BKASH_GL_77491',
            'amount'         => 7600.00,
            'status'         => 'Success',
            'payment_method' => 'Visa',
            'raw_data'       => json_encode(['bank_tran_id' => 'CITY-VISA-99120', 'card_brand' => 'City Bank Visa Platinum', 'val_id' => 'VAL_77491']),
        ]);

        // 3. TRAIN: Cox's Bazar Express (814) (UNPAID / Cash on Boarding for demo)
        $b3 = Booking::create([
            'user_id'          => $traveler1->id,
            'package_id'       => $packageModels['Cox\'s Bazar Express (814) - AC Snigdha']->id,
            'booking_code'     => 'TKT-2026-TRN203',
            'transport_type'   => 'train',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::today()->addDays(5)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(5)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => "Cox's Bazar",
            'destination'      => "Cox's Bazar",
            'accommodation'    => 'Standard',
            'rooms'            => 1,
            'seats'            => 1,
            'selected_seats'   => 'Snigdha-C4',
            'room_type'        => 'AC Business Class',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 1325.00,
            'total_price'      => 1325.00,
            'package_price'    => 1325.00,
            'package_title'    => 'Cox\'s Bazar Express (814) - AC Snigdha',
            'package_location' => "Cox's Bazar",
            'status'           => 'confirmed',
            'payment_status'   => 'unpaid',
            'refund_status'    => 'none',
            'special_notes'    => 'Cash on Boarding counter reservation requested at Kamalapur railway station.',
        ]);

        // 4. TOUR: Sajek Valley Retreat (COMPLETED Past Journey)
        $b4 = Booking::create([
            'user_id'          => $traveler1->id,
            'package_id'       => $packageModels['Sajek Valley \'Kingdom of Clouds\' Eco-Resort & 4x4 Chander Gari (3D/2N)']->id,
            'booking_code'     => 'TKT-2026-TOU304',
            'transport_type'   => 'tour',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::today()->subDays(15)->toDateString(),
            'return_date'      => Carbon::today()->subDays(12)->toDateString(),
            'check_in_date'    => Carbon::today()->subDays(15)->toDateString(),
            'check_out_date'   => Carbon::today()->subDays(12)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Sajek Valley',
            'destination'      => 'Sajek Valley',
            'accommodation'    => 'Wooden Balcony Cottage',
            'rooms'            => 1,
            'seats'            => 1,
            'selected_seats'   => 'Cottage-Suite-03',
            'room_type'        => 'Standard Package Room',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 11800.00,
            'total_price'      => 11800.00,
            'package_price'    => 11800.00,
            'package_title'    => 'Sajek Valley \'Kingdom of Clouds\' Eco-Resort & 4x4 Chander Gari (3D/2N)',
            'package_location' => 'Sajek Valley',
            'status'           => 'completed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b4->id,
            'user_id'        => $traveler1->id,
            'tran_id'        => 'TRX_VISA_SJK_3910',
            'amount'         => 11800.00,
            'status'         => 'Success',
            'payment_method' => 'Mastercard',
            'raw_data'       => json_encode(['bank_tran_id' => 'MC-20260824-3910', 'card_brand' => 'Mastercard World Elite', 'val_id' => 'VAL_SJK01']),
        ]);

        // 5. TRAIN: Sonar Bangla Express (COMPLETED Past Journey)
        $b5 = Booking::create([
            'user_id'          => $traveler1->id,
            'package_id'       => $packageModels['Sonar Bangla Express (788) - AC Snigdha']->id,
            'booking_code'     => 'TKT-2026-TRN205',
            'transport_type'   => 'train',
            'passenger_name'   => 'Efaz Ahammad Thalha',
            'firstname'        => 'Efaz',
            'lastname'         => 'Thalha',
            'email'            => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'     => Carbon::today()->subDays(30)->toDateString(),
            'check_in_date'    => Carbon::today()->subDays(30)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Chattogram',
            'destination'      => 'Chattogram',
            'accommodation'    => 'AC Snigdha',
            'rooms'            => 1,
            'seats'            => 2,
            'selected_seats'   => 'S-11, S-12',
            'room_type'        => 'AC Business Class',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 805.00,
            'total_price'      => 1610.00,
            'package_price'    => 805.00,
            'package_title'    => 'Sonar Bangla Express (788) - AC Snigdha',
            'package_location' => 'Chattogram',
            'status'           => 'completed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b5->id,
            'user_id'        => $traveler1->id,
            'tran_id'        => 'TRX_NAGAD_SBE_2210',
            'amount'         => 1610.00,
            'status'         => 'Success',
            'payment_method' => 'Nagad',
            'raw_data'       => json_encode(['bank_tran_id' => 'NAGAD-20260810-2210', 'card_brand' => 'Nagad Digital Wallet', 'val_id' => 'VAL_NAGAD_22']),
        ]);

        // 6. TRAIN: Parabat Express (CANCELLED with REFUND REQUESTED - Ready for Admin demonstration)
        $b6 = Booking::create([
            'user_id'             => $traveler1->id,
            'package_id'          => $packageModels['Parabat Express (710) - AC Snigdha']->id,
            'booking_code'        => 'TKT-2026-REF406',
            'transport_type'      => 'train',
            'passenger_name'      => 'Efaz Ahammad Thalha',
            'firstname'           => 'Efaz',
            'lastname'            => 'Thalha',
            'email'               => 'user@travel.com',
            'phone'               => '01812345678',
            'journey_date'        => Carbon::today()->addDays(8)->toDateString(),
            'check_in_date'       => Carbon::today()->addDays(8)->toDateString(),
            'from_city'           => 'Dhaka',
            'to_city'             => 'Sylhet',
            'destination'         => 'Sylhet',
            'accommodation'       => 'Standard',
            'rooms'               => 1,
            'seats'               => 2,
            'selected_seats'      => 'Snigdha-A1, Snigdha-A2',
            'room_type'           => 'AC Business Class',
            'promo_code'          => null,
            'discount_amount'     => 0.00,
            'unit_price'          => 660.00,
            'total_price'         => 1320.00,
            'package_price'       => 660.00,
            'package_title'       => 'Parabat Express (710) - AC Snigdha',
            'package_location'    => 'Sylhet',
            'status'              => 'cancelled',
            'payment_status'      => 'paid',
            'refund_status'       => 'requested',
            'cancellation_reason' => 'Emergency university semester final examination scheduled on travel date. Requesting refund approval.',
        ]);

        Payment::create([
            'booking_id'     => $b6->id,
            'user_id'        => $traveler1->id,
            'tran_id'        => 'TRX_SSLCZ_SYL_6619',
            'amount'         => 1320.00,
            'status'         => 'Success',
            'payment_method' => 'bKash',
            'raw_data'       => json_encode(['bank_tran_id' => 'BKASH-REFUND-REQ', 'card_brand' => 'bKash', 'val_id' => 'VAL_6619']),
        ]);

        // 7. BUS: Shohagh Paribahan (CANCELLED & REFUNDED - Demonstrating approved refunds)
        $b7 = Booking::create([
            'user_id'             => $traveler1->id,
            'package_id'          => $packageModels['Shohagh Paribahan Scania Elite Business Class']->id,
            'booking_code'        => 'TKT-2026-REF407',
            'transport_type'      => 'bus',
            'passenger_name'      => 'Efaz Ahammad Thalha',
            'firstname'           => 'Efaz',
            'lastname'            => 'Thalha',
            'email'               => 'user@travel.com',
            'phone'            => '01812345678',
            'journey_date'        => Carbon::today()->subDays(2)->toDateString(),
            'check_in_date'       => Carbon::today()->subDays(2)->toDateString(),
            'from_city'           => 'Dhaka',
            'to_city'             => 'Chattogram',
            'destination'         => 'Chattogram',
            'accommodation'       => 'Business Recliner',
            'rooms'               => 1,
            'seats'               => 1,
            'selected_seats'      => 'B1',
            'room_type'           => 'AC Business Class',
            'promo_code'          => null,
            'discount_amount'     => 0.00,
            'unit_price'          => 1300.00,
            'total_price'         => 1300.00,
            'package_price'       => 1300.00,
            'package_title'       => 'Shohagh Paribahan Scania Elite Business Class',
            'package_location'    => 'Chattogram',
            'status'              => 'cancelled',
            'payment_status'      => 'refunded',
            'refund_status'       => 'refunded',
            'cancellation_reason' => 'Official office project meeting moved forward. Refund processed by Admin to bKash wallet.',
        ]);

        Payment::create([
            'booking_id'     => $b7->id,
            'user_id'        => $traveler1->id,
            'tran_id'        => 'TRX_BKASH_SH_1190',
            'amount'         => 1300.00,
            'status'         => 'Success',
            'payment_method' => 'bKash',
            'raw_data'       => json_encode(['bank_tran_id' => 'BKASH-REFUNDED-01', 'card_brand' => 'bKash', 'val_id' => 'VAL_1190']),
        ]);

        // -------------------------------------------------------------
        // Booking Group 2: Other Verified Travelers (Populating Admin Dashboard)
        // -------------------------------------------------------------

        // 8. Tanvir Ahmed - US-Bangla Flight to Chattogram (TODAY - ACTIVE BOARDING)
        $b8 = Booking::create([
            'user_id'          => $traveler2->id,
            'package_id'       => $packageModels['US-Bangla BS-141 Premium Express']->id,
            'booking_code'     => 'TKT-2026-FL008',
            'transport_type'   => 'flight',
            'passenger_name'   => 'Tanvir Ahmed',
            'firstname'        => 'Tanvir',
            'lastname'         => 'Ahmed',
            'email'            => 'tanvir.ahmed@gmail.com',
            'phone'            => '01712345678',
            'journey_date'     => Carbon::today()->toDateString(),
            'check_in_date'    => Carbon::today()->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Chattogram',
            'destination'      => 'Chattogram',
            'accommodation'    => 'Executive Jet',
            'rooms'            => 1,
            'seats'            => 1,
            'selected_seats'   => '4C',
            'room_type'        => 'AC Business Class',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 3800.00,
            'total_price'      => 3800.00,
            'package_price'    => 3800.00,
            'package_title'    => 'US-Bangla BS-141 Premium Express',
            'package_location' => 'Chattogram',
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b8->id,
            'user_id'        => $traveler2->id,
            'tran_id'        => 'TRX_AMEX_CGP_8812',
            'amount'         => 3800.00,
            'status'         => 'Success',
            'payment_method' => 'City Bank AMEX',
            'raw_data'       => json_encode(['bank_tran_id' => 'AMEX-8812', 'card_brand' => 'American Express', 'val_id' => 'VAL_8812']),
        ]);

        // 9. Tanvir Ahmed - Saint Martin Coral Island Escape (UPCOMING)
        $b9 = Booking::create([
            'user_id'          => $traveler2->id,
            'package_id'       => $packageModels['Saint Martin Coral Island Luxury Cruise & Beachfront Resort (3D/2N)']->id,
            'booking_code'     => 'TKT-2026-TOU009',
            'transport_type'   => 'tour',
            'passenger_name'   => 'Tanvir Ahmed',
            'firstname'        => 'Tanvir',
            'lastname'         => 'Ahmed',
            'email'            => 'tanvir.ahmed@gmail.com',
            'phone'            => '01712345678',
            'journey_date'     => Carbon::today()->addDays(7)->toDateString(),
            'return_date'      => Carbon::today()->addDays(10)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(7)->toDateString(),
            'check_out_date'   => Carbon::today()->addDays(10)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Saint Martin',
            'destination'      => 'Saint Martin',
            'accommodation'    => 'Beachfront Resort Villa',
            'rooms'            => 1,
            'seats'            => 2,
            'selected_seats'   => 'Resort-Deluxe-102',
            'room_type'        => 'Standard Package Room',
            'promo_code'       => 'VIVA500',
            'discount_amount'  => 500.00,
            'unit_price'       => 13500.00,
            'total_price'      => 26500.00, // (13500 * 2) - 500
            'package_price'    => 13500.00,
            'package_title'    => 'Saint Martin Coral Island Luxury Cruise & Beachfront Resort (3D/2N)',
            'package_location' => 'Saint Martin',
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b9->id,
            'user_id'        => $traveler2->id,
            'tran_id'        => 'TRX_SSLCZ_SM_9921',
            'amount'         => 26500.00,
            'status'         => 'Success',
            'payment_method' => 'Visa',
            'raw_data'       => json_encode(['bank_tran_id' => 'SCB-VISA-9921', 'card_brand' => 'Standard Chartered Visa', 'val_id' => 'VAL_9921']),
        ]);

        // 10. Nusrat Jahan - Hanif Enterprise to Sylhet (STUDENT2026 Promo Applied)
        $b10 = Booking::create([
            'user_id'          => $traveler3->id,
            'package_id'       => $packageModels['Hanif Enterprise Volvo B11R AC Sleeper']->id,
            'booking_code'     => 'TKT-2026-BUS010',
            'transport_type'   => 'bus',
            'passenger_name'   => 'Nusrat Jahan',
            'firstname'        => 'Nusrat',
            'lastname'         => 'Jahan',
            'email'            => 'nusrat.jahan@northsouth.edu',
            'phone'            => '01823456789',
            'journey_date'     => Carbon::tomorrow()->toDateString(),
            'check_in_date'    => Carbon::tomorrow()->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Sylhet',
            'destination'      => 'Sylhet',
            'accommodation'    => 'Volvo Coach',
            'rooms'            => 1,
            'seats'            => 1,
            'selected_seats'   => 'B3',
            'room_type'        => 'AC Business Class',
            'promo_code'       => 'STUDENT2026',
            'discount_amount'  => 220.00, // 20% off 1100
            'unit_price'       => 1100.00,
            'total_price'      => 880.00,
            'package_price'    => 1100.00,
            'package_title'    => 'Hanif Enterprise Volvo B11R AC Sleeper',
            'package_location' => 'Sylhet',
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b10->id,
            'user_id'        => $traveler3->id,
            'tran_id'        => 'TRX_BKASH_STU_8821',
            'amount'         => 880.00,
            'status'         => 'Success',
            'payment_method' => 'bKash',
            'raw_data'       => json_encode(['bank_tran_id' => 'BKASH-STU-8821', 'card_brand' => 'bKash', 'val_id' => 'VAL_8821']),
        ]);

        // 11. Nusrat Jahan - Tourist Express (816) to Cox's Bazar (Cash on Boarding)
        $b11 = Booking::create([
            'user_id'          => $traveler3->id,
            'package_id'       => $packageModels['Tourist Express (816) - AC Chair & Snigdha']->id,
            'booking_code'     => 'TKT-2026-TRN011',
            'transport_type'   => 'train',
            'passenger_name'   => 'Nusrat Jahan',
            'firstname'        => 'Nusrat',
            'lastname'         => 'Jahan',
            'email'            => 'nusrat.jahan@northsouth.edu',
            'phone'            => '01823456789',
            'journey_date'     => Carbon::today()->addDays(5)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(5)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => "Cox's Bazar",
            'destination'      => "Cox's Bazar",
            'accommodation'    => 'Standard',
            'rooms'            => 1,
            'seats'            => 2,
            'selected_seats'   => 'Snigdha-B7, Snigdha-B8',
            'room_type'        => 'AC Business Class',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 1325.00,
            'total_price'      => 2650.00,
            'package_price'    => 1325.00,
            'package_title'    => 'Tourist Express (816) - AC Chair & Snigdha',
            'package_location' => "Cox's Bazar",
            'status'           => 'confirmed',
            'payment_status'   => 'unpaid',
            'refund_status'    => 'none',
        ]);

        // 12. Arif Hossain - Sundarbans UNESCO Mangrove Cruise (PAID via SSLCommerz)
        $b12 = Booking::create([
            'user_id'          => $traveler4->id,
            'package_id'       => $packageModels['Sundarbans UNESCO Mangrove Cruise - Royal Bengal Tiger Safari (3D/2N)']->id,
            'booking_code'     => 'TKT-2026-TOU012',
            'transport_type'   => 'tour',
            'passenger_name'   => 'Arif Hossain',
            'firstname'        => 'Arif',
            'lastname'         => 'Hossain',
            'email'            => 'arif.hossain@brac.net',
            'phone'            => '01934567890',
            'journey_date'     => Carbon::today()->addDays(10)->toDateString(),
            'return_date'      => Carbon::today()->addDays(13)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(10)->toDateString(),
            'check_out_date'   => Carbon::today()->addDays(13)->toDateString(),
            'from_city'        => 'Khulna',
            'to_city'          => 'Sundarbans',
            'destination'      => 'Sundarbans',
            'accommodation'    => 'Cruiser AC Cabin',
            'rooms'            => 1,
            'seats'            => 2,
            'selected_seats'   => 'Cabin-Kotka-04',
            'room_type'        => 'Sleeper / Deluxe Cabin',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 16500.00,
            'total_price'      => 33000.00,
            'package_price'    => 16500.00,
            'package_title'    => 'Sundarbans UNESCO Mangrove Cruise - Royal Bengal Tiger Safari (3D/2N)',
            'package_location' => 'Sundarbans',
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b12->id,
            'user_id'        => $traveler4->id,
            'tran_id'        => 'TRX_EBL_SBN_4412',
            'amount'         => 33000.00,
            'status'         => 'Success',
            'payment_method' => 'Visa',
            'raw_data'       => json_encode(['bank_tran_id' => 'EBL-VISA-4412', 'card_brand' => 'Eastern Bank Visa Signature', 'val_id' => 'VAL_4412']),
        ]);

        // 13. Arif Hossain - Desh Travels to Rajshahi (CANCELLED & PENDING REFUND)
        $b13 = Booking::create([
            'user_id'             => $traveler4->id,
            'package_id'          => $packageModels['Desh Travels Hyundai Universe Noble AC']->id,
            'booking_code'        => 'TKT-2026-REF013',
            'transport_type'      => 'bus',
            'passenger_name'      => 'Arif Hossain',
            'firstname'           => 'Arif',
            'lastname'            => 'Hossain',
            'email'               => 'arif.hossain@brac.net',
            'phone'               => '01934567890',
            'journey_date'        => Carbon::today()->addDays(4)->toDateString(),
            'check_in_date'       => Carbon::today()->addDays(4)->toDateString(),
            'from_city'           => 'Dhaka',
            'to_city'             => 'Rajshahi',
            'destination'         => 'Rajshahi',
            'accommodation'       => 'Standard',
            'rooms'               => 1,
            'seats'               => 1,
            'selected_seats'      => 'A3',
            'room_type'           => 'AC Business Class',
            'promo_code'          => null,
            'discount_amount'     => 0.00,
            'unit_price'          => 1200.00,
            'total_price'         => 1200.00,
            'package_price'       => 1200.00,
            'package_title'       => 'Desh Travels Hyundai Universe Noble AC',
            'package_location'    => 'Rajshahi',
            'status'              => 'cancelled',
            'payment_status'      => 'paid',
            'refund_status'       => 'requested',
            'cancellation_reason' => 'Family medical emergency in Dhaka. Requesting refund approval to original card account.',
        ]);

        Payment::create([
            'booking_id'     => $b13->id,
            'user_id'        => $traveler4->id,
            'tran_id'        => 'TRX_NAGAD_DSH_5519',
            'amount'         => 1200.00,
            'status'         => 'Success',
            'payment_method' => 'Nagad',
            'raw_data'       => json_encode(['bank_tran_id' => 'NAGAD-5519', 'card_brand' => 'Nagad', 'val_id' => 'VAL_5519']),
        ]);

        // 14. Sadia Islam - Novoair Flight to Sylhet (PAID)
        $b14 = Booking::create([
            'user_id'          => $traveler5->id,
            'package_id'       => $packageModels['Novoair VQ-925 Sky Express']->id,
            'booking_code'     => 'TKT-2026-FL014',
            'transport_type'   => 'flight',
            'passenger_name'   => 'Sadia Islam',
            'firstname'        => 'Sadia',
            'lastname'         => 'Islam',
            'email'            => 'sadia.islam@du.ac.bd',
            'phone'            => '01645678901',
            'journey_date'     => Carbon::today()->addDays(3)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(3)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Sylhet',
            'destination'      => 'Sylhet',
            'accommodation'    => 'Flight',
            'rooms'            => 1,
            'seats'            => 1,
            'selected_seats'   => '7A',
            'room_type'        => 'AC Business Class',
            'promo_code'       => null,
            'discount_amount'  => 0.00,
            'unit_price'       => 4200.00,
            'total_price'      => 4200.00,
            'package_price'    => 4200.00,
            'package_title'    => 'Novoair VQ-925 Sky Express',
            'package_location' => 'Sylhet',
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b14->id,
            'user_id'        => $traveler5->id,
            'tran_id'        => 'TRX_DBBL_NVO_9918',
            'amount'         => 4200.00,
            'status'         => 'Success',
            'payment_method' => 'Visa',
            'raw_data'       => json_encode(['bank_tran_id' => 'DBBL-NEXUS-9918', 'card_brand' => 'DBBL NexusPay', 'val_id' => 'VAL_9918']),
        ]);

        // 15. Sadia Islam - Sreemangal Tea Capital Tour (PAID with VIVA500 Promo)
        $b15 = Booking::create([
            'user_id'          => $traveler5->id,
            'package_id'       => $packageModels['Sreemangal Tea Capital, Lawachara Rainforest & Seven-Layer Tea (2D/1N)']->id,
            'booking_code'     => 'TKT-2026-TOU015',
            'transport_type'   => 'tour',
            'passenger_name'   => 'Sadia Islam',
            'firstname'        => 'Sadia',
            'lastname'         => 'Islam',
            'email'            => 'sadia.islam@du.ac.bd',
            'phone'            => '01645678901',
            'journey_date'     => Carbon::today()->addDays(12)->toDateString(),
            'return_date'      => Carbon::today()->addDays(14)->toDateString(),
            'check_in_date'    => Carbon::today()->addDays(12)->toDateString(),
            'check_out_date'   => Carbon::today()->addDays(14)->toDateString(),
            'from_city'        => 'Dhaka',
            'to_city'          => 'Sreemangal',
            'destination'      => 'Sreemangal',
            'accommodation'    => 'Eco Tea Cottage',
            'rooms'            => 1,
            'seats'            => 3,
            'selected_seats'   => 'Cottage-Green-01',
            'room_type'        => 'Standard Package Room',
            'promo_code'       => 'VIVA500',
            'discount_amount'  => 500.00,
            'unit_price'       => 6900.00,
            'total_price'      => 20200.00, // (6900 * 3) - 500
            'package_price'    => 6900.00,
            'package_title'    => 'Sreemangal Tea Capital, Lawachara Rainforest & Seven-Layer Tea (2D/1N)',
            'package_location' => 'Sreemangal',
            'status'           => 'confirmed',
            'payment_status'   => 'paid',
            'refund_status'    => 'none',
        ]);

        Payment::create([
            'booking_id'     => $b15->id,
            'user_id'        => $traveler5->id,
            'tran_id'        => 'TRX_BKASH_SRM_3310',
            'amount'         => 20200.00,
            'status'         => 'Success',
            'payment_method' => 'bKash',
            'raw_data'       => json_encode(['bank_tran_id' => 'BKASH-SRM-3310', 'card_brand' => 'bKash Merchant', 'val_id' => 'VAL_3310']),
        ]);

        // -------------------------------------------------------------
        // 4. Seed Authentic Customer Inquiries & Corporate Requests
        // -------------------------------------------------------------
        ContactMessage::truncate();

        ContactMessage::create([
            'name'    => 'Dr. Kazi M. Rahman',
            'email'   => 'kazi.rahman@bracu.ac.bd',
            'phone'   => '01711223344',
            'subject' => 'Group reservation for university study tour to Sylhet',
            'message' => 'We are organizing an educational field study trip to Ratargul Swamp Forest and Jaflong for 45 undergraduate architecture students. Could you provide a customized package with student discount and AC coach charter?',
        ]);

        ContactMessage::create([
            'name'    => 'Farhan Chowdhury',
            'email'   => 'farhan.hr@grameenphone.com',
            'phone'   => '01713009988',
            'subject' => 'Corporate Annual Retreat for 65 Employees in Sajek Valley',
            'message' => 'Our department is planning our annual retreat to Sajek Valley in mid-November. We need cottage reservations for 65 persons, 4x4 Chander Gari military convoy coordination, and team-building bonfire arrangements.',
        ]);

        ContactMessage::create([
            'name'    => 'Emily Watson',
            'email'   => 'emily.watson.travel@gmail.com',
            'phone'   => '+447911123456',
            'subject' => 'Foreign Tourist e-Ticket Verification & Airport Pickup',
            'message' => 'Hello Advance Travel team, I am visiting Bangladesh from the United Kingdom. Could you confirm if international passport numbers are valid for boarding pass verification on the Cox\'s Bazar Express (814) train?',
        ]);

        ContactMessage::create([
            'name'    => 'Nusrat Jahan',
            'email'   => 'nusrat.jahan@northsouth.edu',
            'phone'   => '01823456789',
            'subject' => 'Saint Martin Island Ship Schedule & Luggage Allowance',
            'message' => 'Could you please confirm if Teknaf to Saint Martin ferry ship tickets are included in the 3-day island package, and what the permissible baggage allowance per passenger is?',
        ]);

        ContactMessage::create([
            'name'    => 'Mohammad Asadullah',
            'email'   => 'asadullah.chy@yahoo.com',
            'phone'   => '01922334455',
            'subject' => 'Pet Policy on AC Sleeper Coach from Dhaka to Chattogram',
            'message' => 'I would like to inquire if small pets in certified travel carriers are permitted on the overnight Scania sleeper coach to Chattogram.',
        ]);

        ContactMessage::create([
            'name'    => 'Sumaiya Akhter',
            'email'   => 'sumaiya.akhter@gmail.com',
            'phone'   => '01677889900',
            'subject' => 'Wheelchair Accessibility on Cox\'s Bazar Express (814)',
            'message' => 'My elderly father requires wheelchair assistance. Could you confirm if Kamalapur and Cox\'s Bazar oyster stations provide ramp access and dedicated porters for boarding the AC Snigdha coach?',
        ]);
    }
}
