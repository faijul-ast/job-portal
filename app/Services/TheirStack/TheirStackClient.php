<?php

namespace App\Services\TheirStack;

use App\Models\JobPosting;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TheirStackClient
{
    private string $baseUrl;
    private string $apiKey;
    private int $timeout;
    private int $retries;

    public function __construct()
    {
        $cfg = config('theirstack');

        $this->baseUrl = rtrim($cfg['base_url'] ?? '', '/');
        $this->apiKey  = (string) ($cfg['api_key'] ?? '');
        $this->timeout = (int) ($cfg['timeout'] ?? 20);
        $this->retries = (int) ($cfg['retries'] ?? 2);
    }

    private function http(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->apiKey) // Authorization: Bearer <token>
            ->acceptJson()
            ->asJson()
            ->timeout($this->timeout)
            ->retry($this->retries, 250, throw: false);
    }

    /**
     * Generic request wrapper
     */
    public function request(string $method, string $endpoint, array $query = [], array $payload = [])
    {
        $endpoint = '/'.ltrim($endpoint, '/');

        $req = $this->http();

        $resp = match (strtolower($method)) {
            'get'    => $req->get($endpoint, $query),
            'delete' => $req->delete($endpoint, $query),
            'post'   => $req->post($endpoint, $payload + ['_query' => $query]),
            'put'    => $req->put($endpoint, $payload + ['_query' => $query]),
            'patch'  => $req->patch($endpoint, $payload + ['_query' => $query]),
            default  => throw new \InvalidArgumentException("Unsupported method: $method"),
        };

        if ($resp->failed()) {
            // Bubble up details for logging/observability
            $message = $resp->json('message') ?? $resp->body();
            throw new RequestException($resp, $resp->toException() ?? new \Exception($message));
        }

        return $resp->json();
    }

    /* ---------------- Convenience helpers ---------------- */

    /**
     * Search jobs with filters (keywords, company, tech, location, date range, etc.)
     * NOTE: Exact path/params come from TheirStack’s Swagger "Jobs" endpoint.
     */
    public function searchJobs(array $filters = []): array
    {
        $query = JobPosting::query();

        // Only published jobs
        $query->published(); // assuming you already have scopePublished()

        // Dynamic filters
        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['company'])) {
            $query->where('company_name', 'like', '%' . $filters['company'] . '%');
        }

        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        if (!empty($filters['posted_from'])) {
            $query->whereDate('created_at', '>=', $filters['posted_from']);
        }

        if (!empty($filters['posted_to'])) {
            $query->whereDate('created_at', '<=', $filters['posted_to']);
        }

        // Pagination
        $perPage = $filters['per_page'] ?? 10;
        $page = $filters['page'] ?? 1;

        $paginator = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Transform paginator to array
        return [
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ];
    }

    /**
     * Get companies filtered by technology (technographics)
     */
    public function companiesByTechnology(string $technology, array $filters = []): array
    {
        $query = array_merge(['technology' => $technology], $filters);
        return $this->request('GET', '/companies', $query);
    }

    /**
     * For webhooks validation or single job/company fetch if needed
     */
    public function getJob(string $jobId): JobPosting
    {
        $job = JobPosting::published()->find($jobId);

        if (!$job) {
            // throw exception if not found
            throw new ModelNotFoundException("Job posting not found or expired.");
        }

        // Return as array
        return $job;
    }

    public function getCompany(string $companyId): array
    {
        return $this->request('GET', "/companies/{$companyId}");
    }
}
