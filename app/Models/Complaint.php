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

    public function replies()
    {
        return $this->hasMany(ComplaintReply::class, 'complaint_id', 'complaint_id');
    }

    // Relationship with User who made the complaint
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relationship with the Station which was associated with the complaint
    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'station_id');
    }
}
