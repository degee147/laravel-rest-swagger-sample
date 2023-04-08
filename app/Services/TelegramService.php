<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class TelegramService
{
    protected $token;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
    }

    public function getUpdates(int $offset = 0)
    {
        return $this->execute('getUpdates', []);
    }

    public function sendMessage(string $chat_id, string $text)
    {
        return $this->execute('sendMessage', [
            "chat_id" => $chat_id,
            "text" => $text,
        ]);
    }

    protected function execute($method, $params = [])
    {
        $url = 'https://api.telegram.org/bot' . $this->token . '/' . $method;
        $request = Http::post($url, $params);
        return $request->json('result', []);
    }
}
