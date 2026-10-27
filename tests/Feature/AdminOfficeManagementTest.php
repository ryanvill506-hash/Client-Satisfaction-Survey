<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\ClientType;
use App\Models\ServiceOption;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOfficeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_or_add_offices(): void
    {
        $this->get(route('admin.offices.index'))
            ->assertRedirect(route('admin.login'));

        $this->post(route('admin.offices.store'), [
            'name' => 'Guest Added Office',
        ])->assertRedirect(route('admin.login'));

        $this->post(route('admin.service-options.store'), [
            'name' => 'Guest Added Service',
        ])->assertRedirect(route('admin.login'));

        $this->post(route('admin.client-types.store'), [
            'name' => 'Guest Added Client Type',
            '_form' => 'client_type',
        ])->assertRedirect(route('admin.login'));

        $this->assertDatabaseMissing('offices', ['name' => 'Guest Added Office']);
        $this->assertDatabaseMissing('service_options', ['name' => 'Guest Added Service']);
        $this->assertDatabaseMissing('client_types', ['name' => 'Guest Added Client Type']);
    }

    public function test_guest_cannot_delete_an_office(): void
    {
        $office = Office::query()->firstOrFail();

        $this->delete(route('admin.offices.destroy', $office))
            ->assertRedirect(route('admin.login'));

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => $office->name,
        ]);
    }

    public function test_guest_cannot_delete_a_service(): void
    {
        $serviceOption = ServiceOption::query()->firstOrFail();

        $this->delete(route('admin.service-options.destroy', $serviceOption))
            ->assertRedirect(route('admin.login'));

        $this->assertDatabaseHas('service_options', [
            'id' => $serviceOption->id,
            'name' => $serviceOption->name,
        ]);
    }

    public function test_guest_cannot_delete_a_client_type(): void
    {
        $clientType = ClientType::query()->firstOrFail();

        $this->delete(route('admin.client-types.destroy', $clientType))
            ->assertRedirect(route('admin.login'));

        $this->assertDatabaseHas('client_types', [
            'id' => $clientType->id,
            'name' => $clientType->name,
        ]);
    }

    public function test_admin_can_delete_an_office_and_preserve_existing_responses(): void
    {
        $user = User::factory()->create();
        $office = Office::create(['name' => 'Temporary Service Office']);
        $response = SurveyResponse::factory()->create([
            'office_transacted' => $office->name,
        ]);

        $this->actingAs($user)
            ->delete(route('admin.offices.destroy', $office))
            ->assertRedirect(route('admin.offices.index'))
            ->assertSessionHas('status', 'Office deleted successfully.');

        $this->assertDatabaseMissing('offices', ['id' => $office->id]);
        $this->assertDatabaseHas('survey_responses', [
            'id' => $response->id,
            'office_transacted' => 'Temporary Service Office',
        ]);
    }

    public function test_admin_can_add_an_office_and_it_appears_on_the_survey(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.offices.index'))
            ->assertSee('Manage Offices')
            ->assertSee('Survey office options')
            ->assertSee('Add Office')
            ->assertSee('Manage Services Availed')
            ->assertSee('Add Service')
            ->assertSee('Manage Client Types')
            ->assertSee('Add Client Type')
            ->assertDontSee('Save Name')
            ->assertSee('changes save when you leave the field')
            ->assertSee('Open admin navigation')
            ->assertSee('id="admin-navigation"', false)
            ->assertSee('aria-hidden="true"', false)
            ->assertSee('Dashboard')
            ->assertSee('Responses')
            ->assertSee('Offices');

        $this->actingAs($user)
            ->post(route('admin.offices.store'), [
                'name' => 'Student Records Office',
            ])
            ->assertRedirect(route('admin.offices.index'))
            ->assertSessionHas('status', 'Office added successfully.');

        $this->assertDatabaseHas('offices', ['name' => 'Student Records Office']);

        $this->get(route('survey.create'))
            ->assertSee('Student Records Office');
    }

    public function test_admin_can_add_and_delete_client_types_and_preserve_existing_responses(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.client-types.store'), [
                'name' => 'International Visitor',
                '_form' => 'client_type',
            ])
            ->assertRedirect(route('admin.offices.index'))
            ->assertSessionHas('status', 'Client type added successfully.');

        $clientType = ClientType::query()->where('name', 'International Visitor')->firstOrFail();

        $this->get(route('survey.create'))
            ->assertSee('International Visitor');

        $this->post(route('survey.store'), [
            'client_type' => 'International Visitor',
            'transaction_date' => now()->format('Y-m-d'),
            'sex' => 'Female',
            'age_group' => '20-34',
            'office_transacted' => 'Frontline Counter / Receiving Section',
            'service_availed' => 'Inquiry, Consultation, or Technical Assistance',
            'cc1' => 1,
            'cc2' => 1,
            'cc3' => 1,
            'data_privacy_consent' => '1',
        ])->assertRedirect();

        $response = SurveyResponse::query()
            ->where('client_type', 'International Visitor')
            ->firstOrFail();

        $this->delete(route('admin.client-types.destroy', $clientType))
            ->assertRedirect(route('admin.offices.index'))
            ->assertSessionHas('status', 'Client type deleted successfully.');

        $this->assertDatabaseMissing('client_types', ['id' => $clientType->id]);
        $this->assertDatabaseHas('survey_responses', [
            'id' => $response->id,
            'client_type' => 'International Visitor',
        ]);

        $this->get(route('survey.create'))
            ->assertDontSee('International Visitor');

        $this->get(route('admin.dashboard'))
            ->assertSee('International Visitor');
    }

    public function test_admin_cannot_add_a_duplicate_client_type(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.client-types.store'), [
                'name' => 'Citizen',
                '_form' => 'client_type',
            ])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('client_types', 4);
    }

    public function test_admin_can_add_and_delete_services_while_preserving_survey_responses(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.service-options.store'), [
                'name' => 'Transcript Evaluation',
                '_form' => 'service',
            ])
            ->assertRedirect(route('admin.offices.index'))
            ->assertSessionHas('status', 'Service added successfully.');

        $serviceOption = ServiceOption::query()->where('name', 'Transcript Evaluation')->firstOrFail();

        $this->get(route('survey.create'))
            ->assertSee('Transcript Evaluation');

        $this->post(route('survey.store'), [
            'client_type' => 'Citizen',
            'transaction_date' => now()->format('Y-m-d'),
            'sex' => 'Female',
            'age_group' => '20-34',
            'office_transacted' => 'Frontline Counter / Receiving Section',
            'service_availed' => 'Transcript Evaluation',
            'cc1' => 1,
            'cc2' => 1,
            'cc3' => 1,
            'data_privacy_consent' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('survey_responses', [
            'service_availed' => 'Transcript Evaluation',
        ]);

        $response = SurveyResponse::factory()->create([
            'service_availed' => $serviceOption->name,
        ]);

        $this->delete(route('admin.service-options.destroy', $serviceOption))
            ->assertRedirect(route('admin.offices.index'))
            ->assertSessionHas('status', 'Service deleted successfully.');

        $this->assertDatabaseMissing('service_options', ['id' => $serviceOption->id]);
        $this->assertDatabaseHas('survey_responses', [
            'id' => $response->id,
            'service_availed' => 'Transcript Evaluation',
        ]);

        $this->get(route('survey.create'))
            ->assertDontSee('Transcript Evaluation');
    }

    public function test_admin_cannot_add_a_duplicate_service(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.service-options.store'), [
                'name' => 'Filing / Submission of Legal or Official Documents',
            ])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('service_options', 7);
    }

    public function test_admin_can_edit_office_without_changing_historical_survey_data(): void
    {
        $user = User::factory()->create();
        $office = Office::create(['name' => 'Continuing Education Desk']);
        $response = SurveyResponse::factory()->create([
            'office_transacted' => $office->name,
        ]);

        $this->actingAs($user)
            ->put(route('admin.offices.update', $office), [
                'name' => 'Continuing Education Office',
            ])
            ->assertRedirect(route('admin.offices.index'))
            ->assertSessionHas('status', 'Office updated successfully.');

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => 'Continuing Education Office',
        ]);
        $this->assertDatabaseHas('survey_responses', [
            'id' => $response->id,
            'office_transacted' => 'Continuing Education Desk',
        ]);

        $this->get(route('survey.create'))
            ->assertSee('Continuing Education Office')
            ->assertDontSee('Continuing Education Desk');
    }

    public function test_admin_cannot_add_a_duplicate_office_name(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.offices.store'), [
                'name' => 'Records & Archives Division',
            ])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('offices', 10);
    }

    public function test_survey_submission_accepts_a_managed_office(): void
    {
        Office::create(['name' => 'New Service Office']);

        $this->post(route('survey.store'), [
            'client_type' => 'Citizen',
            'transaction_date' => now()->format('Y-m-d'),
            'sex' => 'Female',
            'age_group' => '20-34',
            'office_transacted' => 'New Service Office',
            'service_availed' => 'Inquiry, Consultation, or Technical Assistance',
            'cc1' => 1,
            'cc2' => 1,
            'cc3' => 1,
            'data_privacy_consent' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('survey_responses', [
            'office_transacted' => 'New Service Office',
        ]);
    }
}
