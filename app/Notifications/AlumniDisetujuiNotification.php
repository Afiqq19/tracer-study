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
            ->subject('Selamat! Akun Tracer Study Anda Telah Disetujui')
            ->greeting('Halo, ' . $this->alumni->nama . '!')
            ->line('Kabar gembira! Pendaftaran akun Tracer Study Anda telah berhasil diverifikasi dan disetujui oleh Administrator sekolah.')
            ->line('Akun Anda sekarang telah aktif sepenuhnya. Anda dapat masuk untuk mengakses layanan tracer study dan mengisi kuesioner alumni.')
            ->action('Masuk ke Akun Sekarang', route('login'))
            ->line('Terima kasih atas partisipasi Anda dalam membantu kemajuan sekolah kita!')
            ->salutation("Salam hangat,\nTim Tracer Study Alumni SMK");
    }
}
