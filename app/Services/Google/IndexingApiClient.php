<?php

namespace App\Services\Google;

use Google\Client as GoogleClient;
use Google\Service\Indexing as GoogleIndexing;
use Google\Service\Indexing\UrlNotification;

class IndexingApiClient
{
    private GoogleIndexing $service;

    public function __construct()
    {
        $client = new GoogleClient();
        $client->setAuthConfig(storage_path('app/'.env('GOOGLE_INDEXING_SA_JSON')));
        $client->setScopes(['https://www.googleapis.com/auth/indexing']);
        $client->setSubject(null); // not needed when the SA is Search Console owner
        $this->service = new GoogleIndexing($client);
    }

    /**
     * type: URL_UPDATED or URL_DELETED
     */
    public function notify(string $url, string $type = 'URL_UPDATED'): void
    {
        $notification = new UrlNotification();
        $notification->setUrl($url);
        $notification->setType($type);
        $this->service->urlNotifications->publish($notification);
    }
}
