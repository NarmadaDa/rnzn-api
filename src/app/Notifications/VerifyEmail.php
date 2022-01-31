<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
  public function toMail($notifiable)
  {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable);
    }

    $replyToEmail = config("mail.from.address");
    $replyToName = config("mail.from.name");

    return (new MailMessage())
      ->replyTo($replyToEmail, $replyToName)
      ->subject("Verify your HomePort email address")
      ->greeting(
        "BZ for downloading the RNZN HomePort app – your connection to the Fleet."
      )
      ->line("Please click the button below to verify your email address:")
      ->action("I am not a robot", $this->verificationUrl($notifiable))
      ->line(
        "Full accessibility of this app is only available to Service Members. We will be checking your credentials in our Service files, if you are a RNZN Service Member or Reservist you will receive an authentication request in your DIXS inbox. Once we receive your acknowledgement you will gain full accessibility within the app."
      )
      ->line(
        "To ensure a prompt response please check that your personal email is entered in ESS."
      )
      ->line(
        "In the meantime enjoy using the app and staying connected in Guest mode!"
      )
      ->salutation("The HomePort Team");
  }
}
