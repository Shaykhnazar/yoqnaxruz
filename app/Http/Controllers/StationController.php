<?php

namespace App\Http\Controllers;

use App\Services\IDGeneratorService;
use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    // Display a listing of the stations managed by the station manager
    public function index()
    {
        // Fetch stations created by the current station manager
        $stations = Station::where('added_by', Auth::user()->user_id)->get();

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
        // Custom validation messages
        $messages = [
            'station_name.required' => 'Station name is required.',
            'station_name.string' => 'Station name must be a valid string.',
            'station_name.max' => 'Station name cannot exceed 255 characters.',

            'station_manager.string' => 'Station manager name must be a valid string.',
            'station_manager.max' => 'Station manager name cannot exceed 255 characters.',

            'station_phone.string' => 'Station phone must be a valid string.',
            'station_phone.max' => 'Station phone cannot exceed 20 characters.',

            'street_address.required' => 'Street address is required.',
            'street_address.string' => 'Street address must be a valid string.',
            'street_address.max' => 'Street address cannot exceed 255 characters.',

            'street_address_2.string' => 'Street address 2 must be a valid string.',
            'street_address_2.max' => 'Street address 2 cannot exceed 255 characters.',

            'city.required' => 'City is required.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City cannot exceed 255 characters.',

            'state.required' => 'State is required.',
            'state.string' => 'State must be a valid string.',
            'state.max' => 'State cannot exceed 255 characters.',

            'zipcode.string' => 'Zipcode must be a valid string.',
            'zipcode.max' => 'Zipcode cannot exceed 20 characters.',

            'country.required' => 'Country is required.',
            'country.string' => 'Country must be a valid string.',
            'country.max' => 'Country cannot exceed 255 characters.',

            'opening_time.string' => 'Opening time must be a valid string.',
            'opening_time.max' => 'Opening time cannot exceed 10 characters.',

            'closing_time.string' => 'Closing time must be a valid string.',
            'closing_time.max' => 'Closing time cannot exceed 10 characters.',

            'comment.string' => 'Comment must be a valid string.',

            'attachment.file' => 'The attachment must be a file.',
            'attachment.mimes' => 'The attachment must be a file of type: jpg, jpeg, png, pdf.',
            'attachment.max' => 'The attachment size cannot exceed 2MB.',
        ];

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
        ], $messages);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/station', 'public');
        }
        Station::create([
            'station_id' => IDGeneratorService::generateId(Station::max('id'), 'ST-'),
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
            'added_by' => Auth::user()->user_id,
            'attachment' => $attachmentPath,
            'status' => 0,
        ]);

        return redirect()->route('stations')->with('success', 'Station added successfully.');
    }
}
