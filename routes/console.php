<?php

declare(strict_types=1);

use App\Console\Commands;
use Illuminate\Support\Facades\Schedule;

Schedule::command(Commands\CleanupStorage::class)->saturdays()->at('11:00');
Schedule::command(Commands\OptimizeImages::class)->saturdays()->at('12:00');
