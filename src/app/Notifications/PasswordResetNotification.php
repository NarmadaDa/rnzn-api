<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PasswordResetNotification extends Notification
{
  use Queueable;

  private $password;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($password)
  {
    $this->password = $password;
  }

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

    $password = new HtmlString("<code><strong>" . $this->password . "</strong></code>");

    return (new MailMessage())
      ->replyTo($replyToEmail, $replyToName)
      ->subject("Your temporary HomePort password")
      ->greeting("Ahoy there,")
      ->line(
        "You have requested to reset your Navy HomePort password. A temporary password has been generated for you below:"
      )
      ->line($password)
      ->line("This password is case-sensitive, and will expire in 48 hours.")
      ->line(
        "For security reasons, you will be required to create a new password immediately after you sign in with your temporary password."
      )
      ->line(
        "If you did not request to reset your Navy HomePort password, please advise HomePort administrators of this issue by replying to this email."
      )
      ->salutation("The HomePort Team");
  }
}
