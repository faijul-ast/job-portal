<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('feeds:regenerate')
    ->everyFifteenMinutes()
    ->withoutOverlapping()
    ->onFailure(function () {
        Log::error('Command failed regenerate feed');
    });
