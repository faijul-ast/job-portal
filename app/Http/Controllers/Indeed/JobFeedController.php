<?php

namespace App\Http\Controllers\Indeed;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Services\indeed\IndeedFeedBuilder;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class JobFeedController extends Controller
{
    public function indeedXml(IndeedFeedBuilder $builder): Response
    {
        // Cache the feed for 5 minutes to reduce db load
        $xml = Cache::remember('feeds:indeed', now()->addMinutes(5), function () use ($builder) {
            $jobs = JobPosting::query()
                ->published()                // scope: status = published + validThrough >= today
                ->where('is_public', true)   // if you have visibility flags
                ->latest('updated_at')
                ->limit(5000)                // sane cap—Indeed doesn’t want infinite
                ->get();

            return $builder->build($jobs);
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function jobsSitemap(): Response
    {
        $items = Cache::remember('feeds:jobs_sitemap', now()->addMinutes(10), function () {
            return JobPosting::query()
                ->published()
                ->where('is_public', true)
                ->latest('updated_at')
                ->limit(10000)
                ->get(['id', 'slug', 'updated_at']);
        });

        $xml = view('feeds.jobs-sitemap', [ // you can render XML from a Blade or generate in code
            'items' => $items,
            'baseUrl' => config('app.url'),
            'now'     => Carbon::now()->toAtomString(),
        ])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
