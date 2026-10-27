<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_types', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150)->unique();
            $table->string('description', 200);
            $table->timestamps();
        });

        $timestamp = now();

        DB::table('client_types')->insert(array_map(
            fn (string $name, string $description): array => [
                'name' => $name,
                'description' => $description,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'Citizen',
                'Business',
                'Student',
                'Government (Employee / Agency)',
            ],
            [
                'Citizen (General Public / Individual)',
                'Business (Enterprise / Corporation / MSME)',
                'Student (Learner / Scholar / Trainee)',
                'Government (Employee or other Agency)',
            ],
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_types');
    }
};
