<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FuelPriceController extends Controller
{
    public function store(Request $request)
    {
        // Define custom validation messages (optional)
        $messages = [
            'station_id.required' => 'Station ID is required.',
            'station_id.string' => 'Station ID must be a string.',
            'station_id.max' => 'Station ID cannot exceed 255 characters.',
            // Add other custom messages as needed
        ];

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'purchase_date' => 'required|date|before_or_equal:today',
            'purchase_time' => 'required|date_format:H:i',
            'litres' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'phone_no' => 'required|string|max:15',
            'station_id' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        $attachmentPath = '';
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/price', 'public');
        }

        // Retrieve the station_id from the request
        $stationId = $request->input('station_id');

        // Check if the station exists
        $station = Station::where('station_id', $stationId)->first();

        if (!$station) {
            // Station does not exist, create a new one
            // Generate a unique station_id (if needed).
            // However, since station_id is provided, ensure it's unique.
            try {
                Station::create([
                    'station_id' => $stationId,
                    'station_name' => $stationId, // As per your requirement
                    'date_created' => now(),
                    'added_by' => Auth::check() ? Auth::user()->user_id ?? 'unregistered' : 'unregistered',
                    'comment' => 'Not verified',
                ]);
            } catch (\Exception $e) {
                // Handle exception if station creation fails
                return response()->json(['message' => 'Failed to create station.', 'error' => $e->getMessage()], 500);
            }
        }

        // Proceed to create the Price entry
        try {
            Price::create([
                'user_id' => Auth::id()->user_id ?? 'unregistered',
                'purchase_date' => $request->purchase_date,
                'purchase_time' => $request->purchase_time,
                'litres' => $request->litres,
                'price' => $request->price,
                'phone_no' => $request->phone_no,
                'station_id' => $stationId,
                'attachment' => $attachmentPath,
                'latitude' => 0, // Placeholder
                'longitude' => 0, // Placeholder
                'entry_date' => now(),
                'system_date' => now(),
                'system_time' => now(),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally, delete the uploaded file if Price creation fails
            if ($attachmentPath) {
                Storage::disk('public')->delete($attachmentPath);
            }

            return response()->json(['message' => 'Failed to add price.', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Price added successfully.']);
    }

    public function fetchResults(Request $request)
    {
        $searchAddress = $request->input('searchadd');

        // Fetch prices and join with stations table manually
        $pricesQuery = DB::table('prices')
            ->join('stations', 'prices.station_id', '=', 'stations.station_id')
            ->select('prices.*', 'stations.station_name', 'stations.street_address', 'stations.geolocation');

        if ($searchAddress) {
            $pricesQuery->where('stations.street_address', 'LIKE', '%' . $searchAddress . '%');
        }

        $prices = $pricesQuery->whereNotIn('verified_by', ['Pending', 'Rejected'])->get();

        if ($prices->isEmpty()) {
            return response()->json(['message' => 'No Data Found'], 404);
        }

        return view('partials.showresults', compact('prices'))->render();
    }
}

