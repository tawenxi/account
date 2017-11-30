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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pull:data')
                 ->dailyAt('9:45');
        $schedule->command('sendmail:dpt 5')
                 ->dailyAt('11:33');
        $schedule->command('sendmail:dpt 365')
                 ->monthly()->at('11:33');
       // $schedule->command('testcommand')->everyminut();

        //$schedule->exec('touch aaaa.txt')->sendOutputTo(storage_path());


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
