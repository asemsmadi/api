<?php

namespace App\Notifications\Investor\withdrawal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReceiveYourWithdrawal extends Notification implements ShouldQueue
{
    use Queueable;


    public function __construct()
    {
        //
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('تم استقبال طلبك الخاص بسحب رصيد')
            ->action('تسجيل الدخول', url('/login'))
            ->line('شكرا لاستخدامك تطبيقنا ');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
