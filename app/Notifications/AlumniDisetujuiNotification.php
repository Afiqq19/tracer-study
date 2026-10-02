<?php

namespace App\Notifications;

use App\Models\Alumni;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlumniDisetujuiNotification extends Notification
{
    use Queueable;

    public $alumni;

    /**
     * Create a new notification instance.
     */
    public function __construct(Alumni $alumni)
    {
        $this->alumni = $alumni;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Selamat! Akun Tracer Study Anda Telah Disetujui - SMK Swasta Dwitunggal 2 Tanjung Morawa')
            ->view('emails.alumni-disetujui', [
                'alumni' => $this->alumni,
                'notifiable' => $notifiable,
                'loginUrl' => route('login'),
            ]);
    }
}
