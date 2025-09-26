<?php

namespace App\Http\Controllers\Indeed;

use App\Http\Controllers\Controller;
use App\Jobs\Indeed\ProcessIndeedApplicationJob;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class JobWebhookController extends Controller
{
    public function indeedApply(Request $request): Response
    {
        // Idempotency (dedupe replayed webhooks)
        $eventId = $request->header('X-Indeed-Event-Id') ?: Str::uuid()->toString();
        $signature = $request->header('X-Indeed-Signature', '');

        $payload = $request->getContent(); // raw JSON body
        $hashOk  = hash_equals(
            hash_hmac('sha256', $payload, config('integrations.indeed.webhook_secret')),
            $signature
        );

        if (!$hashOk) {
            return response('Invalid signature', 401);
        }

        $existing = WebhookEvent::query()->where('external_event_id', $eventId)->first();
        if ($existing) {
            // Already processed
            return response('OK', 200);
        }

        $event = WebhookEvent::create([
            'provider'          => 'indeed',
            'external_event_id' => $eventId,
            'payload'           => $payload,
            'status'            => 'queued',
        ]);

        ProcessIndeedApplicationJob::dispatch($event->id)->onQueue('webhooks');

        return response('Queued', 202);
    }
}
