<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ErpProject;
use App\User;
use Carbon\Carbon;
use Notification;
use App\Notifications\ProjectDeadline;

class ProjectDeadlineReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    // protected $details;

    // public function __construct($details)
    // {
    //     $this->details = $details;
    // }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('I was here in the jobs @ '.Carbon::now());
        $projects = ErpProject::whereDate('project_due_date', '=', Carbon::now()->addDays(2))->get();

        foreach ($projects as $project) {
            $user = User::find($project->project_lead);
            Notification::send($user, new ProjectDeadline($project));
        }
    }
}
