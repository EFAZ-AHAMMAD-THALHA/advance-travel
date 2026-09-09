<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $featuredPackages = Package::where('type', 'tour')->latest()->take(6)->get();
        $featuredBuses = Package::where('type', 'bus')->latest()->take(4)->get();
        $featuredTrains = Package::where('type', 'train')->latest()->take(4)->get();
        $totalPackages = Package::count();

        return view('index', compact('featuredPackages', 'featuredBuses', 'featuredTrains', 'totalPackages'));
    }

    public function explore(Request $request)
    {
        $query = Package::query();

        // 1. Filter by Transport Type (bus, train, tour)
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Helper to expand city search aliases (e.g. Chattogram <-> Chittagong, Sajek <-> Rangamati, Cox's Bazar <-> Cox)
        $expandAliases = function ($text) {
            $cleaned = trim((string)$text);
            if ($cleaned === '') return [];
            $variants = [$cleaned];
            $lower = strtolower($cleaned);

            if (str_contains($lower, 'chattogram') || str_contains($lower, 'chittagong')) {
                $variants[] = 'Chattogram';
                $variants[] = 'Chittagong';
            }
            if (str_contains($lower, 'sajek') || str_contains($lower, 'rangamati')) {
                $variants[] = 'Sajek';
                $variants[] = 'Rangamati';
            }
            if (str_contains($lower, 'cox')) {
                $variants[] = "Cox's Bazar";
                $variants[] = "Coxs Bazar";
                $variants[] = "Cox";
            }
            if (str_contains($lower, 'saint') || str_contains($lower, 'teknaf')) {
                $variants[] = "Saint Martin";
                $variants[] = "Saintmartin";
                $variants[] = "Teknaf";
            }
            if (str_contains($lower, 'sreemangal') || str_contains($lower, 'srimangal')) {
                $variants[] = "Sreemangal";
                $variants[] = "Sylhet";
            }
            return array_unique($variants);
        };

        // 2. Search by Keyword (q, search, or query)
        $keyword = $request->input('q') ?? $request->input('search') ?? $request->input('query');
        if (!empty($keyword)) {
            $variants = $expandAliases($keyword);
            $query->where(function ($q) use ($variants) {
                foreach ($variants as $term) {
                    $q->orWhere('title', 'like', "%{$term}%")
                      ->orWhere('from_location', 'like', "%{$term}%")
                      ->orWhere('to_location', 'like', "%{$term}%")
                      ->orWhere('location', 'like', "%{$term}%")
                      ->orWhere('description', 'like', "%{$term}%");
                }
            });
        }

        // 3. Filter by Origin / From
        if ($request->filled('from')) {
            $fromVariants = $expandAliases($request->from);
            $query->where(function ($q) use ($fromVariants) {
                foreach ($fromVariants as $term) {
                    $q->orWhere('from_location', 'like', "%{$term}%");
                }
            });
        }

        // 4. Filter by Destination / To
        if ($request->filled('to')) {
            $toVariants = $expandAliases($request->to);
            $query->where(function ($q) use ($toVariants) {
                foreach ($toVariants as $term) {
                    $q->orWhere('to_location', 'like', "%{$term}%")
                      ->orWhere('location', 'like', "%{$term}%")
                      ->orWhere('title', 'like', "%{$term}%");
                }
            });
        }

        // 5. Filter by Max Budget
        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // 6. Sort options (e.g. price_asc, price_desc, seats, latest)
        $sort = $request->input('sort', 'latest');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'seats') {
            $query->orderBy('available_seats', 'desc');
        } else {
            $query->latest();
        }

        $items = $query->paginate(9)->withQueryString();

        return view('explore', compact('items'));
    }

    // Package page: show all tour packages
    public function package(Request $request)
    {
        $packages = Package::where('type', 'tour')->latest()->get();
        return view('package', compact('packages'));
    }

    public function locations()
    {
        return view('locations');
    }

    public function info()
    {
        return view('info');
    }

    public function contact()
    {
        return view('contact');
    }

    // Booking page: shows selected package/ticket and pre-populates user data
    public function booking(Request $request)
    {
        $package = null;

        if ($request->has('package_id')) {
            $package = Package::find($request->package_id);
        }

        if (!$package && $request->has('title')) {
            $package = (object) [
                'id'              => null,
                'title'           => $request->title,
                'type'            => $request->type ?? 'tour',
                'from_location'   => $request->from_location ?? 'Dhaka',
                'to_location'     => $request->to_location ?? $request->location ?? 'Destination',
                'location'        => $request->location ?? $request->to_location ?? 'Destination',
                'departure_time'  => $request->departure_time ?? '08:00 AM',
                'price'           => $request->price ?? 1000,
                'available_seats' => 40,
            ];
        }

        return view('booking', compact('package'));
    }

    /**
     * Dynamic Live Flight & Transport Status Endpoint
     */
    public function liveFlightStatus(Request $request)
    {
        $search = strtolower(trim((string) $request->input('query', '')));

        $flights = [
            [
                'id'             => 'FL-101',
                'flight_number'  => 'BG-401',
                'airline'        => 'Biman Bangladesh Airlines',
                'aircraft'       => 'Boeing 787-9 Dreamliner',
                'type'           => 'flight',
                'origin'         => 'Dhaka (DAC)',
                'destination'    => "Cox's Bazar (CXB)",
                'departure_time' => '10:15 AM',
                'arrival_time'   => '11:15 AM',
                'status'         => 'ON TIME',
                'status_color'   => 'success',
                'terminal'       => 'T2',
                'gate'           => 'G04',
                'altitude'       => '28,500 ft',
                'speed'          => '740 km/h',
                'price'          => 4500,
                'seats_left'     => 14,
                'progress_pct'   => 45,
                'is_bookable'    => true,
            ],
            [
                'id'             => 'FL-102',
                'flight_number'  => 'BS-201',
                'airline'        => 'US-Bangla Airlines',
                'aircraft'       => 'ATR 72-600',
                'type'           => 'flight',
                'origin'         => 'Dhaka (DAC)',
                'destination'    => 'Chittagong (CGP)',
                'departure_time' => '11:45 AM',
                'arrival_time'   => '12:35 PM',
                'status'         => 'BOARDING',
                'status_color'   => 'warning',
                'terminal'       => 'T1',
                'gate'           => 'G12',
                'altitude'       => '0 ft (On Ground)',
                'speed'          => '0 km/h',
                'price'          => 3800,
                'seats_left'     => 0,
                'progress_pct'   => 15,
                'is_bookable'    => false,
            ],
            [
                'id'             => 'FL-103',
                'flight_number'  => '2A-502',
                'airline'        => 'Air Astra',
                'aircraft'       => 'ATR 72-600 Express',
                'type'           => 'flight',
                'origin'         => 'Dhaka (DAC)',
                'destination'    => 'Sylhet (ZYL)',
                'departure_time' => '02:30 PM',
                'arrival_time'   => '03:20 PM',
                'status'         => 'IN FLIGHT',
                'status_color'   => 'info',
                'terminal'       => 'T1',
                'gate'           => 'G02',
                'altitude'       => '18,500 ft',
                'speed'          => '520 km/h',
                'price'          => 4100,
                'seats_left'     => 0,
                'progress_pct'   => 70,
                'is_bookable'    => false,
            ],
            [
                'id'             => 'FL-104',
                'flight_number'  => 'BG-603',
                'airline'        => 'Biman Bangladesh Airlines',
                'aircraft'       => 'Dash 8-Q400',
                'type'           => 'flight',
                'origin'         => 'Dhaka (DAC)',
                'destination'    => 'Saidpur (SPD)',
                'departure_time' => '04:00 PM',
                'arrival_time'   => '05:05 PM',
                'status'         => 'ON TIME',
                'status_color'   => 'success',
                'terminal'       => 'T2',
                'gate'           => 'G08',
                'altitude'       => 'Scheduled',
                'speed'          => '0 km/h',
                'price'          => 3500,
                'seats_left'     => 18,
                'progress_pct'   => 0,
                'is_bookable'    => true,
            ]
        ];

        if ($search !== '') {
            $flights = array_values(array_filter($flights, function ($item) use ($search) {
                return str_contains(strtolower($item['flight_number']), $search) ||
                       str_contains(strtolower($item['airline']), $search) ||
                       str_contains(strtolower($item['origin']), $search) ||
                       str_contains(strtolower($item['destination']), $search) ||
                       str_contains(strtolower($item['status']), $search);
            }));
        }

        return response()->json([
            'success'   => true,
            'timestamp' => now()->format('h:i:s A'),
            'total'     => count($flights),
            'data'      => $flights,
        ]);
    }
}
