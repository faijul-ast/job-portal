<?php

namespace App\Services\Indeed;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use SimpleXMLElement;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;

class IndeedFeedBuilder
{
    /**
     * @param \Illuminate\Support\Collection<\App\Models\JobPosting> $jobs
     */
    public function build($jobs): string
    {
        // Indeed’s legacy XML format (commonly accepted). Adjust as per the program you’re onboarded into.
        // <source>...<job>...</job></source>
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><source/>');

        $xml->addChild('publisher', e(config('integrations.indeed.publisher_name')));
        $xml->addChild('publisherurl', e(config('app.url')));

        foreach ($jobs as $job) {
            $j = $xml->addChild('job');

            $this->addChildCdata($j, 'title', $job->title);
            $this->addChildCdata($j, 'date', $job->updated_at->toRfc2822String());

            // URL to your public job detail page
            $url = route('job_postings.show', ['slug' => $job->slug]); // define route in your app
            $this->addChildCdata($j, 'referencenumber', (string) $job->external_ref ?? (string) $job->id);
            $this->addChildCdata($j, 'url', $url);

            // Location breakdown if you have it
            $this->addChildCdata($j, 'company', $job->company_name);
            $this->addChildCdata($j, 'city', $job->city);
            $this->addChildCdata($j, 'state', $job->state);
            $this->addChildCdata($j, 'country', $job->country);
            $this->addChildCdata($j, 'postalcode', $job->postal_code);

            // Full description (strip unsafe html if needed)
            $desc = strip_tags($job->description, '<p><ul><ol><li><br><strong><em>');
            $this->addChildCdata($j, 'description', $desc);

            // Job type mapping
            $type = $this->mapEmploymentType($job->employment_type); // e.g. FULLTIME/PARTTIME/CONTRACT
            $this->addChildCdata($j, 'jobtype', $type);

            // Salary (if you have min/max, currency)
            if ($job->salary_min || $job->salary_max) {
                $this->addChildCdata($j, 'salary', $this->formatSalary($job));
            }

            // Expiry
            if ($job->valid_through) {
                $this->addChildCdata($j, 'expirationdate', Carbon::parse($job->valid_through)->toRfc2822String());
            }

            // Remote flag (Indeed sometimes uses tags or attributes)
            if ($job->is_remote) {
                $this->addChildCdata($j, 'remote', 'true');
            }
        }

        // Pretty-print
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    private function addChildCdata(SimpleXMLElement $parent, string $name, ?string $value): void
    {
        $child = $parent->addChild($name);
        if (!is_null($value)) {
            $node = dom_import_simplexml($child);
            $no   = $node->ownerDocument;
            $node->appendChild($no->createCDATASection($value));
        }
    }

    private function mapEmploymentType(?string $type): string
    {
        $map = config('integrations.mappings.employment_type');
        return $map[strtolower((string)$type)] ?? 'FULLTIME';
    }

    private function formatSalary($job): string
    {
        $currency = $job->salary_currency ?: 'USD';
        $min = $job->salary_min ? number_format($job->salary_min, 0) : null;
        $max = $job->salary_max ? number_format($job->salary_max, 0) : null;

        return match (true) {
            $min && $max => "{$currency} {$min}-{$max}",
            $min         => "{$currency} {$min}+",
            $max         => "{$currency} up to {$max}",
            default      => "{$currency}"
        };
    }
}
