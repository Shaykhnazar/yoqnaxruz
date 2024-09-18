<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuel_type',        // Type of fuel
        'system_date',      // System date when the price was logged
        'system_time',      // System time when the price was logged
        'purchase_date',    // Purchase date of the fuel
        'purchase_time',    // Purchase time of the fuel
        'user_geolocation', // Geolocation data of the user
        'litres',           // Amount of fuel in litres
        'price',            // Price of the fuel
        'phone_no',         // Phone number associated with the transaction
        'user_id',          // ID of the user who made the purchase
        'station_id',       // ID of the station where the purchase was made
        'verified_by',      // User who verified the price
        'approved_by',      // User who approved the price
        'photo',            // Photo attachment related to the price
        'comment',          // Additional comments
    ];


}
