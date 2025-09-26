<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Google\JobsSchemaController;
use App\Http\Controllers\Google\IndexingWebhookController;
use App\Http\Controllers\Google\JobsSitemapController;
use App\Http\Controllers\Indeed\JobFeedController;
use App\Http\Controllers\Indeed\JobWebhookController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [JobsSchemaController::class, 'index'])->name('job_postings.index');

Route::get('/job_postings/create', [JobsSchemaController::class, 'create'])->name('job_postings.create');
Route::post('/job_postings/store', [JobsSchemaController::class, 'store'])->name('job_postings.store');
Route::get('/job_postings/{slug}', [JobsSchemaController::class, 'show'])->name('job_postings.show');

Route::get('/feeds/jobs-sitemap.xml', [JobsSitemapController::class, 'sitemap'])->name('feeds.jobs_sitemap');

// (Optional internal endpoints to test Indexing API)
Route::post('/admin/indexing/ping', [IndexingWebhookController::class, 'ping'])->middleware('auth');

Route::middleware('throttle:60,1')->group(function () {
    // Public feed endpoints (fetchable by job boards)
    Route::get('/feeds/indeed.xml', [JobFeedController::class, 'indeedXml'])->name('feeds.indeed');
    Route::get('/feeds/jobs-sitemap.xml', [JobFeedController::class, 'jobsSitemap'])->name('feeds.jobs_sitemap');
});

// Webhooks (should be POST; protect with secret header or basic auth)
Route::post('/webhooks/indeed/apply', [JobWebhookController::class, 'indeedApply'])
    ->middleware(['indeed.webhook']) // custom middleware below
    ->name('webhooks.indeed.apply');
