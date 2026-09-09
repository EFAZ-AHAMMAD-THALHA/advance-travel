<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Package;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $totalPackages = Package::count();
        $totalContacts = ContactMessage::count();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
        $pendingRefunds = Booking::where('refund_status', 'requested')->count();
        $recentBookings = Booking::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalPackages',
            'totalContacts',
            'totalRevenue',
            'pendingRefunds',
            'recentBookings'
        ));
    }

    public function bookings(Request $request)
    {
        $query = Booking::query();

        // Filter by Transport Type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('transport_type', $request->type);
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Payment Status
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by Booking Code, Passenger Name, Phone or Email
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('passenger_name', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(12)->withQueryString();

        return view('admin.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status'         => 'required|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
        ]);

        $booking->status = $request->status;
        $booking->payment_status = $request->payment_status;

        if ($request->status === 'cancelled' && $booking->refund_status === 'none' && $request->payment_status === 'refunded') {
            $booking->refund_status = 'refunded';
        }

        $booking->save();

        return back()->with('success', "Booking #{$booking->booking_code} status updated successfully.");
    }

    public function processRefund(Request $request, Booking $booking)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($request->action === 'approve') {
            $booking->refund_status = 'refunded';
            $booking->payment_status = 'refunded';
            $booking->status = 'cancelled';
            $booking->save();

            return back()->with('success', "Refund of ৳" . number_format($booking->total_price, 2) . " approved and marked as refunded for Ticket #{$booking->booking_code}.");
        } else {
            $booking->refund_status = 'rejected';
            $booking->save();

            return back()->with('info', "Refund request for Ticket #{$booking->booking_code} was rejected.");
        }
    }

    public function destroyBooking(Booking $booking)
    {
        $code = $booking->booking_code;

        // Restore package seats if booking was active
        if ($booking->package_id && $booking->status !== 'cancelled') {
            Package::where('id', $booking->package_id)->increment('available_seats', $booking->seats);
        }

        $booking->delete();
        return back()->with('success', "Booking #{$code} deleted successfully.");
    }

    public function contacts()
    {
        $contacts = ContactMessage::latest()->paginate(10)->withQueryString();
        return view('admin.contacts', compact('contacts'));
    }

    public function destroyContact(ContactMessage $contact)
    {
        $contact->delete();
        return back()->with('success', 'Customer inquiry message deleted successfully.');
    }
}
