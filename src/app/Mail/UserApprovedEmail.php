<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class UserApprovedEmail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * The user instance.
   *
   * @var \App\Models\User
   */
  private $user;

  /**
   * Create a new message instance.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function __construct(User $user)
  {
    $this->user = $user;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $subject = "HomePort account approved";
    $view = "emails.users.approved";
    $from = [
      "address" => config("mail.from.address"),
      "name" => config("mail.from.name"),
    ];

    return $this->from($from)
      ->subject($subject)
      ->markdown($view);
  }
}
