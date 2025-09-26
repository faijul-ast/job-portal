@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Job Listings</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($jobPostings->count())
        <div class="grid gap-6">
            @foreach($jobPostings as $job)
                <div class="border p-4 rounded shadow hover:shadow-lg transition">
                    <h2 class="text-xl font-semibold">
                        <a href="{{ route('job_postings.show', $job->slug) }}" class="text-blue-600 hover:underline">
                            {{ $job->title }}
                        </a>
                    </h2>

                    <p class="text-gray-700">
                        <strong>Company:</strong> {{ $job->company_name }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Location:</strong> {{ $job->city }}, {{ $job->state }}, {{ $job->country }}
                        @if($job->is_remote)
                            <span class="text-green-600 font-semibold">(Remote)</span>
                        @endif
                    </p>

                    @if($job->salary_min || $job->salary_max)
                        <p class="text-gray-700">
                            <strong>Salary:</strong>
                            {{ $job->salary_min ? $job->salary_currency . ' ' . number_format($job->salary_min) : 'N/A' }}
                            -
                            {{ $job->salary_max ? $job->salary_currency . ' ' . number_format($job->salary_max) : 'N/A' }}
                            / {{ $job->salary_period ?? 'year' }}
                        </p>
                    @endif

                    <p class="text-gray-600 mt-2">
                        <strong>Status:</strong> {{ ucfirst($job->status) }}
                    </p>

                    <div class="mt-3">
                        <a href="{{ route('job_postings.show', $job->slug) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $jobPostings->links() }}
        </div>
    @else
        <p class="text-gray-600">No jobs found.</p>
    @endif
</div>
@endsection
