<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the traveler profile settings page.
     */
    public function show()
    {
        $user = auth()->user();

        // Calculate user trip statistics
        $totalTrips = Booking::where('user_id', $user->id)->count();
        $completedTrips = Booking::where('user_id', $user->id)->where('status', 'completed')->count();
        $upcomingTrips = Booking::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) {
                $today = now()->toDateString();
                $q->where('journey_date', '>=', $today)
                  ->orWhere('check_in_date', '>=', $today);
            })->count();

        $totalSpent = Booking::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        return view('user.profile', compact('user', 'totalTrips', 'completedTrips', 'upcomingTrips', 'totalSpent'));
    }

    /**
     * Update traveler profile details.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'              => 'required|string|max:150',
            'phone'             => ['nullable', 'string', 'regex:/^(?:\+?88|01)?\d{9,11}$/'],
            'address'           => 'nullable|string|max:255',
            'emergency_contact' => ['nullable', 'string', 'regex:/^(?:\+?88|01)?\d{9,11}$/'],
        ], [
            'phone.regex'             => 'Please enter a valid mobile number (e.g. 017xxxxxxxx or +8801xxxxxxxxx).',
            'emergency_contact.regex' => 'Please enter a valid emergency contact number.',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile information updated successfully!');
    }

    /**
     * Update account password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password'         => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
            ],
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password provided is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Your password has been changed successfully!');
    }
}
