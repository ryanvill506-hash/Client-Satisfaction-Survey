<?php

namespace Database\Factories;

use App\Models\SurveyResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SurveyResponse>
 */
class SurveyResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientTypes = ['Citizen', 'Business', 'Student', 'Government (Employee / Agency)'];
        $sexes = ['Male', 'Female', 'Prefer not to say'];
        $ageGroups = ['19 or below', '20-34', '35-49', '50-64', '65 and above'];
        $regions = [
            'NCR - National Capital Region',
            'Region III - Central Luzon',
            'Region IV-A - CALABARZON',
            'Region VII - Central Visayas',
            'Region XI - Davao Region',
        ];
        $offices = [
            'Public Assistance and Complaints Desk (PACD)',
            'Frontline Counter / Receiving Section',
            'Records & Archives Division',
            'Licensing, Permits & Registration',
            'Treasury / Cashier Division',
            'Information & Technology Desk',
        ];
        $services = [
            'Application for Permits, Clearances, or Licenses',
            'Filing / Submission of Legal or Official Documents',
            'Issuance of Official Receipts / Payment Processing',
            'Request for Certified True Copies / Records Verification',
            'Inquiry, Consultation, or Technical Assistance',
        ];

        $cc1 = fake()->randomElement([1, 1, 1, 2, 3, 4]); // mostly aware
        $isAware = in_array($cc1, [1, 2, 3]);

        $cc2 = $isAware ? fake()->numberBetween(1, 4) : 5;
        $cc3 = $isAware ? fake()->numberBetween(1, 3) : 4;

        // Realistic public survey distribution: mostly 4 and 5
        $sqdScore = fn () => fake()->randomElement([3, 4, 4, 5, 5, 5]);

        $feedbackSamples = [
            'The staff was very approachable and helpful in explaining the process.',
            'Transactions are fast and efficient. Keep up the good work!',
            'Please consider adding more seating in the waiting area during peak hours.',
            'The digital signage and Citizen\'s Charter billboard were clear and very easy to follow.',
            'Air conditioning in the lobby could be improved, but service was top notch.',
            'Very smooth transaction, received my permit earlier than scheduled processing time.',
            'Great experience with the receiving officer today. Very polite and respectful.',
            null,
            null,
        ];

        return [
            'reference_no' => SurveyResponse::generateReferenceNo(),
            'client_type' => fake()->randomElement($clientTypes),
            'transaction_date' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'sex' => fake()->randomElement($sexes),
            'age_group' => fake()->randomElement($ageGroups),
            'region' => fake()->randomElement($regions),
            'office_transacted' => fake()->randomElement($offices),
            'service_availed' => fake()->randomElement($services),
            'service_availed_other' => null,
            'cc1' => $cc1,
            'cc2' => $cc2,
            'cc3' => $cc3,
            'sqd0' => $sqdScore(),
            'sqd1' => $sqdScore(),
            'sqd2' => $sqdScore(),
            'sqd3' => $sqdScore(),
            'sqd4' => $sqdScore(),
            'sqd5' => $sqdScore(),
            'sqd6' => $sqdScore(),
            'sqd7' => $sqdScore(),
            'sqd8' => $sqdScore(),
            'suggestions' => fake()->randomElement($feedbackSamples),
            'respondent_name' => fake()->boolean(60) ? fake()->name() : null,
            'contact_number' => fake()->boolean(50) ? fake()->phoneNumber() : null,
            'email' => fake()->boolean(40) ? fake()->safeEmail() : null,
            'ip_address' => fake()->ipv4(),
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
        ];
    }
}
