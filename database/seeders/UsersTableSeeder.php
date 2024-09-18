<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\CsvReader;
use App\Services\DriveService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = CsvReader::read(Storage::drive(DriveService::PARSE)->path('users.csv'), keysToLower: false);
        foreach ($csv as $row) {
            // Map CSV columns to the database fields
            $data = [
                'user_id' => $row['User_ID'],
                'title' => $row['Title'] ?? null,
                'first_name' => $row['First Name'],
                'middle_name' => $row['Middle Name'] ?? null,
                'surname' => $row['Surname'],
                'category' => $row['Category'] ?? null,
                'date_of_birth' => !empty($row['Date of Birth']) ? date('Y-m-d', strtotime($row['Date of Birth'])) : null,
                'city' => $row['City'] ?? null,
                'state' => $row['State'] ?? null,
                'country' => $row['Country'] ?? null,
                'zip' => $row['Zip'] ?? null,
                'identity_doc' => $row['Identity_Doc'] ?? null,
                'photo' => $row['Photo'] ?? null,
                'model' => $row['Model'] ?? null,
                'rego' => $row['Rego'] ?? null,
                'make' => $row['Make'] ?? null,
                'year' => $row['Year'] ?? null,
                'status' => 'active', // Default status
                'name' => $row['First Name'] . ' ' . $row['Surname'],
                'email' => $row['email'],
                'password' => Hash::make(Str::random(10)), // Generating a random password
            ];

            // Insert or update the user record
            $user = User::query()->updateOrCreate(['user_id' => $data['user_id']], $data);
            $user->assignRole($row['Category']);
        }

        // Create super admin user
        $filamentMakeUserCommand = new FilamentMakeUserCommand();
        $reflector = new \ReflectionObject($filamentMakeUserCommand);

        $getUserModel = $reflector->getMethod('getUserModel');
        $getUserModel->setAccessible(true);
        $superAdmin= $getUserModel->invoke($filamentMakeUserCommand)::create([
            'name' => 'Super Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $superAdmin->assignRole('Super Admin');
    }
}
