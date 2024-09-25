<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Services\CsvReader;
use App\Services\DriveService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the CSV file
        $csv = CsvReader::read(Storage::drive(DriveService::PARSE)->path('stations.csv'), keysToLower: false);
        // Create a Faker instance
        $faker = Factory::create();

        foreach ($csv as $row) {
            // Map CSV columns to the database fields
            $data = [
                'station_id' => $row['Station_ID'] ?? null,
                'station_name' => $row['Station_name'] ?? null,
                'city' => $row['City'] ?? null,
                'state' => $row['State'] ?? null,
                'zip_code' => $row['Zip Code'] ?? null,
                'country' => $row['Country'] ?? null,
                'date_created' => !empty($row['Date_Created']) ? date('Y-m-d H:i:s', strtotime($row['Date_Created'])) : null,
                'station_manager_id' => $row['Station_Manager ID'] ?? null,
                'station_phone1' => $row['Station_phone1'] ?? null,
                'station_phone2' => $row['Station_phone2'] ?? null,
                'street_address' => $row['Street Address'] ?? null,
                'opening_hours' => $row['Opening_Hours'] ?? null,
                'closing_time' => $row['closing_time'] ?? null,
                'added_by' => $row['Added_By'] ?? null,
                'geolocation' => $row['geolocation'] ?? $faker->latitude . ',' . $faker->longitude,
                'verifier' => $row['Verifier'] ?? null,
                'date_verified' => !empty($row['Date_Verified']) ? date('Y-m-d H:i:s', strtotime($row['Date_Verified'])) : null,
                'approver' => $row['Approver'] ?? null,
                'date_approved' => !empty($row['Date_Approved']) ? date('Y-m-d H:i:s', strtotime($row['Date_Approved'])) : null,
                'comment' => $row['Comment'] ?? null,
            ];

            // Insert or update the station record
            Station::query()->updateOrCreate(['station_id' => $data['station_id']], $data);
        }
    }
}
