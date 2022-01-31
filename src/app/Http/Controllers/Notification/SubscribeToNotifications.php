<?php

namespace App\Http\Controllers\Notification;

use App\HomePort;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\SubscribeToNotificationsRequest;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use Carbon\Carbon;
use Http;
use Log;
use Str;

class SubscribeToNotifications extends Controller
{
  /**
   * @var App\Repositories\Interfaces\DeviceRepositoryInterface
   */
  private $deviceRepository;
  private $secret, $url;

  /**
   * Create a new Controller instance.
   *
   * @param App\Repositories\Interfaces\DeviceRepositoryInterface $deviceRepository
   */
  public function __construct(DeviceRepositoryInterface $deviceRepository)
  {
    $this->deviceRepository = $deviceRepository;

    $hub = config('services.azure.notification-hubs.hub');
    $namespace = config('services.azure.notification-hubs.namespace');

    $this->secret = config('services.azure.notification-hubs.secret');    
    $this->url = "https://".$namespace.".servicebus.windows.net/".$hub."/installations";
  }

  /**
   * Handle the incoming request.
   *
   * @param  \App\Http\Requests\Notification\SubscribeToNotificationsRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(SubscribeToNotificationsRequest $request)
  {
    $data = $request->validated();

    $tags = [];
    if ($user = $request->user())
    {
      foreach ($user->roles as $role)
      {
        if ($role->slug !== "guest")
        {
          $tags[] = $role->slug;
        }
      }
    }

    $header = HomePort::deviceIdentifierHeader();
    $uuid = $request->header($header);
    $device = $this->deviceRepository->findByUUID($uuid);
    $platform = $device->platform();
    $expire = Carbon::now()->add('week', 2)->toW3cString();
    $templates = $device->type === "ios" ? $this->iosTemplates() : (
      $device->type === "android" ? $this->androidTemplates() : []
    );

    $url = $this->url."/".$uuid."?api-version=2020-06";
    $signature = $this->generateSignature($url);

    $headers = [
      'x-ms-version' => '2015-01',
      'Authorization' => $signature,
    ];
    $body = [
      'installationId' => $uuid,
      'platform' => $platform,
      'pushChannel' => $data['token'],
      'tags' => $tags,
      'expirationTime' => $expire,
      'templates' => $templates,
    ];

    Log::info("--> SubscribeToNotifications");

    $response = Http::withHeaders($headers)->put($url, $body);

    Log::info("response:");
    Log::info($response->status());
    
    return [
      'message' => 'Successfully subscribed to notifications.'
    ];
  }

  private function generateSignature($url)
  {
    $encodedUrl = strtolower(rawurlencode(strtolower($url)));
    $expiry = Carbon::now()->add('hour', 1)->timestamp;
    $toSign = $encodedUrl."\n".$expiry;
    $hashed = hash_hmac('sha256', $toSign, $this->secret, TRUE);
    $signature = rawurlencode(base64_encode($hashed));
    $result = "SharedAccessSignature sr=".$encodedUrl."&sig=".$signature."&se=".$expiry."&skn=DefaultFullSharedAccessSignature";

    return $result;
  }

  private function androidTemplates()
  {
    return [
      "news" => [
        "body" => json_encode([
          "data" => [
              "message" => "$(title)",
          ],
          "data" => [
              "type" => "news",
              "object" => "$(object)",
          ]
        ]),
        "tags" => ["personnel"],
      ]
    ];
  }

  private function iosTemplates()
  {
    return [
      "news" => [
        "body" => json_encode([
          "aps" => [
              "alert" => "$(title)",
              "badge" => "$(badge)",
          ],
          "data" => [
              "type" => "news",
              "object" => "$(object)",
          ]
        ]),
        "tags" => ["personnel"],
      ]
    ];
  }
}
