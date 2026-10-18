<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Prottek minute-e check kore dose reminder pathaay (dose-er 15 min age)
Schedule::command('reminders:doses')->everyMinute();

// Prottek 15 minute-e check kore appointment reminder pathaay (appointment-er 24 ghonta age)
Schedule::command('reminders:appointments')->everyMinute();
