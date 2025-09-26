<?php

namespace App\Services\Google;

use App\Models\JobPosting;

class GoogleForJobsSchemaService
{
    public function make(JobPosting $job): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $job->title,
            'description' => strip_tags($job->description, '<p><ul><ol><li><br><strong><em>'),
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name'  => $job->company_name,
                'sameAs'=> config('app.url'),
            ],
            'datePosted'   => optional($job->created_at)->toIso8601String(),
            'validThrough' => optional($job->valid_through)->toIso8601String(),
            'employmentType' => $this->mapEmploymentType($job->employment_type),
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress'   => $job->street ?? '',
                    'addressLocality' => $job->city ?? '',
                    'addressRegion'   => $job->state ?? '',
                    'postalCode'      => $job->postal_code ?? '',
                    'addressCountry'  => $job->country ?? '',
                ],
            ],
            'applicantLocationRequirements' => $job->is_remote ? [
                '@type' => 'Country', 'name' => $job->country ?: 'Remote',
            ] : null,
            'baseSalary' => ($job->salary_min || $job->salary_max) ? [
                '@type'    => 'MonetaryAmount',
                'currency' => $job->salary_currency ?: 'USD',
                'value'    => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => $job->salary_min,
                    'maxValue' => $job->salary_max,
                    'unitText' => $job->salary_period ?: 'YEAR',
                ],
            ] : null,
            'directApply' => true,
            'employmentUnit' => $job->publicUrl(), // not required; helpful for clarity
        ];
    }

    private function mapEmploymentType(?string $type): string
    {
        return match (strtolower((string)$type)) {
            'part_time' => 'PART_TIME',
            'contract'  => 'CONTRACTOR',
            'intern'    => 'INTERN',
            'temporary' => 'TEMPORARY',
            default     => 'FULL_TIME',
        };
    }
}
