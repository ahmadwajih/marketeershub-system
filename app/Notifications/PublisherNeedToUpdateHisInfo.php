<?php

namespace App\Notifications;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PublisherNeedToUpdateHisInfo extends Notification
{
    use Queueable;
    public $publisher;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                ->line('There is an publisher need to update his personal information.')
                ->line('Publisher name: ' . $this->publisher->name_en)
                ->line('Publisher email: ' . $this->publisher->email)
                ->action('View Publisher', route('admin.publishers.show', $this->publisher->id));
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
            'model' => 'User',
            'subject' => $this->publisher->name . ' need to update his personal information',
            'id' => $this->publisher->id,
            'title' => $this->publisher->name,
            'image' => $this->publisher->thumbnail,
        ];
    }
}
