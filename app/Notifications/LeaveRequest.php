<?php

namespace App\Notifications;

use App\ErpEmployee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;

class LeaveRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $employee;

    public function __construct(ErpEmployee $employee)
    {
         $this->employee = $employee;
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
        return [
            'title' => 'A new Leave Request',
            'data' => $this->employee->first_name . ' ' . $this->employee->last_name . ' has asked for a leave',
//            'data' => Auth::user()->name. ' has asked for a leave',
            'id' => $this->employee->id,
        ];
    }
}
