<?php

namespace App\Notifications;

use App\ErpTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionApproval extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected  $transaction;

    public function __construct(ErpTransaction $transaction)
    {
        $this->transaction = $transaction;
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
        $transaction = $this->transaction;

        return (new MailMessage)
            ->subject('Transaction Approval')
                    ->line('There has been a transaction. Please go to the link below to approve the transaction.')
                    ->action('Go to Transaction', url('single_transaction').'/'.$transaction->id)
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
        $transaction = $this->transaction;

        return [
            'title' => 'New Transaction',
            'data' => 'There has been a new transaction of Taka '.$transaction->total_transaction ,
            'url' => 'single_transaction'.'/'.$transaction->id,
        ];
    }
}
