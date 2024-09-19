<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VehicleController extends Controller
{

    public function index()
    {
        // Get vehicles for the currently logged-in user
        $vehicles = Vehicle::where('user_id', Auth::id())->get();

        // Pass the vehicle data to the view
        return view('vehicle.index', compact('vehicles'));
    }


    public function create()
    {
        $states = Vehicle::STATES;
        return view('vehicle.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ]);

        // Handle file upload
        $attachmentPath = '';
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/vehicle', 'public');
        }

        // Create the vehicle record
        Vehicle::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'street_address' => $request->street_address,
            'street_address_2' => $request->street_address_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
            'phone1' => $request->phone,
            'phone2' => $request->phone2,
            'dob' => $request->dob,
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'photo' => $attachmentPath,
            'latitude' => 0, // Placeholder, adjust as needed
            'longitude' => 0, // Placeholder, adjust as needed
        ]);

        return redirect()->route('vehicle.index')->with(['message' => 'Vehicle added successfully.']);
    }
}
