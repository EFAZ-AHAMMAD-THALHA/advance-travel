<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/packages'), $imageName);
            $data['image'] = $imageName;
        }

        Package::create($data);

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image && File::exists(public_path('uploads/packages/'.$package->image))) {
                File::delete(public_path('uploads/packages/'.$package->image));
            }

            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/packages'), $imageName);
            $data['image'] = $imageName;
        }

        $package->update($data);

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package)
    {
        // Delete image if exists
        if ($package->image && File::exists(public_path('uploads/packages/'.$package->image))) {
            File::delete(public_path('uploads/packages/'.$package->image));
        }

        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully');
    }
}
