<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Services\CsvReader;
use App\Services\DriveService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ComplaintsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the CSV file with case-sensitive keys
        $csv = CsvReader::read(Storage::drive(DriveService::PARSE)->path('complaints.csv'), keysToLower: false);

        foreach ($csv as $row) {
            // Map CSV columns to the database fields
            $data = [
                'complaint_id' => $row['Complaint_ID'] ?? null,
                'date_logged' => !empty($row['Date_Logged']) ? date('Y-m-d H:i:s', strtotime($row['Date_Logged'])) : null,
                'time' => $row['Time'] ?? null,
                'user_id' => $row['User_ID'] ?? null,
                'station_id' => $row['Station_ID'] ?? null,
                'complainant' => $row['Complainant'] ?? '',
                'status' => $row['Status'] ?? null,
                'display' => isset($row['Display']) ?? null,
                'attachments' => $row['Attachments'] ?? null,
            ];

            // Insert or update the complaint record
            Complaint::query()->updateOrCreate(['complaint_id' => $data['complaint_id']], $data);
        }
    }
}
