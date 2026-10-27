<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_does_not_create_demo_data_in_production(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        (new DatabaseSeeder)->run();

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('survey_responses', 0);
    }

    public function test_database_seeder_bootstraps_only_an_explicit_admin_in_production(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');
        config([
            'services.admin_bootstrap.email' => 'admin@example.com',
            'services.admin_bootstrap.password' => 'a-strong-test-password',
        ]);

        (new DatabaseSeeder)->run();

        $this->assertDatabaseHas('users', ['email' => 'admin@example.com']);
        $this->assertDatabaseCount('survey_responses', 0);
        $this->assertTrue(Hash::check(
            'a-strong-test-password',
            (string) User::query()->where('email', 'admin@example.com')->value('password'),
        ));
    }
}
