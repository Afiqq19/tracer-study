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
        if (config('app.env') === 'production' || str_contains((string) config('app.url'), 'https://') || request()->header('X-Forwarded-Proto') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Auth\Notifications\VerifyEmail::createUrlUsing(function (object $notifiable) {
            return \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'verification.verify',
                \Illuminate\Support\Carbon::now()->addMinutes(10),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });

        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Aktivasi Akun Alumni - SMK Swasta Dwitunggal 2 Tanjung Morawa')
                ->view('emails.verify-email', [
                    'notifiable' => $notifiable,
                    'url' => $url,
                ]);
        });

        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Permintaan Reset Password Akun - SMK Swasta Dwitunggal 2 Tanjung Morawa')
                ->view('emails.reset-password', [
                    'notifiable' => $notifiable,
                    'url' => $url,
                    'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60),
                ]);
        });

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Verified::class,
            function ($event) {
                if (isset($event->user) && !$event->user->is_active) {
                    $event->user->update(['is_active' => true]);
                }
            }
        );
    }
}
