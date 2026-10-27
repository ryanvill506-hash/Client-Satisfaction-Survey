<?php

namespace Tests\Feature;

use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test hardening headers are present on public pages.
     */
    public function test_public_pages_include_security_headers(): void
    {
        $this->get(route('survey.create'))
            ->assertStatus(200)
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Test that the survey form renders with instructions.
     */
    public function test_survey_form_can_be_rendered_with_instructions(): void
    {
        $response = $this->get(route('survey.create'));

        $response->assertStatus(200);
        $response->assertSee('Survey Instructions');
        $response->assertSee("Citizen's Charter", false);
        $response->assertSee('Service Quality Dimensions');
        $response->assertSee('Data Privacy Assurance');
        $response->assertSee('<select id="office_transacted" name="office_transacted"', false);
        $response->assertSee('Public Assistance and Complaints Desk (PACD)');
        $response->assertDontSee('Full Name');
        $response->assertDontSee('Contact Number');
    }

    /**
     * Test validation rules for required survey fields.
     */
    public function test_survey_requires_mandatory_fields(): void
    {
        $response = $this->post(route('survey.store'), []);

        $response->assertSessionHasErrors([
            'client_type',
            'transaction_date',
            'sex',
            'age_group',
            'office_transacted',
            'service_availed',
            'cc1',
            'data_privacy_consent',
        ]);
    }

    /**
     * Test that Student is accepted as a valid client type.
     */
    public function test_student_client_type_is_accepted(): void
    {
        $payload = [
            'client_type' => 'Student',
            'transaction_date' => now()->format('Y-m-d'),
            'sex' => 'Female',
            'age_group' => '20-34',
            'region' => 'NCR - National Capital Region',
            'office_transacted' => 'Frontline Counter / Receiving Section',
            'service_availed' => 'Inquiry, Consultation, or Technical Assistance',
            'cc1' => 1,
            'cc2' => 1,
            'cc3' => 1,
            'sqd0' => 5,
            'sqd1' => 4,
            'sqd2' => 4,
            'sqd3' => 5,
            'sqd4' => 5,
            'sqd5' => 4,
            'sqd6' => 5,
            'sqd7' => 5,
            'sqd8' => 5,
            'suggestions' => 'Helpful and clear service.',
            'respondent_name' => 'Student Visitor',
            'contact_number' => '09170000000',
            'email' => 'student@example.com',
            'data_privacy_consent' => '1',
        ];

        $response = $this->post(route('survey.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('survey_responses', [
            'client_type' => 'Student',
            'respondent_name' => null,
            'contact_number' => null,
        ]);
    }

    /**
     * Test that office names must match an available managed office.
     */
    public function test_office_name_must_be_selected_from_available_options(): void
    {
        $validPayload = [
            'client_type' => 'Citizen',
            'transaction_date' => now()->format('Y-m-d'),
            'sex' => 'Female',
            'age_group' => '20-34',
            'region' => 'NCR - National Capital Region',
            'office_transacted' => 'Frontline Counter / Receiving Section',
            'service_availed' => 'Inquiry, Consultation, or Technical Assistance',
            'cc1' => 1,
            'cc2' => 1,
            'cc3' => 1,
            'sqd0' => 5,
            'sqd1' => 4,
            'sqd2' => 4,
            'sqd3' => 5,
            'sqd4' => 5,
            'sqd5' => 4,
            'sqd6' => 5,
            'sqd7' => 5,
            'sqd8' => 5,
            'suggestions' => 'Helpful and clear service.',
            'respondent_name' => 'Office User',
            'contact_number' => '09170000000',
            'email' => 'office@example.com',
            'data_privacy_consent' => '1',
        ];

        $validResponse = $this->post(route('survey.store'), $validPayload);
        $validResponse->assertRedirect();

        $invalidResponse = $this->post(route('survey.store'), array_merge($validPayload, ['office_transacted' => 'Office of the Registrar']));
        $invalidResponse->assertSessionHasErrors('office_transacted');

        $notApplicableRatingsResponse = $this->post(route('survey.store'), array_merge($validPayload, [
            'cc2' => 5,
            'cc3' => 4,
            'sqd0' => '',
        ]));
        $notApplicableRatingsResponse->assertRedirect();
        $this->assertDatabaseHas('survey_responses', [
            'cc2' => 5,
            'cc3' => 4,
            'sqd0' => null,
        ]);
    }

    /**
     * Test that respondents unaware of the Citizen's Charter are forced into N/A values.
     */
    public function test_cc1_four_forces_na_values_for_cc2_and_cc3(): void
    {
        $payload = [
            'client_type' => 'Citizen',
            'transaction_date' => now()->format('Y-m-d'),
            'sex' => 'Female',
            'age_group' => '20-34',
            'region' => 'NCR - National Capital Region',
            'office_transacted' => 'Frontline Counter / Receiving Section',
            'service_availed' => 'Inquiry, Consultation, or Technical Assistance',
            'cc1' => 4,
            'sqd0' => 5,
            'sqd1' => 5,
            'sqd2' => 4,
            'sqd3' => 4,
            'sqd4' => 5,
            'sqd5' => 4,
            'sqd6' => 5,
            'sqd7' => 5,
            'sqd8' => 4,
            'data_privacy_consent' => '1',
        ];

        $this->post(route('survey.store'), $payload)->assertRedirect();

        $this->assertDatabaseHas('survey_responses', ['cc1' => 4, 'cc2' => 5, 'cc3' => 4]);
    }

    /**
     * Test filtering and exports respect the current admin search and date criteria.
     */
    public function test_admin_export_respects_filters(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@citizenscharter.gov.ph',
            'password' => bcrypt('password'),
        ]);

        SurveyResponse::factory()->create([
            'client_type' => 'Citizen',
            'respondent_name' => 'Alice Respondent',
            'contact_number' => '09170000001',
            'office_transacted' => 'Frontline Counter / Receiving Section',
            'transaction_date' => '2026-10-05',
        ]);
        SurveyResponse::factory()->create([
            'client_type' => 'Business',
            'respondent_name' => 'Bob Respondent',
            'contact_number' => '09170000002',
            'office_transacted' => 'Treasury / Cashier Division',
            'transaction_date' => '2026-10-06',
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.surveys.export', ['client_type' => 'Citizen', 'date_from' => '2026-10-05', 'date_to' => '2026-10-05']));

        $response->assertStatus(200);
        $csv = $response->streamedContent();
        $this->assertStringContainsString('Frontline Counter / Receiving Section', $csv);
        $this->assertStringNotContainsString('Treasury / Cashier Division', $csv);
        $this->assertStringNotContainsString('Alice Respondent', $csv);
        $this->assertStringNotContainsString('Bob Respondent', $csv);
        $this->assertStringNotContainsString('09170000001', $csv);
        $this->assertStringNotContainsString('09170000002', $csv);
    }

    /**
     * Test valid survey submission saves to database and shows confirmation.
     */
    public function test_survey_submission_succeeds_and_saves_to_database(): void
    {
        $payload = [
            'client_type' => 'Citizen',
            'transaction_date' => now()->format('Y-m-d'),
            'sex' => 'Female',
            'age_group' => '20-34',
            'region' => 'NCR - National Capital Region',
            'office_transacted' => 'Frontline Counter / Receiving Section',
            'service_availed' => 'Application for Permits, Clearances, or Licenses',
            'cc1' => 1,
            'cc2' => 1,
            'cc3' => 1,
            'sqd0' => 5,
            'sqd1' => 5,
            'sqd2' => 4,
            'sqd3' => 5,
            'sqd4' => 4,
            'sqd5' => 5,
            'sqd6' => 5,
            'sqd7' => 5,
            'sqd8' => 5,
            'suggestions' => 'Excellent and fast service! Thank you.',
            'respondent_name' => 'Maria Clara',
            'contact_number' => '09171234567',
            'email' => 'maria@example.com',
            'data_privacy_consent' => '1',
        ];

        $response = $this->post(route('survey.store'), $payload);

        $record = SurveyResponse::where('suggestions', 'Excellent and fast service! Thank you.')->first();
        $this->assertNotNull($record);
        $this->assertStringStartsWith('CSM-', $record->reference_no);
        $this->assertEquals(5, $record->sqd0);
        $this->assertNull($record->respondent_name);
        $this->assertNull($record->contact_number);

        $response->assertRedirect(route('survey.success', ['reference' => $record->reference_no]));

        // Follow redirect to confirmation page
        $successResponse = $this->get(route('survey.success', ['reference' => $record->reference_no]));
        $successResponse->assertStatus(200);
        $successResponse->assertSee($record->reference_no);
        $successResponse->assertSee('Maraming Salamat!');
    }

    /**
     * Test admin dashboard displays metrics and survey entries.
     */
    public function test_admin_dashboard_displays_metrics_and_surveys(): void
    {
        $surveys = SurveyResponse::factory()->count(5)->create();
        $user = User::factory()->create([
            'email' => 'admin@citizenscharter.gov.ph',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.surveys.index'));

        $response->assertStatus(200);
        $response->assertSee('Survey Analytics');
        $response->assertSee('Total Responses');
        $response->assertDontSee('View All Responses');
        $response->assertSee($surveys->first()->reference_no);
        $response->assertSee('Delete');
        $response->assertSee(route('admin.surveys.destroy', $surveys->first()), false);
    }

    public function test_admin_dashboard_shows_delete_action_for_recent_responses(): void
    {
        $survey = SurveyResponse::factory()->create([
            'respondent_name' => 'Existing Respondent',
            'contact_number' => '09179999999',
        ]);
        $user = User::factory()->create([
            'email' => 'admin@citizenscharter.gov.ph',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertSee($survey->reference_no);
        $response->assertSee('Delete');
        $response->assertSee(route('admin.surveys.destroy', $survey), false);
        $response->assertDontSee('Existing Respondent');
        $response->assertDontSee('09179999999');
    }

    /**
     * Test admin detail view for a specific response.
     */
    public function test_admin_can_view_single_survey_detail(): void
    {
        $survey = SurveyResponse::factory()->create([
            'respondent_name' => 'Test Respondent',
            'contact_number' => '09178888888',
            'suggestions' => 'Very polite guards and clean facilities.',
            'ip_address' => '192.168.1.25',
        ]);
        $user = User::factory()->create([
            'email' => 'admin@citizenscharter.gov.ph',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.surveys.show', $survey));

        $response->assertStatus(200);
        $response->assertSee($survey->reference_no);
        $response->assertSee('Very polite guards and clean facilities.');
        $response->assertSee('192.168.***.***');
        $response->assertDontSee('192.168.1.25');
        $response->assertDontSee('Test Respondent');
        $response->assertDontSee('09178888888');

        $printResponse = $this->get(route('survey.print', $survey->reference_no));
        $printResponse->assertDontSee('Test Respondent');
        $printResponse->assertDontSee('09178888888');
    }

    /**
     * Test that an authenticated admin can delete a survey response.
     */
    public function test_admin_can_delete_a_survey_response(): void
    {
        $survey = SurveyResponse::factory()->create();
        $user = User::factory()->create([
            'email' => 'admin@citizenscharter.gov.ph',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)
            ->delete(route('admin.surveys.destroy', $survey));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('status', 'Survey response deleted successfully.');
        $this->assertDatabaseMissing('survey_responses', ['id' => $survey->id]);
    }

    /**
     * Test that deleting a survey response requires admin authentication.
     */
    public function test_guest_cannot_delete_a_survey_response(): void
    {
        $survey = SurveyResponse::factory()->create();

        $response = $this->delete(route('admin.surveys.destroy', $survey));

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseHas('survey_responses', ['id' => $survey->id]);
    }

    /**
     * Test exporting survey responses to CSV.
     */
    public function test_admin_can_export_csv(): void
    {
        SurveyResponse::factory()->count(3)->create();
        $user = User::factory()->create([
            'email' => 'admin@citizenscharter.gov.ph',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.surveys.export'));

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'text/csv'));
        $this->assertTrue(str_contains($response->headers->get('content-disposition'), 'Citizen_Charter_Surveys_'));
    }
}
