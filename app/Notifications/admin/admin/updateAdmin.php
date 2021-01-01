<?php

namespace App\Notifications\admin\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class updateAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $password;

    public function __construct($password = null)
    {
        $password = $this->password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->password == null) {

            return (new MailMessage)
                ->line('Your Data Has Been Update Successfully')
                ->action('Login', url('/'))
                ->line('Thank you for using our application!');
        } else {
            return (new MailMessage)
                ->line('Your Data Has Been Update Successfully')
                ->line('And Your Password is ')
                ->line($this->password)
                ->action('Login', url('/'))
                ->line('Thank you for using our application!');

        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
