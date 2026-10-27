<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSurveyResponseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_type' => ['required', 'string', 'max:150', Rule::exists('client_types', 'name')],
            'transaction_date' => ['required', 'date', 'before_or_equal:today'],
            'sex' => ['required', 'string', 'in:Male,Female,Prefer not to say'],
            'age_group' => ['required', 'string', 'in:19 or below,20-34,35-49,50-64,65 and above'],
            'region' => ['nullable', 'string', 'max:100'],
            'office_transacted' => ['required', 'string', 'max:150', Rule::exists('offices', 'name')],
            'service_availed' => ['required', 'string', 'max:150', Rule::exists('service_options', 'name')],
            'service_availed_other' => ['nullable', 'string', 'max:200', 'required_if:service_availed,Other'],

            // CC Questions
            'cc1' => ['required', 'integer', 'between:1,4'],
            'cc2' => ['required_unless:cc1,4', 'integer', 'between:1,5'],
            'cc3' => ['required_unless:cc1,4', 'integer', 'between:1,4'],

            // Service Quality Dimensions
            'sqd0' => ['nullable', 'integer', 'between:1,5'],
            'sqd1' => ['nullable', 'integer', 'between:1,5'],
            'sqd2' => ['nullable', 'integer', 'between:1,5'],
            'sqd3' => ['nullable', 'integer', 'between:1,5'],
            'sqd4' => ['nullable', 'integer', 'between:1,5'],
            'sqd5' => ['nullable', 'integer', 'between:1,5'],
            'sqd6' => ['nullable', 'integer', 'between:1,5'],
            'sqd7' => ['nullable', 'integer', 'between:1,5'],
            'sqd8' => ['nullable', 'integer', 'between:1,5'],

            // Feedback & Details
            'suggestions' => ['nullable', 'string', 'max:2000'],
            'email' => ['nullable', 'email', 'max:150'],

            // Privacy consent
            'data_privacy_consent' => ['accepted'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'client_type.required' => 'Please select your client type (Citizen, Business, Student, or Government).',
            'transaction_date.required' => 'Please indicate your date of transaction.',
            'office_transacted.required' => 'Please specify the office or division you transacted with.',
            'service_availed.required' => 'Please choose the type of service availed.',
            'service_availed_other.required_if' => 'Please describe the other service availed.',
            'cc1.required' => 'Please answer Question CC1 regarding Citizen\'s Charter awareness.',
            'data_privacy_consent.accepted' => 'You must acknowledge the Data Privacy statement to submit the survey.',
        ];
    }
}
