<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyIndeedWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Basic availability check; deep signature verification is done in controller
        if (!config('integrations.indeed.webhook_secret')) {
            return response('Webhook not configured', 503);
        }
        return $next($request);
    }
}
