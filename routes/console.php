<?php

declare(strict_types=1);

use App\Console\Commands;
use Illuminate\Support\Facades\Schedule;

Schedule::command(Commands\CleanupStorage::class)->saturdays()->at('10:00');
