<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\ErpProject;
use Carbon\Carbon;
use App\Jobs\ProjectDeadlineReminder;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\projectDeadlineReminder'
        // Commands\projectDeadlineReminder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
//       $schedule->command('reminder:projectDeadline')->everyMinute();

        // $schedule->call(function () {
        //     $projects = ErpProject::whereDate('project_due_date', '=', Carbon::now())->get();

        //     foreach ($projects as $project) {
        //         $user = User::find($project->project_lead);
        //         Notification::send($user, new ProjectDeadline($project));
        //     }
        // })->everyMinute();

//       $schedule->call(function () {
//            $projects = ErpProject::whereDate('project_due_date', '=', Carbon::now())->get();
//
//            foreach ($projects as $project) {
//                dispatch(new ProjectDeadlineReminder());
//            }
//        })->everyMinute();
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
