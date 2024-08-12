<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\History;

class PdfController extends Controller
{
    public function generatePdf()
    {
        // Ambil data history terbaru dari tabel history
        $latestHistory = History::orderBy('created_at', 'desc')->first();

        // Data yang akan dikirim ke view
        $latestValues = [
            'suhu' => $latestHistory->suhu,
            'kelembaban' => $latestHistory->kelembaban,
            'amonia' => $latestHistory->amonia,
            'udara' => $latestHistory->udara
        ];

        $kategori = [
            'suhu' => 'Normal',
            'kelembaban' => 'Normal',
            'amonia' => 'Aman',
            'udara' => 'Biasa'
        ];

        $outputKondisi = $latestHistory->outputKondisi;
        $tindakan = $latestHistory->tindakan;

        // Ambil semua data history dari tabel history
        $latestDataHasil = History::orderBy('created_at', 'desc')->get();

        // Render view ke PDF
        $pdf = PDF::loadView('generate-pdf', compact('latestValues', 'kategori', 'outputKondisi', 'tindakan', 'latestDataHasil'));

        // Unduh file PDF
        return $pdf->download('hasil_keputusan.pdf');
    }
}
