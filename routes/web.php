<?php

use App\Services\TelegramService;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\HasilController;
use App\Models\suhu;
use App\Models\History;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan web routes untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan di-assign ke 
| kelompok middleware "web". Buatlah sesuatu yang hebat!
|
*/

// LOGIN ===============================================================================
Route::get('/login', [LoginController::class, 'TampilLogin'])->name('login');
Route::get('/register', [LoginController::class, 'tampilHalamanRegister']);

Route::post('/post-login', [LoginController::class, 'postLogin'])->name('post-login');
Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        $suhu = suhu::all();
        return view('welcome', compact('suhu'));
    });   

    Route::get('/api/notifications', function () {
        // Mengambil data sensor terbaru dari tabel History
        $latestValues = History::latest()->first();

        // Memeriksa apakah data tersedia
        if ($latestValues) {
            // Membuat pesan yang mencakup semua data dari catatan terakhir
            $message = "Data Monitoring Kandang Ayam:\n" .
                    "Pada Tanggal / Jam: " . $latestValues->created_at . "\n".
                    "Suhu: " . $latestValues->suhu . " °C\n" .
                    "Kelembaban: " . $latestValues->kelembaban . " %\n" .
                    "Amonia: " . $latestValues->amonia . " ppm\n" .
                    "Udara: " . $latestValues->udara . " km/h\n" .
                    "Kondisi: " . $latestValues->outputKondisi . "\n" .
                    "Tindakan: " . $latestValues->tindakan . "\n" ;

            // Mengirim pesan melalui Telegram
            $telegramService = app(TelegramService::class);
            $telegramService->sendMessage($message);

            // Mengirim respons JSON bahwa notifikasi telah dikirim
            return Response::json([
                'NotifBaru' => true,
                'message' => $message,
                'data' => $latestValues
            ]);
        }

        // Jika tidak ada data yang ditemukan
        return Response::json([
            'NotifBaru' => false,
            'message' => 'Tidak ada data sensor yang tersedia.',
            'data' => null
        ]);
    });

    // Route::get('/api/notifications', [NotificationController::class, 'checkNotifications']);
    // Route::get('/api/notifications', function () {
    //     // Memanggil service Telegram untuk mengirim pesan
    //     $telegramService = app(App\Services\TelegramService::class);
    //     $telegramService->sendMessage('6852067057', 'Ini adalah pesan notifikasi dari Laravel');
    // });
    // Route::get('/test-notification', function () {
    //     $telegramService = app(App\Services\TelegramService::class);
    //     $telegramService->sendMessage('6852067057', 'Ini adalah pesan notifikasi dari Laravel');
    //     return 'Pesan telah dikirim';
    // });
    

    Route::get('/data', [SensorController::class, 'getData']);
    Route::get('/data2', [SensorController::class, 'getData2']);
    Route::get('/data3', [SensorController::class, 'getData3']);
    Route::get('/data4', [SensorController::class, 'getData4']);

    Route::get('/data-knob', [SensorController::class, 'getDataKnob']);
    Route::get('/data-knob2', [SensorController::class, 'getDataKnob2']);
    Route::get('/data-knob3', [SensorController::class, 'getDataKnob3']);
    Route::get('/data-knob4', [SensorController::class, 'getDataKnob4']);


    Route::get('/welcome', [AdminController::class, 'Welcome']);
    Route::get('/datasensor', [AdminController::class, 'DataSensor']);
    Route::get('/rekap', [HasilController::class, 'Rekap']);
    Route::get('/hasilsensor', [AdminController::class, 'HasilSensor']);

    Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);
});

Route::get('/tambah-pengguna', [AdminController::class, 'TambahPengguna']);
Route::post('/simpan-pengguna', [AdminController::class, 'SimpanPengguna']);

Route::post('/datasensor', function(Request $request) {
    // Ambil data dari permintaan
    $temperature = $request->input('temperature');
    $humidity = $request->input('humidity');
    $ammonia = $request->input('ammonia');
    $windspeed = $request->input('windspeed');
    return response()->json(['message' => 'Data diterima dan disimpan'], 200);
});



