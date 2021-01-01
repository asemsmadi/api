<?php

namespace App\Notifications\admin\withdrawal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewWithdrawalRequest extends Notification implements ShouldQueue
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
            ->line('تم استقبال طلب سحب رصيد جديد')
            ->action('تسجيل الدخول', url('/login'))
            ->line('شكرا لاستخدامك تطبيقنا ');
    }


}
