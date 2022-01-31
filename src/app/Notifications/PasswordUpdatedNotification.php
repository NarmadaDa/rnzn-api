<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordUpdatedNotification extends Notification
{
  use Queueable;

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ["mail"];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    $replyToEmail = config("mail.from.address");
    $replyToName = config("mail.from.name");

    return (new MailMessage())
      ->replyTo($replyToEmail, $replyToName)
      ->subject("Your Navy HomePort password has been updated")
      ->greeting("Avast shippers,")
      ->line("Your Navy HomePort password was successfully changed.")
      ->line(
        "If you did not change your password, please advise HomePort administrators by replying to this email."
      )
      ->salutation("The HomePort Team");
  }
}
