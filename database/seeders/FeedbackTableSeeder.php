<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Services\CsvReader;
use App\Services\DriveService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FeedbackTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the CSV file with case-sensitive keys
        $csv = CsvReader::read(Storage::drive(DriveService::PARSE)->path('feedback.csv'), keysToLower: false);

        foreach ($csv as $row) {
            // Map CSV columns to the database fields
            $data = [
                'station_id' => $row['Station_ID'] ?? null,
                'date' => !empty($row['Date']) ? date('Y-m-d H:i:s', strtotime($row['Date'])) : null,
                'time' => $row['Time'] ?? null,
                'user_id' => $row['User_Id'] ?? null,
                'comment' => $row['Comment'] ?? '',
                'user_rating' => $row['User_Rating'] ?? null,
                'attachments' => $row['Attachments'] ?? null,
            ];

            // Insert or update the feedback record
            Feedback::query()->updateOrCreate(['station_id' => $data['station_id'], 'date' => $data['date'], 'user_id' => $data['user_id']], $data);
        }
    }
}
