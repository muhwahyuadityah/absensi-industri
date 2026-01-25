<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailWithPassword extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
   /**
 * Get the verification URL for the given notifiable.
 */
protected function verificationUrl($notifiable)
{
    return \Illuminate\Support\Facades\URL::temporarySignedRoute(
        'password.set',
        now()->addHours(24),
        ['id' => $notifiable->getKey()]
    );
}
}