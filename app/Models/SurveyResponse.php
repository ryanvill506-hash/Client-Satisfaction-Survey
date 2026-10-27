<?php

namespace App\Models;

use Database\Factories\SurveyResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    /** @use HasFactory<SurveyResponseFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reference_no',
        'client_type',
        'transaction_date',
        'sex',
        'age_group',
        'region',
        'office_transacted',
        'service_availed',
        'service_availed_other',
        'cc1',
        'cc2',
        'cc3',
        'sqd0',
        'sqd1',
        'sqd2',
        'sqd3',
        'sqd4',
        'sqd5',
        'sqd6',
        'sqd7',
        'sqd8',
        'suggestions',
        'respondent_name',
        'contact_number',
        'email',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'cc1' => 'integer',
            'cc2' => 'integer',
            'cc3' => 'integer',
            'sqd0' => 'integer',
            'sqd1' => 'integer',
            'sqd2' => 'integer',
            'sqd3' => 'integer',
            'sqd4' => 'integer',
            'sqd5' => 'integer',
            'sqd6' => 'integer',
            'sqd7' => 'integer',
            'sqd8' => 'integer',
        ];
    }

    public const CC1_DESCRIPTIONS = [
        1 => 'I know what a Citizen\'s Charter is and I saw this office\'s Citizen\'s Charter.',
        2 => 'I know what a Citizen\'s Charter is but I did NOT see this office\'s Citizen\'s Charter.',
        3 => 'I learned of the Citizen\'s Charter only when I saw this office\'s Citizen\'s Charter.',
        4 => 'I do not know what a Citizen\'s Charter is and I did not see one in this office.',
    ];

    public const CC2_DESCRIPTIONS = [
        1 => 'Easy to see',
        2 => 'Somewhat easy to see',
        3 => 'Difficult to see',
        4 => 'Not visible at all',
        5 => 'N/A (Not Applicable)',
    ];

    public const CC3_DESCRIPTIONS = [
        1 => 'Helped very much',
        2 => 'Somewhat helped',
        3 => 'Did not help',
        4 => 'N/A (Not Applicable)',
    ];

    public const SQD_QUESTIONS = [
        'sqd0' => [
            'title' => 'Overall Satisfaction',
            'statement' => 'I am satisfied with the service that I availed.',
        ],
        'sqd1' => [
            'title' => 'Responsiveness',
            'statement' => 'I spent a reasonable amount of time for my transaction.',
        ],
        'sqd2' => [
            'title' => 'Reliability',
            'statement' => 'The office followed the transaction\'s requirements and steps based on the information provided.',
        ],
        'sqd3' => [
            'title' => 'Access & Facilities',
            'statement' => 'The steps (including payment) I needed to take for my transaction were easy and convenient.',
        ],
        'sqd4' => [
            'title' => 'Communication',
            'statement' => 'I easily found information about my transaction from the office or its website.',
        ],
        'sqd5' => [
            'title' => 'Costs',
            'statement' => 'I paid an acceptable amount of fees for my transaction (no unauthorized fees).',
        ],
        'sqd6' => [
            'title' => 'Integrity',
            'statement' => 'I felt the office was fair and treated everyone equally.',
        ],
        'sqd7' => [
            'title' => 'Assurance',
            'statement' => 'I was treated courteously by the staff, and (if applicable) received help from the staff/guard.',
        ],
        'sqd8' => [
            'title' => 'Outcome',
            'statement' => 'I got what I needed from the government office, or (if denied) denial was sufficiently explained.',
        ],
    ];

    public const RATING_LABELS = [
        1 => 'Strongly Disagree',
        2 => 'Disagree',
        3 => 'Neither Agree nor Disagree',
        4 => 'Agree',
        5 => 'Strongly Agree',
    ];

    /**
     * Generate a unique survey reference number.
     */
    public static function generateReferenceNo(): string
    {
        do {
            $datePart = now()->format('Ymd');
            $randomPart = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            $reference = "CSM-{$datePart}-{$randomPart}";
        } while (self::where('reference_no', $reference)->exists());

        return $reference;
    }

    /**
     * Calculate average SQD score for this response.
     */
    public function getAverageSqdScoreAttribute(): ?float
    {
        $scores = array_filter([
            $this->sqd0,
            $this->sqd1,
            $this->sqd2,
            $this->sqd3,
            $this->sqd4,
            $this->sqd5,
            $this->sqd6,
            $this->sqd7,
            $this->sqd8,
        ], fn ($val) => ! is_null($val) && $val > 0);

        if (empty($scores)) {
            return null;
        }

        return round(array_sum($scores) / count($scores), 2);
    }

    /**
     * Determine if respondent is aware of Citizen's Charter.
     */
    public function getIsCharterAwareAttribute(): bool
    {
        return in_array($this->cc1, [1, 2, 3], true);
    }

    /**
     * Mask the IP address for admin display to protect privacy.
     */
    public function getMaskedIpAddressAttribute(): string
    {
        if (empty($this->ip_address)) {
            return 'Unknown';
        }

        if (filter_var($this->ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $this->ip_address);

            if (count($parts) === 4) {
                return $parts[0].'.'.$parts[1].'.***.***';
            }
        }

        if (filter_var($this->ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return 'IPv6 masked';
        }

        return 'Hidden';
    }
}
