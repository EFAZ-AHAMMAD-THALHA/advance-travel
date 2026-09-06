<?php
namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() { 
        return view('index'); 
    }

    // Package page: show all packages from DB
    public function package()
    {
        $packages = Package::all();
        return view('package', compact('packages'));
    }

    public function locations() { 
        return view('locations'); 
    }

    public function info() { 
        return view('info'); 
    }

    public function contact() { 
        return view('contact'); 
    }

    // Booking page: shows selected package
    public function booking(Request $request)
    {
        $package = null;

        // If URL has package info (from Book Now button)
        if ($request->has('title')) {
            $package = (object) [
                'title' => $request->title,
                'location' => $request->location,
                'price' => $request->price,
            ];
        }

        return view('booking', compact('package'));
    }

    public function login() { 
        return view('login'); 
    }

    public function reg() { 
        return view('register'); 
    }

    public function admin() { 
        return view('admin.dashboard'); 
    }
}
