<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',   // ID of the station associated with the feedback
        'date',         // Date when the feedback was given
        'time',         // Time when the feedback was given
        'user_id',      // ID of the user giving the feedback
        'comment',      // Feedback comment
        'user_rating',  // User rating
        'attachments',  // Attachments related to the feedback
    ];
}
