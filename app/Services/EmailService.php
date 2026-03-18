<?php

namespace App\Services;

use App\Mail\EmailChangeMailable;
use App\Mail\PasswordResetMailable;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function userEmailChangeSend(string $token, string $email, string $host): void {
        $mailable = new EmailChangeMailable([
            'email' => $email,
            'link' => "{$host}/user-email-change/confirm/{$token}",
            'subject' => 'Confirmação de e-mail ' . config('mail.from.name'),
        ]);
        Mail::to($email)->send($mailable);
    }

    public function userPasswordResetSend(string $token, string $email, string $host): void {
        $mailable = new PasswordResetMailable([
            'email' => $email,
            'link' => "{$host}/user-password-reset/confirm/{$token}",
            'subject' => 'Solicitação de recuperação de senha ' . config('mail.from.name'),
        ]);
        Mail::to($email)->send($mailable);
    }
}
