<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',   // Unique complaint identifier
        'date_logged',    // Date the complaint was logged
        'time',           // Time the complaint was logged
        'user_id',        // ID of the user making the complaint
        'station_id',     // ID of the station associated with the complaint
        'complainant',    // Complainant's description
        'status',         // Status of the complaint
        'display',        // Whether the complaint is displayed
        'attachments',    // Attachments related to the complaint
    ];

}
