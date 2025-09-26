<?php

namespace App\Jobs\Indeed;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyIndeedIndexing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $url,
        public string $action = 'URL_UPDATED'
    ) {}

    public function handle(): void
    {
        try {
            // Example: call Indeed API (replace with actual endpoint & auth)
            // Http::post('https://api.indeed.com/job-indexing', [
            //     'url' => $this->url,
            //     'action' => $this->action,
            // ]);

            Log::info("Indeed notified: {$this->url} with action {$this->action}");
        } catch (\Exception $e) {
            Log::error('Indeed indexing failed', [
                'url' => $this->url,
                'action' => $this->action,
                'error' => $e->getMessage(),
            ]);

            // Optionally rethrow to retry
            throw $e;
        }
    }
}
