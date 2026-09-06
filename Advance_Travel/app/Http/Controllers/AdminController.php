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
        $recentBookings = Booking::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalBookings', 'totalPackages', 'totalContacts', 'recentBookings'));
    }

    public function bookings()
    {
        $bookings = Booking::latest()->paginate(10);
        return view('admin.bookings', compact('bookings'));
    }

    public function destroyBooking(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking deleted successfully.');
    }

    public function contacts()
    {
        $contacts = ContactMessage::latest()->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    public function destroyContact(ContactMessage $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contact message deleted successfully.');
    }
}
