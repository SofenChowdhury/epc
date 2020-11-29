<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ErpProject;

class ProjectDeadline extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $project;

    public function __construct(ErpProject $project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        $project = $this->project;
        $today = date('Y m d', strtotime(Carbon::now()));
        $project_due = date('Y m d', strtotime($project->project_due_date));
        if ($today == $project_due){
            $days = 'Today.';
        }else{
            $days = 'in ' . date('d', strtotime($project->project_due_date) - strtotime(Carbon::now())) . ' day(s).';
        }

        return [
            'title' => 'Project Deadline Reminder',
            'data' => 'The "'. $project->project_name. '" project is due '. $days,
            'id' => $project->id,
            'route' => 'project.show',
        ];
    }
}
