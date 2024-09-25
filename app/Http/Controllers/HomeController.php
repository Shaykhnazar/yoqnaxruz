<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    // Add this method to handle AJAX requests for stations
    public function findStations(Request $request)
    {
        $search = $request->input('q');

        $stations = Station::query();

        if ($search) {
            $stations = $stations->where('station_name', 'LIKE', '%' . $search . '%')
                ->orWhere('city', 'LIKE', '%' . $search . '%')
                ->orWhere('state', 'LIKE', '%' . $search . '%');
        }

        $stations = $stations->limit(20)->get();

        $formattedStations = [];

        foreach ($stations as $station) {
            $formattedStations[] = [
                'id' => $station->station_id,
                'text' => $station->station_name . ' - ' . $station->city,
            ];
        }

        return response()->json($formattedStations);
    }

}
