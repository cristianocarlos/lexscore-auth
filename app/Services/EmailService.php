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
            'link' => "http://ward.lexscore-com.test/user-email-change/confirm/{$token}", // TODO: hardcoded
            'subject' => 'Agora mail',
        ]);
        Mail::to($email)->queue($mailable);
    }

    public function userPasswordResetSend(string $token, string $email): void {
        $mailable = new PasswordResetMailable([
            'email' => $email,
            'link' => "http://ward.lexscore-com.test/user-password-reset/confirm/{$token}", // TODO: hardcoded
            'subject' => 'Agora pass',
        ]);
        Mail::to($email)->queue($mailable);
    }
}
