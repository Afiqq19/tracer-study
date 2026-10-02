<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Verifikasi Alamat Email Anda - Tracer Study Alumni SMK')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Terima kasih telah mendaftar di sistem Tracer Study Alumni SMK.')
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:')
                ->action('Verifikasi Alamat Email', $url)
                ->line('Setelah email terverifikasi, akun Anda akan diverifikasi oleh Admin sekolah sebelum Anda dapat masuk.')
                ->line('Jika Anda tidak merasa mendaftar di sistem ini, abaikan email ini.')
                ->salutation("Salam hangat,\nTim Tracer Study");
        });
    }
}
