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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_id')->nullable();
            $table->timestamp('date_logged')->nullable();
            $table->time('time')->nullable();
            $table->string('user_id')->index()->nullable();
            $table->string('station_id')->index()->nullable();
            $table->text('complainant');
            $table->string('status')->nullable();
            $table->string('display')->default('Yes')->nullable();
            $table->string('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
