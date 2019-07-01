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
        'App\Console\Cltvo\CltvoSetMakeCommand',
        'App\Console\Cltvo\CltvoSetSiteCommand',
        'App\Console\Cltvo\CLtvoBindMakeCommand',
         \App\Console\Commands\CloseExpiredEvents::class,
         \App\Console\Commands\FinishEventCheckoutReminder::class,
         //  \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //           ->everyMinute();

        $schedule->command('events:close-expired')
                 ->daily();

         $schedule->command('events:remind-finish-checkout')
                  ->weekly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
