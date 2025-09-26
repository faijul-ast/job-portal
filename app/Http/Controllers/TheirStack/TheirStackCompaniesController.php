<?php

namespace App\Http\Controllers\TheirStack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TheirStack\TheirStackClient;

class TheirStackCompaniesController extends Controller
{
    public function __construct(private TheirStackClient $client) {}

    /**
     * GET /api/theirstack/companies/by-tech
     * Example:
     *   /api/theirstack/companies/by-tech?technology=Shopify&country=IN&page=1&per_page=50
     */
    public function byTechnology(Request $request)
    {
        $validated = $request->validate([
            'technology' => ['required','string','max:200'],
            'country'    => ['sometimes','string','size:2'],
            'industry'   => ['sometimes','string','max:200'],
            'size_min'   => ['sometimes','integer','min:0'],
            'size_max'   => ['sometimes','integer','min:0'],
            'page'       => ['sometimes','integer','min:1'],
            'per_page'   => ['sometimes','integer','min:1','max:500'],
        ]);

        $tech = $validated['technology'];
        unset($validated['technology']);

        $companies = $this->client->companiesByTechnology($tech, $validated);

        return response()->json([
            'status' => 'ok',
            'filters' => ['technology' => $tech] + $validated,
            'data'   => $companies['data'] ?? $companies,
            'meta'   => $companies['meta'] ?? null,
        ]);
    }
}
