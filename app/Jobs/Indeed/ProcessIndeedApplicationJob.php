<?php

namespace App\Jobs\Indeed;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\WebhookEvent;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Google\Client;
use Google\Service\Indexing;

class ProcessIndeedApplicationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $webhookEventId) {}

    public function middleware(): array
    {
        return [new RateLimited('indeed-webhooks')]; // use Redis rate limiter
    }

    public function handle(): void
    {
        /** @var WebhookEvent $evt */
        $evt = WebhookEvent::findOrFail($this->webhookEventId);

        $payload = json_decode($evt->payload, true, 512, JSON_THROW_ON_ERROR);

        // Example expected payload (adjust to actual Indeed Apply schema you receive)
        // {
        //   "job_reference": "EXT-123",
        //   "candidate": { "email": "...", "name": "...", "phone": "...", "resume_url": "..." }
        // }

        DB::transaction(function () use ($evt, $payload) {
            $job = JobPosting::query()
                ->where('external_ref', $payload['job_reference'] ?? null)
                ->orWhere('id', $payload['job_id'] ?? null)
                ->lockForUpdate()
                ->first();

            if (!$job) {
                throw new \RuntimeException('Job not found for webhook.');
            }

            // Idempotent by (provider,event_id) unique key on applications or a separate dedupe table
            $app = Application::firstOrCreate(
                [
                    'job_id'     => $job->id,
                    'source'     => 'indeed',
                    'source_app_id' => $payload['application_id'] ?? $evt->external_event_id,
                ],
                [
                    'candidate_email' => $payload['candidate']['email'] ?? null,
                    'candidate_name'  => $payload['candidate']['name'] ?? null,
                    'candidate_phone' => $payload['candidate']['phone'] ?? null,
                    'resume_url'      => $payload['candidate']['resume_url'] ?? null,
                    'raw_payload'     => $payload,
                    'status'          => 'new',
                ]
            );

            $evt->update(['status' => 'processed']);
        });

        Log::info('Indeed application processed', ['webhook_event_id' => $evt->id]);
    }
}
