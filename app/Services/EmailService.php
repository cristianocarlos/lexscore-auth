<?php

namespace App\Services;

use App\Mail\EmailChangeMailable;
use App\Mail\PasswordResetMailable;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function userEmailChangeSend(string $token, string $email): void {
        $mailable = new EmailChangeMailable([
            'email' => $email,
            'link' => app('url') . "/user-email-change/confirm/{$token}",
            'subject' => 'Confirmação de e-mail ' . app('name'),
        ]);
        Mail::to($email)->queue($mailable);
    }

    public function userPasswordResetSend(string $token, string $email): void {
        $mailable = new PasswordResetMailable([
            'email' => $email,
            'link' =>  app('url') . "/user-password-reset/confirm/{$token}",
            'subject' => 'Solicitação de recuperação de senha ' . app('name'),
        ]);
        Mail::to($email)->queue($mailable);
    }
}
