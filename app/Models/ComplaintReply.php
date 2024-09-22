<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintReply extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'complaint_id',
        'user_id',
        'comment',
        'date',
        'reply_by',
    ];

}
