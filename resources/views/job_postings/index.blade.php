@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-6xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-6">
            Find Your Dream Job
        </h1>
        <p class="text-xl text-slate-600 mb-8 max-w-2xl mx-auto">
            Discover amazing opportunities with top companies. Your career journey starts here.
        </p>
    </div>

    @if($jobPostings->count())
        <!-- Job Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($jobPostings as $job)
                <div class="bg-gradient-to-br from-white to-slate-50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-slate-200">
                    <div class="p-6 flex justify-between flex-col h-full">
                        <div>
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="space-y-2">
                                    <h3 class="text-xl font-bold text-slate-800 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('job_postings.show', $job->slug) }}">{{ $job->title }}</a>
                                    </h3>
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="font-medium">{{ $job->company_name }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <span class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-1 rounded-full text-sm font-medium text-center">
                                        {{ ucwords(str_replace(['_', '-'], ' ', $job->employment_type)) }}
                                    </span>
                                    @if($job->is_remote)
                                        <span class="border border-blue-300 text-blue-600 px-3 py-1 rounded-full text-sm font-medium flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                            </svg>
                                            Remote
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-slate-600 mb-4 line-clamp-3">
                                {{ $job->description }}
                            </p>

                            <!-- Job Details -->
                            <div class="flex flex-wrap gap-4 text-sm text-slate-600 mb-4">
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $job->city }}, {{ $job->state }}, {{ $job->country }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <span>
                                        {{ $job->salary_min ? $job->salary_currency . ' ' . number_format($job->salary_min) : 'N/A' }}
                                        -
                                        {{ $job->salary_max ? $job->salary_currency . ' ' . number_format($job->salary_max) : 'N/A' }}
                                        / {{ $job->salary_period ?? 'year' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Expires {{ \Carbon\Carbon::parse($job->valid_through)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('job_postings.show', $job->slug) }}" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-2 px-4 rounded-lg hover:opacity-90 transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
    @else
        <p class="text-gray-600">No jobs found.</p>
    @endif
</div>
@endsection
