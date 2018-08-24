<?php

namespace App\Lines;

class LINE
{
    protected $bot;

    public function __construct()
    {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('LINEBOT_CHANNEL_TOKEN') ?: '');
        $this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('LINEBOT_CHANNEL_SECRET') ?: '']);
    }

    public function pushText($to, $message)
    {
        $messageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
        $response = $this->bot->pushMessage($to, $messageBuilder);
        return $response;
    }
}
