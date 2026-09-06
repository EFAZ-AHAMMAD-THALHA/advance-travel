<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'firstname'        => 'required|string|max:255',
            'lastname'         => 'nullable|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:20',
            'check_in_date'    => 'required|date',
            'check_out_date'   => 'required|date',
            'accommodation'    => 'required|string|max:255',
            'rooms'            => 'required|integer|min:1',
            'room_type'        => 'required|string|max:50',
            'additional'       => 'nullable|string',
            'destination'      => 'nullable|string|max:255',
            'package_title'    => 'nullable|string|max:255',
            'package_location' => 'nullable|string|max:255',
            'package_price'    => 'nullable|numeric',
        ]);

        Booking::create([
            'firstname'        => $request->firstname,
            'lastname'         => $request->lastname,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'check_in_date'    => $request->check_in_date,
            'check_out_date'   => $request->check_out_date,
            'accommodation'    => $request->accommodation,
            'rooms'            => $request->rooms,
            'room_type'        => $request->room_type,
            'additional'       => $request->additional,
            'destination'      => $request->destination ?? 'Not Provided',
            'package_title'    => $request->package_title ?? null,
            'package_location' => $request->package_location ?? null,
            'package_price'    => $request->package_price ?? null,
        ]);

        return back()->with('success', 'Booking submitted successfully!');
    }
}
