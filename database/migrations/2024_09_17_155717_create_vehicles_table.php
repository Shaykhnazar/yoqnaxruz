<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->index()->nullable();
            $table->string('title'); // Title of the vehicle owner (e.g., Mr., Ms.)
            $table->string('first_name'); // Owner's first name
            $table->string('middle_name')->nullable(); // Owner's middle name
            $table->string('last_name'); // Owner's last name
            $table->string('street_address')->nullable(); // Address of the vehicle owner
            $table->string('street_address_2')->nullable(); // Secondary address field
            $table->string('city')->nullable(); // City of residence
            $table->string('state')->nullable(); // State of residence
            $table->string('zipcode')->nullable(); // Zip code
            $table->string('country')->nullable(); // Country of residence
            $table->string('phone1')->nullable(); // Primary phone number
            $table->string('phone2')->nullable(); // Secondary phone number
            $table->date('dob')->nullable(); // Date of birth of the vehicle owner
            $table->string('make')->nullable(); // Make of the vehicle
            $table->string('model')->nullable(); // Model of the vehicle
            $table->string('year')->nullable(); // Year of the vehicle
            $table->string('photo')->nullable(); // Photo or attachment related to the vehicle
            $table->decimal('latitude', 10, 7)->nullable(); // Latitude for geolocation (if needed)
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude for geolocation (if needed)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
