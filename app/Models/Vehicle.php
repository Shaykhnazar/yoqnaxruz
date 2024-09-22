<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'street_address',
        'street_address_2',
        'city',
        'state',
        'zipcode',
        'country',
        'phone1',
        'phone2',
        'dob',
        'make',
        'model',
        'year',
        'photo',
        'latitude',
        'longitude',
    ];

    public const STATES = [
        'Abia' => 'Abia',
        'Adamawa' => 'Adamawa',
        'Akwa Ibom' => 'Akwa Ibom',
        'Anambra' => 'Anambra',
        'Bauchi' => 'Bauchi',
        'Bayelsa' => 'Bayelsa',
        'Benue' => 'Benue',
        'Borno' => 'Borno',
        'Cross River' => 'Cross River',
        'Delta' => 'Delta',
        'Ebonyi' => 'Ebonyi',
        'Edo' => 'Edo',
        'Ekiti' => 'Ekiti',
        'Enugu' => 'Enugu',
        'Gombe' => 'Gombe',
        'Imo' => 'Imo',
        'Jigawa' => 'Jigawa',
        'Kaduna' => 'Kaduna',
        'Kano' => 'Kano',
        'Katsina' => 'Katsina',
        'Kebbi' => 'Kebbi',
        'Kogi' => 'Kogi',
        'Kwara' => 'Kwara',
        'Lagos' => 'Lagos',
        'Nasarawa' => 'Nasarawa',
        'Niger' => 'Niger',
        'Ogun' => 'Ogun',
        'Ondo' => 'Ondo',
        'Osun' => 'Osun',
        'Oyo' => 'Oyo',
        'Plateau' => 'Plateau',
        'Rivers' => 'Rivers',
        'Sokoto' => 'Sokoto',
        'Taraba' => 'Taraba',
        'Yobe' => 'Yobe',
        'Zamfara' => 'Zamfara',
        'FCT' => 'Federal Capital Territory',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
