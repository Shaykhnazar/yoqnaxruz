<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',            // Unique station identifier
        'station_name',          // Name of the station
        'city',                  // City where the station is located
        'state',                 // State where the station is located
        'zip_code',              // Zip code of the station's location
        'country',               // Country where the station is located
        'station_manager_id',    // ID of the station manager
        'station_phone1',        // Primary phone number for the station
        'station_phone2',        // Secondary phone number for the station
        'street_address',        // Street address of the station
        'opening_hours',         // Opening hours of the station
        'closing_time',          // Closing time of the station
        'geolocation',           // Geolocation data for the station
        'date_created',          // Date the station was created
        'date_verified',         // Date the station was verified
        'date_approved',         // Date the station was approved
        'added_by',              // User who added the station
        'verifier',              // User who verified the station
        'approver',              // User who approved the station
        'comment',               // Comments about the station
    ];


    public function getLatitudeAttribute($value)
    {
        if ($this->geolocation) {
            $coords = explode(',', $this->geolocation);
            return isset($coords[0]) ? (float) $coords[0] : null;
        }
        return null;
    }

    public function getLongitudeAttribute($value)
    {
        if ($this->geolocation) {
            $coords = explode(',', $this->geolocation);
            return isset($coords[1]) ? (float) $coords[1] : null;
        }
        return null;
    }
}
