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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->timestamps();
        });

        $timestamp = now();

        DB::table('offices')->insert(array_map(
            fn (string $name): array => [
                'name' => $name,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'Public Assistance and Complaints Desk (PACD)',
                'Frontline Counter / Receiving Section',
                'Records & Archives Division',
                'Licensing, Permits & Registration',
                'Treasury / Cashier Division',
                'Legal / Hearing Section',
                'Administrative & Human Resource Office',
                'Planning & Management Office',
                'Information & Technology Desk',
                'Other Service Window',
            ],
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
