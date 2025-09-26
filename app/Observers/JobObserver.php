<?php

namespace App\Observers;

use App\Jobs\Google\NotifyGoogleIndexing;
use App\Jobs\Indeed\NotifyIndeedIndexing;
use App\Models\JobPosting;

class JobObserver
{
    public function created(JobPosting $job): void
    {
        if ($job->is_public && $job->status === 'published') {
            // Notify Google
            NotifyGoogleIndexing::dispatch($job->publicUrl(), 'URL_UPDATED')->onQueue('indexing');

            // Notify Indeed
            NotifyIndeedIndexing::dispatch($job->publicUrl(), 'URL_UPDATED')->onQueue('indexing');
        }
    }

    public function updated(JobPosting $job): void
    {
        if ($job->wasChanged(['title','description','valid_through','status','is_public'])) {
            // Notify Google
            NotifyGoogleIndexing::dispatch($job->publicUrl(), 'URL_UPDATED')->onQueue('indexing');

            // Notify Indeed
            NotifyIndeedIndexing::dispatch($job->publicUrl(), 'URL_UPDATED')->onQueue('indexing');
        }
    }

    public function deleted(JobPosting $job): void
    {
        // Notify Google
        NotifyGoogleIndexing::dispatch($job->publicUrl(), 'URL_DELETED')->onQueue('indexing');

        // Notify Indeed
        NotifyIndeedIndexing::dispatch($job->publicUrl(), 'URL_DELETED')->onQueue('indexing');
    }
}
