<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserFeedbackNotification extends Notification
{
  use Queueable;

  private $feedback;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($feedback)
  {
    $this->feedback = $feedback;
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
    return (new MailMessage())
      ->subject("New HomePort feedback received")
      ->greeting("Kia ora,")
      ->line("New feedback has been submitted by a HomePort user:")
      ->line($feedback->message)
      ->salutation("HomePort");
  }
}
