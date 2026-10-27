<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('local', 'testing')) {
            User::firstOrCreate(
                ['email' => 'admin@citizenscharter.gov.ph'],
                [
                    'name' => 'Admin Officer',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            $this->call(SurveyResponseSeeder::class);

            return;
        }

        $adminEmail = config('services.admin_bootstrap.email');
        $adminPassword = config('services.admin_bootstrap.password');

        if (blank($adminEmail) && blank($adminPassword)) {
            return;
        }

        if (blank($adminEmail) || blank($adminPassword)) {
            throw new \InvalidArgumentException('Both ADMIN_BOOTSTRAP_EMAIL and ADMIN_BOOTSTRAP_PASSWORD must be set.');
        }

        User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin Officer',
                'password' => $adminPassword,
                'email_verified_at' => now(),
            ]
        );
    }
}
