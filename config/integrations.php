<?php

return [
    'indeed' => [
        'publisher_name' => env('INDEED_PUBLISHER_NAME', 'Your Company'),
        'webhook_secret' => env('INDEED_WEBHOOK_SECRET'), // HMAC secret for signature
    ],

    'mappings' => [
        'employment_type' => [
            'full_time' => 'FULLTIME',
            'part_time' => 'PARTTIME',
            'contract'  => 'CONTRACT',
            'intern'    => 'INTERN',
            'temporary' => 'TEMPORARY',
        ],
        'employment_type_gfj' => [ // Google for Jobs
            'full_time' => 'FULL_TIME',
            'part_time' => 'PART_TIME',
            'contract'  => 'CONTRACTOR',
            'intern'    => 'INTERN',
            'temporary' => 'TEMPORARY',
        ],
    ],
];
