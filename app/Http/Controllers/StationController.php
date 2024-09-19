<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    // Display a listing of the stations managed by the station manager
    public function index()
    {
        // Fetch stations created by the current station manager
        $stations = Station::where('created_by', Auth::id())->get();

        return view('stations.index', compact('stations'));
    }

    // Show the form for creating a new station
    public function create()
    {
        return view('stations.create');
    }

    // Store a newly created station in storage
    public function store(Request $request)
    {
        $request->validate([
            'station_name' => 'required|string|max:255',
            'station_manager' => 'nullable|string|max:255',
            'station_phone' => 'nullable|string|max:20',
            'street_address' => 'required|string|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'opening_time' => 'nullable|string|max:10',
            'closing_time' => 'nullable|string|max:10',
            'comment' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/station', 'public');
        }
        // Generate a unique complaint ID
        $stationID = 'ST-' . random_int(100000, 999999);

        Station::create([
            'station_id' => $stationID,
            'station_name' => $request->station_name,
            'station_manager' => $request->station_manager,
            'station_phone' => $request->station_phone,
            'street_address' => $request->street_address,
            'street_address_2' => $request->street_address_2,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'comments' => $request->comment,
            'created_by' => Auth::id(),
            'attachment' => $attachmentPath,
            'status' => 0,
        ]);

        return redirect()->back()->with('success', 'Station added successfully.');
    }
}
