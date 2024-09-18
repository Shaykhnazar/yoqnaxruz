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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id')->nullable()->after('id'); // Title (Mr, Ms, etc.)
            $table->string('title')->nullable()->after('user_id'); // Title (Mr, Ms, etc.)
            $table->string('first_name')->nullable()->after('title'); // First name
            $table->string('middle_name')->nullable()->after('first_name'); // Middle name
            $table->string('surname')->nullable()->after('middle_name'); // Surname/Last name
            $table->string('category')->nullable()->after('surname'); // Category (Admin, User type, etc.)
            $table->date('date_of_birth')->nullable()->after('category'); // Date of birth
            $table->string('phone1')->nullable()->after('date_of_birth'); // Primary phone number
            $table->string('phone2')->nullable()->after('phone1'); // Secondary phone number
            $table->string('street_address')->nullable()->after('phone2'); // Street address
            $table->string('created_by')->nullable()->after('street_address'); // Created by reference
            $table->string('approved_by')->nullable()->after('created_by'); // Approved by reference
            $table->string('city')->nullable()->after('approved_by'); // City of residence
            $table->string('state')->nullable()->after('city'); // State of residence
            $table->string('country')->nullable()->after('state'); // Country of residence
            $table->string('zip')->nullable()->after('country'); // Zip code
            $table->string('identity_doc')->nullable()->after('zip'); // Identity document details
            $table->string('photo')->nullable()->after('identity_doc'); // User photo reference
            $table->string('model')->nullable()->after('photo'); // Model (possibly vehicle model)
            $table->string('rego')->nullable()->after('model'); // Registration number (if vehicle-related)
            $table->string('make')->nullable()->after('rego'); // Make (if vehicle-related)
            $table->string('year')->nullable()->after('make'); // Year (if vehicle-related)
            $table->string('status')->nullable()->default('active')->after('year'); // User status (active, inactive)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop columns in the reverse order they were added
            $table->dropColumn([
                'user_id',
                'title',
                'first_name',
                'middle_name',
                'surname',
                'category',
                'date_of_birth',
                'phone1',
                'phone2',
                'street_address',
                'created_by',
                'approved_by',
                'city',
                'state',
                'country',
                'zip',
                'identity_doc',
                'photo',
                'model',
                'rego',
                'make',
                'year',
                'status'
            ]);
        });
    }
};
