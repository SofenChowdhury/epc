<?php

namespace App\Notifications;

use App\ErpEmployeeSalaryPrint;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SalarySataementApprove extends Notification
{
    use Queueable;

    protected $salary;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ErpEmployeeSalaryPrint $salary)
    {
        $this->salary = $salary;
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
            'title' => 'Salary Statement Approval',
            'data' => 'Salary Statement for ' . $this->salary->salary_month . ' has been issued. Your approval is required.',
            'url' => 'salary_statement',
        ];
    }
}
