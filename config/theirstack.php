<?php

return [
    'base_url' => env('THEIRSTACK_BASE_URL', 'https://api.theirstack.com'),
    'api_key'  => env('THEIRSTACK_API_KEY'),
    // Tweak timeouts/retries as you like
    'timeout'  => 20,
    'retries'  => 2,
];
