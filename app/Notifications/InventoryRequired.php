<?php

namespace App\Notifications;

use App\ErpProject;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InventoryRequired extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $project, $product_name, $product_required;

    public function __construct(ErpProject $project, $product_name, $product_required)
    {
        $this->project = $project;
        $this->product_name = $product_name;
        $this->product_required = $product_required;
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
            'title' => 'New Materials Required for Project',
            'data' => $this->product_required . ' new ' . $this->product_name . ' required for '. $this->project->project_name,
            'id' => $this->project->id,
            'route' => 'project.show',
        ];
    }
}
