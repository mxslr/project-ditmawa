<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Reset Password — DITMAWA Telkom University')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kami menerima permintaan untuk mereset password akun DITMAWA kamu.')
            ->action('Reset Password Sekarang', $url)
            ->line('Link ini akan kedaluwarsa dalam **60 menit**.')
            ->line('Jika kamu tidak merasa melakukan permintaan ini, abaikan saja email ini.')
            ->salutation("Salam,  \n**Tim DITMAWA Telkom University**");
    }
}
