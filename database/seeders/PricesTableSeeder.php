<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Services\CsvReader;
use App\Services\DriveService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the CSV file
        $csv = CsvReader::read(Storage::drive(DriveService::PARSE)->path('prices.csv'), keysToLower: false);

        foreach ($csv as $row) {
            // Map CSV columns to the database fields
            $data = [
                'fuel_type' => $row['Fuel_Type'] ?? null,
                'system_date' => !empty($row['System_date']) ? date('Y-m-d H:i:s', strtotime($row['System_date'])) : null,
                'system_time' => $row['system_time'] ?? null,
                'purchase_date' => !empty($row['Purchase_date']) ? date('Y-m-d H:i:s', strtotime($row['Purchase_date'])) : null,
                'purchase_time' => $row['Purchase_time'] ?? null,
                'user_geolocation' => $row['user_geolocation'] ?? null,
                'litres' => $row['litres'] ?? 0,
                'price' => $row['Price'] ?? 0,
                'phone_no' => $row['phone_no'] ?? null,
                'user_id' => $row['user_id'] ?? null,
                'station_id' => $row['station_id'] ?? null,
                'verified_by' => $row['Verified_By'] ?? null,
                'approved_by' => $row['Approved By'] ?? null,
                'photo' => $row['Photo'] ?? null,
            ];

            // Insert or update the station record
            Price::query()->updateOrCreate(['system_date' => $data['system_date'], 'purchase_date' => $data['purchase_date'], 'station_id' => $data['station_id']], $data);
        }

    }
}
