<?php

namespace App\Http\Controllers\TheirStack;

use App\Http\Controllers\Controller;
use App\Services\TheirStack\TheirStackClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TheirStackJobsController extends Controller
{
    public function __construct(private TheirStackClient $client) {}

    public function index(Request $request)
    {
        $data = $request->validate([
            'q'             => ['sometimes','string','max:200'],
            'company'       => ['sometimes','string','max:200'],
            'company_domain'=> ['sometimes','string','max:200'],
            'country'       => ['sometimes','string','size:2'],
            'title'         => ['sometimes','string','max:200'],
            'tech'          => ['sometimes','string','max:200'],
            'posted_from'   => ['sometimes','date'],
            'posted_to'     => ['sometimes','date'],
            'sort'          => ['sometimes', Rule::in(['relevance','date'])],
            'page'          => ['sometimes','integer','min:1'],
            'per_page'      => ['sometimes','integer','min:1','max:500'],
        ]);

        $jobs = $this->client->searchJobs($data);

        return response()->json([
            'status' => 'ok',
            'filters' => $data,
            'data'   => $jobs['data'],
            'meta'   => $jobs['meta'],
        ]);
    }

    /**
     * Fetch a single job by ID
     */
    public function getJobDetails(string $jobId)
    {
        $job = $this->client->getJob($jobId);

        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job posting not found or expired.'
            ], 404);
        }

        return response()->json([
            'status' => 'ok',
            'data' => $job->toArray(),
        ]);
    }
}
