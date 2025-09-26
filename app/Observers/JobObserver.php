<?php

namespace App\Observers;

use App\Jobs\Google\NotifyGoogleIndexing;
use App\Models\JobPosting;

class JobObserver
{
    public function created(JobPosting $job): void
    {
        if ($job->is_public && $job->status === 'published') {
            NotifyGoogleIndexing::dispatch($job->publicUrl(), 'URL_UPDATED')->onQueue('indexing');
        }
    }

    public function updated(JobPosting $job): void
    {
        // If page content or visibility changed
        if ($job->wasChanged(['title','description','valid_through','status','is_public'])) {
            NotifyGoogleIndexing::dispatch($job->publicUrl(), 'URL_UPDATED')->onQueue('indexing');
        }
    }

    public function deleted(JobPosting $job): void
    {
        NotifyGoogleIndexing::dispatch($job->publicUrl(), 'URL_DELETED')->onQueue('indexing');
    }
}
