<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\Booking;
use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin & Demo User
        $admin = User::updateOrCreate(
            ['email' => 'admin@travel.com'],
            [
                'name' => 'Admin User',
                'phone' => '+8801700000000',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@travel.com'],
            [
                'name' => 'Demo Traveler',
                'phone' => '+8801800000000',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ]
        );

        // 2. Seed Travel Packages
        $packages = [
            [
                'title' => "Saint Martin Coral Island Escape",
                'location' => "Saint Martin",
                'price' => 12500.00,
                'description' => "3 Days & 2 Nights on Bangladesh's premier coral island with beachside resort accommodation.",
                'image' => "pac2.1.jpg"
            ],
            [
                'title' => "Sylhet Tea Garden & Jaflong Tour",
                'location' => "Sylhet",
                'price' => 8500.00,
                'description' => "Explore lush green tea estates, Ratargul Swamp Forest, and crystal-clear Jaflong rivers.",
                'image' => "pac2.3.jpg"
            ],
            [
                'title' => "Sundarbans Wild Mangrove Expedition",
                'location' => "Sundarbans",
                'price' => 15000.00,
                'description' => "Cruise deep into the UNESCO World Heritage mangrove forest to spot Royal Bengal Tigers.",
                'image' => "pack2.2.jpg"
            ],
            [
                'title' => "Sajek Valley Cloud Kingdom Retreat",
                'location' => "Rangamati",
                'price' => 11000.00,
                'description' => "Stay above the clouds in Sajek Valley with breathtaking mountain valley sunset views.",
                'image' => "package 3.2.jpg"
            ],
            [
                'title' => "Bandarban Hill Tracts Adventure",
                'location' => "Bandarban",
                'price' => 13500.00,
                'description' => "Trek Nilgiri, Chimbuk Hill, and Boga Lake for unforgettable mountain experiences.",
                'image' => "pac2.4.webp"
            ]
        ];

        foreach ($packages as $pkgData) {
            Package::updateOrCreate(
                ['title' => $pkgData['title']],
                $pkgData
            );
        }

        // 3. Seed Sample Bookings
        Booking::create([
            'firstname' => 'Tanvir',
            'lastname' => 'Ahmed',
            'email' => 'tanvir@example.com',
            'phone' => '+8801912345678',
            'check_in_date' => '2026-10-15',
            'check_out_date' => '2026-10-18',
            'accommodation' => '3-Star Resort',
            'rooms' => 2,
            'room_type' => 'Deluxe Double',
            'additional' => 'Please arrange airport pickup.',
            'destination' => 'Saint Martin',
            'package_title' => 'Saint Martin Coral Island Escape',
            'package_location' => 'Saint Martin',
            'package_price' => 12500.00,
        ]);

        Booking::create([
            'firstname' => 'Nusrat',
            'lastname' => 'Jahan',
            'email' => 'nusrat@example.com',
            'phone' => '+8801798765432',
            'check_in_date' => '2026-11-01',
            'check_out_date' => '2026-11-04',
            'accommodation' => 'Eco Resort',
            'rooms' => 1,
            'room_type' => 'Hill View Suite',
            'additional' => 'Honeymoon couple setup.',
            'destination' => 'Rangamati',
            'package_title' => 'Sajek Valley Cloud Kingdom Retreat',
            'package_location' => 'Rangamati',
            'package_price' => 11000.00,
        ]);

        // 4. Seed Contact Messages
        ContactMessage::create([
            'name' => 'Rashid Khan',
            'email' => 'rashid@example.com',
            'phone' => '+8801555123456',
            'message' => 'Hello, do you offer customized corporate group packages for Sylhet tea garden tours?',
        ]);
    }
}
