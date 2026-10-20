<?php

namespace App\Providers;

use App\Models\Review;
use App\Policies\ReviewPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Notifications\Messages\MailMessage;
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
        //
        $this->app->make(Gate::class)->policy(Review::class, ReviewPolicy::class);
        // Email "lupa kata sandi" dalam bahasa Indonesia
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
            $menit = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

            return (new MailMessage)
                ->subject('Atur Ulang Kata Sandi Musiverse')
                ->greeting('Halo, '.$notifiable->name.'!')
                ->line('Kami menerima permintaan untuk membuat kata sandi baru bagi akun Musiverse kamu.')
                ->action('Buat Kata Sandi Baru', $url)
                ->line("Tautan ini berlaku selama {$menit} menit.")
                ->line('Kalau bukan kamu yang meminta, abaikan saja email ini. Kata sandimu tidak akan berubah.')
                ->salutation('Salam, Tim Musiverse');
        });
    }
}
