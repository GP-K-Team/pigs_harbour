<?php

declare(strict_types=1);

use App\Jobs;
use App\Console\Commands;
use Illuminate\Support\Facades\Schedule;

// Schedule::job(Jobs\GenerateSitemap::class)->dailyAt(20);
Schedule::command(Commands\CleanupStorage::class)->saturdays()->at('10:00');
