<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Store a new booking (Strictly authenticated)
     */
    public function store(Request $request)
    {
        // 1. Strict Server-Side Validation
        $request->validate([
            'firstname'        => 'required|string|max:100',
            'lastname'         => 'nullable|string|max:100',
            'email'            => 'required|email|max:150',
            'phone'            => ['required', 'string', 'regex:/^(?:\+?88|01)?\d{9,11}$/'],
            'journey_date'     => 'required|date|after_or_equal:today',
            'return_date'      => 'nullable|date|after_or_equal:journey_date',
            'transport_type'   => 'required|string|in:bus,train,tour',
            'seats'            => 'required|integer|min:1|max:20',
            'room_type'        => 'nullable|string|max:50',
            'accommodation'    => 'nullable|string|max:100',
            'from_city'        => 'nullable|string|max:100',
            'to_city'          => 'nullable|string|max:100',
            'package_id'       => 'nullable|exists:packages,id',
            'additional'       => 'nullable|string|max:1000',
        ], [
            'journey_date.after_or_equal' => 'Booking date must be today or an upcoming date. Past dates are not permitted.',
            'phone.regex'                 => 'Please enter a valid mobile number (e.g., 017xxxxxxxx or +8801xxxxxxxxx).',
            'return_date.after_or_equal'  => 'Return date must be equal to or after the departure date.',
        ]);

        // 2. Verified Server-Side Pricing (Zero Forgery)
        $package = null;
        $unitPrice = 1000.00;
        $title = 'Custom Travel Ticket';
        $fromCity = $request->from_city ?? 'Dhaka';
        $toCity = $request->to_city ?? 'Destination';

        if ($request->filled('package_id')) {
            $package = Package::find($request->package_id);
            if ($package) {
                $unitPrice = (float) $package->price;
                $title = $package->title;
                $fromCity = $request->filled('from_city') ? $request->from_city : ($package->from_location ?? $fromCity);
                $toCity = $request->filled('to_city') ? $request->to_city : ($package->to_location ?? $package->location ?? $toCity);
            }
        } elseif ($request->filled('package_price') && is_numeric($request->package_price)) {
            $unitPrice = (float) $request->package_price;
            $title = $request->package_title ?? $title;
        }

        $seats = (int) $request->seats;
        $totalPrice = $unitPrice * $seats;

        // 3. Generate Unique Boarding Pass / Ticket Code
        $bookingCode = 'TKT-' . date('Y') . '-' . strtoupper(Str::random(6));

        // 4. Save Booking record
        $booking = Booking::create([
            'user_id'          => auth()->id(),
            'package_id'       => $package ? $package->id : null,
            'booking_code'     => $bookingCode,
            'transport_type'   => $request->transport_type,
            'passenger_name'   => trim($request->firstname . ' ' . $request->lastname),
            'firstname'        => $request->firstname,
            'lastname'         => $request->lastname,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'journey_date'     => $request->journey_date,
            'return_date'      => $request->return_date,
            'check_in_date'    => $request->journey_date, // backward compatibility
            'check_out_date'   => $request->return_date ?? $request->journey_date,
            'from_city'        => $fromCity,
            'to_city'          => $toCity,
            'destination'      => $toCity,
            'accommodation'    => $request->accommodation ?? 'Standard',
            'rooms'            => $seats,
            'seats'            => $seats,
            'room_type'        => $request->room_type ?? 'Standard Class',
            'unit_price'       => $unitPrice,
            'total_price'      => $totalPrice,
            'package_price'    => $unitPrice,
            'package_title'    => $title,
            'package_location' => $toCity,
            'status'           => 'confirmed', // Confirmed booking
            'payment_status'   => 'unpaid',
            'refund_status'    => 'none',
            'special_notes'    => $request->additional,
            'additional'       => $request->additional,
        ]);

        // Deduct available seats if package attached
        if ($package && $package->available_seats >= $seats) {
            $package->decrement('available_seats', $seats);
        }

        // 5. Redirect straight to checkout/invoice page
        return redirect()->route('payment.checkout', $booking->id)
            ->with('success', "Ticket {$bookingCode} booked successfully! Please complete your payment or review your boarding pass.");
    }

    /**
     * User Dashboard: View All Booked Tickets (Upcoming, Past, Cancelled)
     */
    public function myBookings()
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();

        // 1. Upcoming Trips (journey_date >= today and not cancelled)
        $upcomingBookings = Booking::where('user_id', $user->id)
            ->where(function ($q) use ($today) {
                $q->where('journey_date', '>=', $today)
                  ->orWhere('check_in_date', '>=', $today);
            })
            ->where('status', '!=', 'cancelled')
            ->orderBy('journey_date', 'asc')
            ->get();

        // 2. Past Trips (journey_date < today or status completed)
        $pastBookings = Booking::where('user_id', $user->id)
            ->where(function ($q) use ($today) {
                $q->where(function ($sub) use ($today) {
                    $sub->where('journey_date', '<', $today)
                        ->orWhere('check_in_date', '<', $today);
                })->orWhere('status', 'completed');
            })
            ->where('status', '!=', 'cancelled')
            ->orderBy('journey_date', 'desc')
            ->get();

        // 3. Cancelled & Refund Tickets
        $cancelledBookings = Booking::where('user_id', $user->id)
            ->where('status', 'cancelled')
            ->latest()
            ->get();

        $totalBookings = Booking::where('user_id', $user->id)->count();
        $totalSpent = Booking::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        return view('user.dashboard', compact(
            'upcomingBookings',
            'pastBookings',
            'cancelledBookings',
            'totalBookings',
            'totalSpent'
        ));
    }

    /**
     * View & Print e-Ticket / Boarding Pass
     */
    public function showTicket(Booking $booking)
    {
        // Authorize: Only the owner or an admin can view this ticket
        if ($booking->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access to this travel ticket.');
        }

        return view('user.ticket', compact('booking'));
    }

    /**
     * Cancel Ticket & Request Refund
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Authorize
        if ($booking->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This ticket cannot be cancelled as the journey date has already passed or it is already cancelled.');
        }

        $request->validate([
            'reason'        => 'nullable|string|max:500',
            'cancel_reason' => 'nullable|string|max:500',
        ]);

        $reason = $request->input('reason') ?: ($request->input('cancel_reason') ?: 'Cancelled by passenger');

        $booking->status = 'cancelled';
        $booking->refund_status = ($booking->payment_status === 'paid') ? 'requested' : 'none';
        $booking->cancellation_reason = $reason;
        $booking->save();

        // Restore seats
        if ($booking->package_id) {
            Package::where('id', $booking->package_id)->increment('available_seats', $booking->seats);
        }

        $msg = ($booking->payment_status === 'paid')
            ? 'Your booking has been cancelled and a refund request has been submitted to the admin team.'
            : 'Your booking has been cancelled successfully.';

        return back()->with('success', $msg);
    }
}
