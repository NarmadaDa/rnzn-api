<?php

namespace App\Listeners;

use App\Events\NewsPostCreated;
use Log;
use Str;
use MicrosoftAzure\Storage\Queue\QueueRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

class SendNewsPostNotification
{
  private $proxy;

  /**
   * Create a new Listener instance.
   *
   * @return void
   */
  public function __construct()
  {
    $account = config('queue.connections.azure.accountname');
    $endpoint = config('queue.connections.azure.endpoint');
    $key = config('queue.connections.azure.key');

    $config = "DefaultEndpointsProtocol=https".
      ";AccountName=".$account.
      ";EndpointSuffix=".$endpoint.
      ";AccountKey=".$key;

    $this->proxy = QueueRestProxy::createQueueService($config);
  }

  /**
   * Handle the event.
   *
   * @param  \App\Events\NewsPostCreated  $event
   * @return void
   */
  public function handle(NewsPostCreated $event)
  {
    $queue = config('queue.connections.azure.queue.news');

    $post = $event->post;
    $message = base64_encode($post->getJSON());

    Log::info("Queueing notification for News Post: ".$post->uuid);

    try
    {  
      $this->proxy->createMessage($queue, $message);
    }
    catch (ServiceException $e)
    {
      $code = $e->getCode();
      $error_message = $e->getMessage();
      Log::error($code.": ".$error_message);
    }
  }
}
