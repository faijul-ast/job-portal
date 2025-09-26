<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TheirStack\TheirStackJobsController;
use App\Http\Controllers\TheirStack\TheirStackCompaniesController;

Route::prefix('theirstack')->group(function () {
    Route::get('/jobs', [TheirStackJobsController::class, 'index']);
    Route::get('/jobs/{jobId}', [TheirStackJobsController::class, 'getJobDetails']);

    Route::get('/companies/by-tech', [TheirStackCompaniesController::class, 'byTechnology']);

    // Optional: webhook receiver if you enable TheirStack webhooks later
    Route::post('/webhooks/jobs', function (\Illuminate\Http\Request $request) {
        // Verify signature if TheirStack provides one; store events.
        // Example event shape: { "type": "job.created", "data": { ... } }
        // return 2xx quickly; push to queue for processing.
        // Log::info('TheirStack webhook', $request->all());
        return response()->json(['received' => true]);
    });
});
