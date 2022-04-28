<?php

namespace App\Notifications;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CodeRecycled extends Notification
{
    use Queueable;
    public $coupon;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        //
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
        try {
            return (new MailMessage)
                    ->line('We have assigned new coupon for you check it now.')
                    ->line($this->coupon->code . ' in ' . $this->coupon->offer->name_en . ' offer')
                    ->action('View Offer', route('admin.offers.show', $this->coupon->offer->id));
        } catch (\Throwable $th) {
            Log::($th);
        }
        
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
            'subject' => 'Assign Code in '. $this->coupon->offer->name,
            'id' => $this->coupon->offer->id,
            'title' => $this->coupon->offer->name,
            'image' => $this->coupon->offer->thumbnail,
        ];
    }
}
