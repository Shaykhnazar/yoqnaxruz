<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FuelPriceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'purchase_time' => 'required',
            'litres' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'phone_number' => 'required|string|max:15',
            'station_id' => 'required|exists:stations,id',
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
            'amount' => $request->amount,
            'phone_number' => $request->phone_number,
            'station_id' => $request->station_id,
            'attachment' => $attachmentPath,
            'latitude' => 0, // Placeholder
            'longitude' => 0, // Placeholder
            'entry_date' => now(),
        ]);

        return response()->json(['message' => 'Price added successfully.']);
    }
}

