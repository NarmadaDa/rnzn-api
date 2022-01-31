<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class ArticleDownloadEmail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * The article instance.
   *
   * @var \App\Models\Article
   */
  private $article;

  /**
   * Create a new message instance.
   *
   * @param  \App\Models\Article  $article
   * @return void
   */
  public function __construct(Article $article)
  {
    $this->article = $article;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $subject = "HomePort Article download - " . $this->article->title;
    $view = "emails.articles.download";
    $from = [
      "address" => config("mail.from.address"),
      "name" => config("mail.from.name"),
    ];
    $params = ["title" => $this->article->title];

    $data = [
      "content" => $this->article->content,
      "title" => $this->article->title,
    ];

    $name = $this->article->title . " - RNZN HomePort Article.pdf";
    $pdf = PDF::loadView("pdf.article", $data)->output();
    $metadata = [
      "as" => $name,
      "mime" => "application/pdf",
    ];

    return $this->from($from)
      ->subject($subject)
      ->markdown($view, $params)
      ->attachData($pdf, $name);
  }
}
