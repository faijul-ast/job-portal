<?php

namespace App\Http\Controllers\Google;

use App\Http\Controllers\Controller;
use App\Jobs\Google\NotifyGoogleIndexing;
use Illuminate\Http\Request;

class IndexingWebhookController extends Controller
{
    public function ping(Request $request)
    {
        $url  = $request->input('url');
        $type = $request->input('type', 'URL_UPDATED');
        NotifyGoogleIndexing::dispatch($url, $type)->onQueue('indexing');
        return response()->json(['queued' => true]);
    }
}
