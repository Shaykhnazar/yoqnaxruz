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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('fuel_type')->nullable();
            $table->timestamp('system_date');
            $table->time('system_time');
            $table->timestamp('purchase_date');
            $table->time('purchase_time');
            $table->string('user_geolocation')->nullable();
            $table->decimal('litres', 8, 2);
            $table->decimal('price', 8, 2);
            $table->string('phone_no')->nullable();
            $table->string('user_id')->index()->nullable();
            $table->string('station_id')->index();
            $table->string('verified_by')->index()->nullable()->default('Pending');
            $table->string('approved_by')->index()->nullable()->default('Pending');
            $table->string('photo')->nullable();
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
