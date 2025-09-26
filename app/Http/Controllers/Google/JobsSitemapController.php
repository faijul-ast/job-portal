<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use Illuminate\Http\Response;

class JobsSitemapController extends Controller
{
    public function sitemap(): Response
    {
        $jobs = JobPosting::published()->latest('updated_at')->limit(10000)->get(['slug','updated_at']);

        $xml = view('feeds.jobs-sitemap', [
            'items'   => $jobs,
            'baseUrl' => config('app.url'),
        ])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
