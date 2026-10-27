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
        Schema::create('service_options', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->timestamps();
        });

        $timestamp = now();

        DB::table('service_options')->insert(array_map(
            fn (string $name): array => [
                'name' => $name,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'Application for Permits, Clearances, or Licenses',
                'Filing / Submission of Legal or Official Documents',
                'Issuance of Official Receipts / Payment Processing',
                'Request for Certified True Copies / Records Verification',
                'Inquiry, Consultation, or Technical Assistance',
                'Filing a Complaint or Public Feedback',
                'Other',
            ],
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_options');
    }
};
