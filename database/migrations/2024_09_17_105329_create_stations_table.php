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
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('station_id')->index()->unique();
            $table->string('station_name')->index();
            $table->string('city')->index()->nullable();
            $table->string('state')->index()->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('station_manager_id')->index()->nullable();
            $table->string('station_phone1')->nullable();
            $table->string('station_phone2')->nullable();
            $table->string('street_address')->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('closing_time')->nullable();
            $table->string('geolocation')->nullable();
            $table->timestamp('date_created')->nullable();
            $table->timestamp('date_verified')->nullable();
            $table->timestamp('date_approved')->nullable();
            $table->string('added_by')->index()->nullable()->default('Unregistered');
            $table->string('verifier')->index()->nullable()->default('Pending');
            $table->string('approver')->index()->nullable()->default('Pending');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
