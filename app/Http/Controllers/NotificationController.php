<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function sendNotification(Request $request)
    {
        $chatId = $request->input('chat_id');
        $message = $request->input('message');

        $this->telegramService->sendMessage($chatId, $message);

        return response()->json(['status' => 'Message sent successfully!']);
    }

    public function checkNotifications()
    {
        // Contoh logika untuk memeriksa notifikasi baru
        // Ini bisa dari database atau cache yang menyimpan notifikasi terbaru
        $latestNotification = History::latest()->first();

        // Jika tidak ada notifikasi, kembalikan nilai false
        if (!$latestNotification) {
            return response()->json([
                'hasNewNotification' => false,
                'message' => ''
            ]);
        }

        // Kembalikan notifikasi jika ada
        return response()->json([
            'hasNewNotification' => true,
            'message' => $latestNotification->message
        ]);
    }

    public function store(Request $request)
    {
        // Simpan data sensor ke database
        $history = new History();
        $history->amonia = $request->input('amonia');
        // ... (setel data lain yang diperlukan)
        $history->save();

        // Cek kondisi dan kirim notifikasi jika perlu
        if ($history->amonia > 5) { // Contoh threshold
            $message = "Peringatan: Gas amonia tinggi! Nilai: " . $history->amonia . " ppm.";
            app(TelegramService::class)->sendMessage($message);
        }

        return response()->json(['message' => 'Data berhasil disimpan dan notifikasi dikirim jika diperlukan.']);
    }
}
