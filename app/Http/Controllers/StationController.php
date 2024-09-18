<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Support\Facades\Session;

class StationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'station_name' => 'required|string|max:255',
            'station_manager' => 'nullable|string|max:255',
            'station_phone' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'opening_time' => 'nullable|string|max:10',
            'closing_time' => 'nullable|string|max:10',
            'comment' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $attachmentPath = '';
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/station', 'public');
        }

        Station::create([
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
            'created_by' => Session::get('user_id'),
            'attachment' => $attachmentPath,
            'status' => 0,
        ]);

        return response()->json(['message' => 'Station added successfully.']);
    }
}
