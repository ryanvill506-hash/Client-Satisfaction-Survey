<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 32)->unique();

            // Client Demographic & Transaction Data
            $table->string('client_type', 30); // Citizen, Business, Government
            $table->date('transaction_date');
            $table->string('sex', 20); // Male, Female, Prefer not to say
            $table->string('age_group', 30); // 19 or below, 20-34, 35-49, 50-64, 65 and above
            $table->string('region', 100)->nullable();
            $table->string('office_transacted', 150);
            $table->string('service_availed', 150);
            $table->string('service_availed_other', 200)->nullable();

            // Citizen's Charter Questions (CC1, CC2, CC3)
            $table->unsignedTinyInteger('cc1'); // 1 to 4
            $table->unsignedTinyInteger('cc2')->nullable(); // 1 to 5 (or 0 for N/A)
            $table->unsignedTinyInteger('cc3')->nullable(); // 1 to 4 (or 0 for N/A)

            // Service Quality Dimensions (SQD0 - SQD8)
            // 5 = Strongly Agree, 4 = Agree, 3 = Neutral, 2 = Disagree, 1 = Strongly Disagree, null = N/A
            $table->unsignedTinyInteger('sqd0')->nullable(); // Overall Satisfaction
            $table->unsignedTinyInteger('sqd1')->nullable(); // Responsiveness
            $table->unsignedTinyInteger('sqd2')->nullable(); // Reliability
            $table->unsignedTinyInteger('sqd3')->nullable(); // Access & Facilities
            $table->unsignedTinyInteger('sqd4')->nullable(); // Communication
            $table->unsignedTinyInteger('sqd5')->nullable(); // Costs
            $table->unsignedTinyInteger('sqd6')->nullable(); // Integrity
            $table->unsignedTinyInteger('sqd7')->nullable(); // Assurance
            $table->unsignedTinyInteger('sqd8')->nullable(); // Outcome

            // Feedback & Suggestions
            $table->text('suggestions')->nullable();

            // Optional Client Info
            $table->string('respondent_name', 150)->nullable();
            $table->string('contact_number', 50)->nullable();
            $table->string('email', 150)->nullable();

            // Metadata
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Indexes for admin reporting
            $table->index('client_type');
            $table->index('transaction_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
