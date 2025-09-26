@extends('layouts.app')

@section('title', 'Job Details')

@section('content')
    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 py-4">
        <nav class="flex items-center space-x-2 text-sm text-slate-600">
            <a href="{{ route('job_postings.index') }}" class="hover:text-blue-600">Home</a>
            <span>/</span>
            <span class="text-slate-800">Senior Software Engineer</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Job Details -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Job Header -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8">
                <div class="flex items-start justify-between mb-6">
                    <div class="space-y-3">
                        <h1 class="text-3xl font-bold text-slate-800">{{ $job->title }}</h1>
                        <div class="flex items-center gap-3 text-slate-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-xl font-semibold">{{ $job->company_name }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-full text-sm font-medium text-center">
                            {{ ucwords(str_replace(['_', '-'], ' ', $job->employment_type)) }}
                        </span>
                        @if($job->is_remote)
                            <span class="border border-blue-300 text-blue-600 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                                Remote
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-lg">
                    <div class="flex items-center gap-2 text-slate-700">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $job->city }}, {{ $job->state }}, {{ $job->country }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <span>
                            {{ $job->salary_min ? $job->salary_currency . ' ' . number_format($job->salary_min) : 'N/A' }}
                            -
                            {{ $job->salary_max ? $job->salary_currency . ' ' . number_format($job->salary_max) : 'N/A' }}
                            / {{ $job->salary_period ?? 'year' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-700">
                        <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Expires {{ \Carbon\Carbon::parse($job->valid_through)->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Job Description</h2>
                <div class="prose prose-slate max-w-none">
                    <p class="text-slate-700 leading-relaxed mb-4">
                        {{ $job->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('feeds.jobs-sitemap')
@endsection

