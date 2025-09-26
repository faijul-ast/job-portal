@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Create Job Posting</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('job_postings.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Job Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Description</label>
            <textarea name="description" rows="6"
                      class="w-full border px-3 py-2 rounded" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Company Name</label>
            <input type="text" name="company_name" value="{{ old('company_name') }}"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label>City</label>
                <input type="text" name="city" value="{{ old('city') }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label>State</label>
                <input type="text" name="state" value="{{ old('state') }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label>Country</label>
                <input type="text" name="country" value="{{ old('country') }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label>Postal Code</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div class="col-span-2">
                <label>Street</label>
                <input type="text" name="street" value="{{ old('street') }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label>Employment Type</label>
                <select name="employment_type" class="w-full border px-3 py-2 rounded">
                    <option value="">Select Type</option>
                    @foreach(['full-time','part-time','contract','internship','temporary'] as $type)
                        <option value="{{ $type }}" {{ old('employment_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Salary Min</label>
                <input type="number" step="0.01" name="salary_min" value="{{ old('salary_min') }}" class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label>Salary Max</label>
                <input type="number" step="0.01" name="salary_max" value="{{ old('salary_max') }}" class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label>Currency</label>
                <input type="text" name="salary_currency" value="{{ old('salary_currency') }}" class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label>Salary Period</label>
                <select name="salary_period" class="w-full border px-3 py-2 rounded">
                    <option value="">Select</option>
                    @foreach(['hourly','daily','weekly','monthly','yearly'] as $period)
                        <option value="{{ $period }}" {{ old('salary_period') == $period ? 'selected' : '' }}>{{ ucfirst($period) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Valid Through</label>
                <input type="date" name="valid_through" value="{{ old('valid_through') }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div class="flex items-center space-x-4 mb-4">
            <label>
                <input type="hidden" name="is_public" value="0">
                <input type="checkbox" name="is_public" value="1" {{ old('is_public', 1) ? 'checked' : '' }}>
                Public
            </label>

            <label>
                <input type="hidden" name="is_remote" value="0">
                <input type="checkbox" name="is_remote" value="1" {{ old('is_remote') ? 'checked' : '' }}>
                Remote
            </label>

        </div>

        <div class="mb-4">
            <label>Status</label>
            <select name="status" class="w-full border px-3 py-2 rounded">
                @foreach(['draft','published','closed'] as $status)
                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Create Job
        </button>
    </form>
</div>
@endsection
