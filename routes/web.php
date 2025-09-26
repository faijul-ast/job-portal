<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Google\JobsSchemaController;
use App\Http\Controllers\Google\IndexingWebhookController;
use App\Http\Controllers\Google\JobsSitemapController;

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
