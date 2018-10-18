<?php

namespace App\Console;

use App\Http\Controllers\Reports\ProviderReportsController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Reports\UserReportsController;
use Carbon\Carbon;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //reports not finished
//         $schedule->call(function(){
//             ProviderReportsController::generateReports(Carbon::now(TIMEZONE)->startOfDay()->subSecond());
//             //add emailing function here
//         })->timezone('Europe/London')->monthlyOn(1, '00:00');
    }
}
