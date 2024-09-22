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
        Schema::create('complaint_replies', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_id')->index();
            $table->string('user_id')->index();
            $table->text('comment');
            $table->timestamp('date')->nullable();
            $table->string('reply_by'); // 'User' or 'Admin'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_replies');
    }
};
