<?php

namespace App\Notifications;

use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAssigenCoupon extends Notification
{
    use Queueable;
    public $offer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
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
                ->line('We have assigned new coupons for you check it now.')
                ->line('Offer name: ' . $this->offer->name_en)
                ->action('View Offer', route('admin.offers.show', $this->offer->id));
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
            'model' => 'Offer',
            'subject' => 'New update in you request coupons on ',
            'id' => $this->offer->id,
            'title' => $this->offer->name,
            'image' => $this->offer->thumbnail,
        ];
    }
}
