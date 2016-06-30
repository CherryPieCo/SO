<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Test::class,
        \App\Console\Commands\WebScraper::class,
        \App\Console\Commands\Packs::class,
        \App\Console\Parsers\Pages::class,
        \App\Console\Parsers\Moz::class,
        \App\Console\Parsers\Email::class,
        \App\Console\Parsers\Backlinks::class,
        \App\Console\Parsers\NotFound::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')->hourly();
    }
}
