<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ErpProject;
use App\User;
use Carbon\Carbon;
use Notification;
use App\Notifications\ProjectDeadline;
// use App\Console\Commands\Log;

class projectDeadlineReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:projectDeadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is project deadline reminder 2 days before';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        \Log::info('I was here in commands @ '.Carbon::now());
//        $projects = ErpProject::whereDate('project_due_date', '=', Carbon::now()->addDays(2))->get();
//
//        foreach ($projects as $project) {
//            $user = User::find($project->project_lead);
//            Notification::send($user, new ProjectDeadline($project));
//        }
    }
}
