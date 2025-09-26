<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Services\Google\GoogleForJobsSchemaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class JobsSchemaController extends Controller
{
    public function index()
    {
        $jobPostings = JobPosting::latest()->paginate(10);
        return view('job_postings.index', compact('jobPostings'));
    }

    public function show(string $slug, GoogleForJobsSchemaService $schema)
    {
        try {
            $job = JobPosting::where('slug', $slug)->published()->firstOrFail();
            $gfj = $schema->make($job);

            // If using Blade:
            return view('job_postings.show', ['job' => $job, 'gfjSchema' => $gfj]);
        } catch (Exception $e) {
            Log::error('JobListing Show: ' . $e->getMessage());

            return redirect()->route('job_postings.index')->with('error', 'Failed to find the job');
        }
    }

    public function create()
    {
        return view('job_postings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:255',
            'employment_type' => 'nullable|in:full-time,part-time,contract,internship,temporary',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'salary_currency' => 'nullable|string|max:10',
            'salary_period' => 'nullable|in:hourly,daily,weekly,monthly,yearly',
            'valid_through' => 'nullable|date',
            'is_public' => 'required|boolean',
            'is_remote' => 'required|boolean',
            'status' => 'nullable|in:draft,published,closed',
        ]);

        // Convert checkboxes to boolean
        $validated['is_public'] = $request->has('is_public');
        $validated['is_remote'] = $request->has('is_remote');

        $validated['slug'] = Str::slug($request->title);
        $validated['user_id'] = auth()->id() ?? null;

        JobPosting::create($validated);

        return redirect()->route('job_postings.index')->with('success', 'Job posting created successfully!');
    }
}
