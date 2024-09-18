<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FuelPriceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'purchase_time' => 'required',
            'litres' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'phone_no' => 'required|string|max:15',
            'station_id' => 'required',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $attachmentPath = '';
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/price', 'public');
        }

        Price::create([
            'user_id' => Session::get('user_id'),
            'purchase_date' => $request->purchase_date,
            'purchase_time' => $request->purchase_time,
            'litres' => $request->litres,
            'price' => $request->price,
            'phone_no' => $request->phone_no,
            'station_id' => $request->station_id,
            'attachment' => $attachmentPath,
            'latitude' => 0, // Placeholder
            'longitude' => 0, // Placeholder
            'entry_date' => now(),
            'system_date' => now(),
            'system_time' => now(),
        ]);

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

        $prices = $pricesQuery->get();

        if ($prices->isEmpty()) {
            return response()->json(['message' => 'No Data Found'], 404);
        }

        return view('partials.showresults', compact('prices'))->render();
    }
}

