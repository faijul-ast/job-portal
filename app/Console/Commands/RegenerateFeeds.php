<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Indeed\JobFeedController;
use App\Services\Indeed\IndeedFeedBuilder;
use Illuminate\Support\Facades\Storage;

class RegenerateFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeds:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate job feeds (Indeed XML, sitemaps, etc.)';

    /**
     * Execute the console command.
     */

    public function handle(IndeedFeedBuilder $builder): int
    {
        // Example: write the Indeed feed to storage if you want a static file
        $controller = app(JobFeedController::class);
        $response   = $controller->indeedXml($builder);
        Storage::disk('public')->put('feeds/indeed.xml', $response->getContent());

        $this->info('Feeds regenerated.');
        return self::SUCCESS;
    }
}
