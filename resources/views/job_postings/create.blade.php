@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
            Post a New Job
        </h1>
    </div>

    <form method="POST" action="{{ route('job_postings.store') }}" class="space-y-8">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                    </svg>
                    Job Information
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Job Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            placeholder="Senior Software Engineer"
                            required
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="company_name" class="block text-sm font-medium text-slate-700 mb-2">Company Name</label>
                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            placeholder="Tech Corp Inc."
                            required
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Job Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        placeholder="Describe the role, responsibilities, requirements, and what makes this opportunity special..."
                        required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    ></textarea>
                    <p class="mt-1 text-sm text-slate-500">Provide a detailed description of the position (minimum 10 characters)</p>
                </div>

                <div>
                    <label for="employment_type" class="block text-sm font-medium text-slate-700 mb-2">Employment Type</label>
                    <select
                        id="employment_type"
                        name="employment_type"
                        required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">Select employment type</option>
                        <option value="full-time">Full Time</option>
                        <option value="part-time">Part Time</option>
                        <option value="contract">Contract</option>
                        <option value="temporary">Temporary</option>
                        <option value="internship">Internship</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Location Details
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Remote Work Toggle -->
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                    <div>
                        <label for="is_remote" class="text-base font-medium text-slate-800">Remote Work</label>
                        <p class="text-sm text-slate-600">This position can be performed remotely</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_remote" value="0">
                        <input type="checkbox" id="is_remote" name="is_remote" value="1" {{ old('is_remote', 1) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="street" class="block text-sm font-medium text-slate-700 mb-2">Street Address (Optional)</label>
                        <input
                            type="text"
                            id="street"
                            name="street"
                            placeholder="123 Main Street"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-slate-700 mb-2">City</label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            placeholder="San Francisco"
                            required
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-slate-700 mb-2">State/Province</label>
                        <input
                            type="text"
                            id="state"
                            name="state"
                            placeholder="California"
                            required
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-slate-700 mb-2">Postal Code (Optional)</label>
                        <input
                            type="text"
                            id="postal_code"
                            name="postal_code"
                            placeholder="94105"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="country" class="block text-sm font-medium text-slate-700 mb-2">Country</label>
                        <input
                            type="text"
                            id="country"
                            name="country"
                            placeholder="United States"
                            value="United States"
                            required
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Compensation -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Compensation
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-slate-700 mb-2">Minimum Salary (Optional)</label>
                        <input
                            type="number"
                            id="salary_min"
                            name="salary_min"
                            placeholder="50000"
                            min="0"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-slate-700 mb-2">Maximum Salary (Optional)</label>
                        <input
                            type="number"
                            id="salary_max"
                            name="salary_max"
                            placeholder="80000"
                            min="0"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="salary_currency" class="block text-sm font-medium text-slate-700 mb-2">Currency</label>
                        <select
                            id="salary_currency"
                            name="salary_currency"
                            required
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="USD">USD ($)</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="GBP">GBP (£)</option>
                            <option value="CAD">CAD (C$)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="salary_period" class="block text-sm font-medium text-slate-700 mb-2">Pay Period</label>
                    <select
                        id="salary_period"
                        name="salary_period"
                        required
                        class="w-full md:w-[200px] px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">Select period</option>
                        <option value="hourly">Per Hour</option>
                        <option value="monthly">Per Month</option>
                        <option value="yearly" selected>Per Year</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Job Settings -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path>
                    </svg>
                    Job Settings
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label for="valid_through" class="block text-sm font-medium text-slate-700 mb-2">Job Expires On</label>
                    <input
                        type="date"
                        id="valid_through"
                        name="valid_through"
                        required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <p class="mt-1 text-sm text-slate-500">When should this job posting expire?</p>
                </div>

                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                    <div>
                        <label for="is_public" class="text-base font-medium text-slate-800">Public Listing</label>
                        <p class="text-sm text-slate-600">Make this job visible to all job seekers</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_public" value="0">
                        <input type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public', 1) ? 'checked' : '' }} checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button
                type="submit"
                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-lg hover:opacity-90 transition-all shadow-lg font-medium"
            >
                Post Job
            </button>
        </div>
    </form>
</div>

@endsection

@push('script')
    <script>
        // Set default expiration date to 30 days from now
        const validThroughInput = document.getElementById('valid_through');
        const thirtyDaysFromNow = new Date();

        thirtyDaysFromNow.setDate(thirtyDaysFromNow.getDate() + 30);
        validThroughInput.value = thirtyDaysFromNow.toISOString().split('T')[0];
    </script>
@endpush
