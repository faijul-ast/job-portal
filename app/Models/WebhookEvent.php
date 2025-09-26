<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $table = 'webhook_events';

    protected $fillable = [
        'provider','external_event_id','payload','status',
    ];

    protected $casts = [
        'payload' => 'string',
    ];
}
