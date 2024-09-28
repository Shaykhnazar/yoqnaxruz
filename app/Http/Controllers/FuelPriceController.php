<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Station;
use App\Services\IDGeneratorService;
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
            'purchase_date.required' => 'Purchase date is required.',
            'purchase_date.date' => 'Purchase date must be a valid date.',
            'purchase_date.before_or_equal' => 'Purchase date cannot be in the future.',

            'purchase_time.required' => 'Purchase time is required.',
            'purchase_time.date_format' => 'Purchase time must be in the format HH:MM.',

            'litres.required' => 'Litres is required.',
            'litres.numeric' => 'Litres must be a numeric value.',
            'litres.min' => 'Litres cannot be negative.',

            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a numeric value between 0 and 99999.99.',
            'price.min' => 'Price must be at least 0.',
            'price.max' => 'Price cannot exceed 99999.99.',

            'phone_no.required' => 'Phone number is required.',
            'phone_no.string' => 'Phone number must be a valid string.',
            'phone_no.max' => 'Phone number cannot exceed 15 characters.',

            'station_id.required' => 'Station ID is required.',
            'station_id.string' => 'Station ID must be a valid string.',
            'station_id.max' => 'Station ID cannot exceed 255 characters.',

            'attachment.file' => 'The attachment must be a file.',
            'attachment.mimes' => 'The attachment must be a file of type: jpg, jpeg, png, pdf.',
            'attachment.max' => 'The attachment cannot exceed 2MB.',

            'comment.string' => 'Comment must be a valid string.',
            'comment.max' => 'Comment cannot exceed 255 characters.',

            'fuel_type.required' => 'Fuel type is required.',
            'fuel_type.string' => 'Fuel type must be a valid string.',
            'fuel_type.max' => 'Fuel type cannot exceed 255 characters.',
        ];

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'purchase_date' => 'required|date|before_or_equal:today',
            'purchase_time' => 'required|date_format:H:i',
            'litres' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0|max:99999.99',
            'phone_no' => 'required|string|max:15',
            'station_id' => 'required|string|max:255',
            'new_station_address' => 'nullable|required_if:station_id,new',
            'new_station_phone' => 'nullable|required_if:station_id,new',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'comment' => 'nullable|string|max:255',
            'fuel_type' => 'required|string|max:255',
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
                    'station_id' => IDGeneratorService::generateId(Station::max('id'), 'ST-'),
                    'station_name' => $stationId, // As per your requirement
                    'street_address' => $request->input('new_station_address') ?? '',
                    'station_phone1' => $request->input('new_station_phone') ?? '',
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
                'fuel_type' => $request->fuel_type,
                'litres' => $request->litres,
                'price' => $request->price,
                'phone_no' => $request->phone_no,
                'station_id' => $stationId,
                'photo' => $attachmentPath,
                'user_geolocation' => $request->latitude && $request->longitude ? $request->latitude . ',' . $request->longitude : null,
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

//    public function fetchResults(Request $request)
//    {
//        $searchAddress = $request->input('searchadd');
//
//        // Query Stations with their latest approved price
//        $stationsQuery = Station::with(['prices' => function ($query) {
//            $query->whereNotIn('verified_by', ['Pending', 'Rejected'])
//                ->whereNotIn('approved_by', ['Pending', 'Rejected'])
//                ->latest('system_date');
//        }]);
//
//        if ($searchAddress) {
//            $stationsQuery->where('street_address', 'LIKE', '%' . $searchAddress . '%');
//        }
//
//        // Get the stations with their latest price
//        $stations = $stationsQuery->get();
//
//        // Transform the data to return stations with their latest approved price
//        $data = $stations->map(function ($station) {
//            $latestPrice = $station->prices->first(); // Get the latest price from the relationship
//
//            return [
//                'id' => $station->id,
//                'station_id' => $station->station_id,
//                'station_name' => $station->station_name,
//                'street_address' => $station->street_address,
//                'geolocation' => $station->geolocation,
//                'phone_no' => $station->phone_no,
//                'fuel_type' => $latestPrice ? $latestPrice->fuel_type : null,
//                'before6amprice' => $latestPrice ? $latestPrice->before6amprice : null,
//                'after6amprice' => $latestPrice ? $latestPrice->after6amprice : null,
//            ];
//        });
//
//        return response()->json(['stations' => $data]);
//    }

    public function fetchResults(Request $request)
    {
        $searchAddress = $request->input('searchadd');

        // Subquery to get the latest approved price for each station
        $latestPricesSubquery = Price::latestApprovedPricePerStation();

        // Main query: Join stations with the latest prices and eager load feedbacks
        $stationsQuery = Station::with('feedbacks') // Eager load feedbacks for optimization
            ->joinSub($latestPricesSubquery, 'latest_prices', function ($join) {
                $join->on('stations.station_id', '=', 'latest_prices.station_id');
            })
            ->join('prices', function ($join) {
                $join->on('stations.station_id', '=', 'prices.station_id')
                    ->on('prices.system_date', '=', 'latest_prices.latest_price_date');
            })
            ->select('stations.*', 'prices.fuel_type', 'prices.price', 'prices.phone_no');

        // Filter by search address if provided
        if ($searchAddress) {
            $stationsQuery->where('stations.street_address', 'LIKE', '%' . $searchAddress . '%');
        }

        // Execute the query and get results
        $stations = $stationsQuery->get();

        // Transform the data to return stations with their latest approved price
        $data = $stations->map(function ($station) {
            return [
                'id' => $station->id,
                'station_id' => $station->station_id,
                'station_name' => $station->station_name,
                'street_address' => $station->street_address,
                'geolocation' => $station->geolocation,
                'phone_no' => $station->phone_no,
                'fuel_type' => $station->fuel_type,
                'before6amprice' => $station->price,
                'after6amprice' => $station->price,
                'feedbackCount' => $station->feedback_count ?? 0, // Using the accessor method from the Station model
                'averageRating' => $station->average_rating ?? 0, // Using the accessor method from the Station model
            ];
        });

        return response()->json(['stations' => $data]);
    }

    public function checkStationExists(Request $request)
    {
        $stationId = $request->input('station_id');

        // Check if the station exists
        $stationExists = Station::where('station_id', $stationId)->exists();

        return response()->json(['exists' => $stationExists]);
    }

}

