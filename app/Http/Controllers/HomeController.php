<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch stations from the database
        $stations = Station::all();  // Assuming you have a Station model and the table name matches

        return view('index', compact('stations'));  // Pass stations to the Blade view
    }

}
