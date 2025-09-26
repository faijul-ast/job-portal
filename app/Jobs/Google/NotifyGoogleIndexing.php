<?php

namespace App\Jobs\Google;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Google\Client;
use Google\Service\Indexing;

class NotifyGoogleIndexing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $url;
    protected string $type;

    public function __construct(string $url, string $type = 'URL_UPDATED')
    {
        $this->url = $url;
        $this->type = $type;
    }

    public function handle()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google/indexing-sa.json'));
        $client->addScope(Indexing::INDEXING);

        $indexing = new Indexing($client);

        $urlNotification = new Indexing\UrlNotification();
        $urlNotification->setUrl($this->url);
        $urlNotification->setType($this->type);

        $indexing->urlNotifications->publish($urlNotification);
    }
}
