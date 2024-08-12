<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected $telegramBotToken;
    protected $chatId;
    protected $client;

    public function __construct()
    {
        // Pastikan file config/telegram.php berisi konfigurasi yang benar
        $this->telegramBotToken = config('telegram.bot_token');
        $this->chatId = config('telegram.chat_id');
        $this->client = new Client();
    }

    public function sendMessage($message, $chatId = null)
    {
        $chatId = $chatId ?: $this->chatId; // Gunakan chat ID default jika tidak diberikan
        $url = "https://api.telegram.org/bot{$this->telegramBotToken}/sendMessage";
        $params = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        $this->client->post($url, ['json' => $params]);
    }
}

