<?php

namespace App\Notifications;

use App\ErpTask;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskDeadline extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $task;

    public function __construct(ErpTask $task)
    {
        $this->task = $task;
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $task = $this->task;
        $today = date('Y m d', strtotime(Carbon::now()));
        $task_due = date('Y m d', strtotime($task->due_date));
        if ($today == $task_due){
            $days = 'Today.';
        }else{
            $days = 'in ' . date('d', strtotime($task->project_due_date) - strtotime(Carbon::now())) . ' day(s).';
        }

        return [
            'title' => 'Task Deadline Reminder',
            'data' => 'The "'. $task->task_name. '" task is due '. $days,
            'id' => $task->id,
            'route' => 'task.show',
        ];
    }
}
