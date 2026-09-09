<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::query();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('from_location', 'like', "%{$s}%")
                  ->orWhere('to_location', 'like', "%{$s}%")
                  ->orWhere('location', 'like', "%{$s}%");
            });
        }

        $packages = $query->latest()->paginate(10)->withQueryString();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:flight,bus,train,tour',
            'from_location'   => 'nullable|string|max:100',
            'to_location'     => 'nullable|string|max:100',
            'departure_time'  => 'nullable|string|max:50',
            'available_seats' => 'nullable|integer|min:1|max:500',
            'description'     => 'required|string',
            'price'           => 'required|numeric|min:0',
            'location'        => 'nullable|string|max:100',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
        ]);

        $validated['location'] = $validated['to_location'] ?? $validated['location'] ?? 'Destination';
        $validated['available_seats'] = $validated['available_seats'] ?? 40;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $request->file('image')->getClientOriginalName());
            $destinationPath = public_path('uploads/packages');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $request->file('image')->move($destinationPath, $imageName);
            $validated['image'] = $imageName;
        }

        Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', ucfirst($validated['type']) . ' service "' . $validated['title'] . '" created successfully.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'type'            => 'required|in:flight,bus,train,tour',
            'from_location'   => 'nullable|string|max:100',
            'to_location'     => 'nullable|string|max:100',
            'departure_time'  => 'nullable|string|max:50',
            'available_seats' => 'nullable|integer|min:0|max:500',
            'description'     => 'required|string',
            'price'           => 'required|numeric|min:0',
            'location'        => 'nullable|string|max:100',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
        ]);

        $validated['location'] = $validated['to_location'] ?? $validated['location'] ?? $package->location;
        $validated['available_seats'] = $validated['available_seats'] ?? $package->available_seats;

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image && File::exists(public_path('uploads/packages/' . $package->image))) {
                File::delete(public_path('uploads/packages/' . $package->image));
            }

            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $request->file('image')->getClientOriginalName());
            $destinationPath = public_path('uploads/packages');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $request->file('image')->move($destinationPath, $imageName);
            $validated['image'] = $imageName;
        }

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Package $package)
    {
        if ($package->image && File::exists(public_path('uploads/packages/' . $package->image))) {
            File::delete(public_path('uploads/packages/' . $package->image));
        }

        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Service deleted successfully.');
    }
}
