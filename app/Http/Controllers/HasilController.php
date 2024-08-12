<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suhu;
use App\Models\Kelembaban;
use App\Models\Amonia;
use App\Models\Udara;
use App\Models\History;

class HasilController extends Controller
{
    public function Rekap(){
        // Mengambil data terbaru dari setiap kategori berdasarkan field 'waktu'
        $latestSuhu = Suhu::latest('waktu')->first();
        $latestKelembaban = Kelembaban::latest('waktu')->first();
        $latestAmonia = Amonia::latest('waktu')->first();
        $latestUdara = Udara::latest('waktu')->first();
        
        $latestValues = [
            'suhu' => $latestSuhu ? $latestSuhu->suhu_udara : null,
            'kelembaban' => $latestKelembaban ? $latestKelembaban->kelembaban_udara : null,
            'amonia' => $latestAmonia ? $latestAmonia->amonia : null,
            'udara' => $latestUdara ? $latestUdara->kecepatan_udara : null,
        ];

        $kategori = [
            'suhu' => $this->kategorikanSuhu($latestValues['suhu']),
            'kelembaban' => $this->kategorikanKelembaban($latestValues['kelembaban']),
            'amonia' => $this->kategorikanAmonia($latestValues['amonia']),
            'udara' => $this->kategorikanUdara($latestValues['udara']),
        ];
        
        $outputKondisi = $this->tentukanKondisi($kategori);
        $tindakan = $this->tentukanTindakan($outputKondisi);

        // Menyimpan hasil ke tabel datahasils
        $dataHasil = new History();
        $dataHasil->suhu = $latestValues['suhu'];
        $dataHasil->kelembaban = $latestValues['kelembaban'];
        $dataHasil->amonia = $latestValues['amonia'];
        $dataHasil->udara = $latestValues['udara'];
        $dataHasil->outputKondisi = $outputKondisi;
        $dataHasil->tindakan = $tindakan;
        $dataHasil->created_at = now();
        $dataHasil->updated_at = now();
        $dataHasil->save();

        // Mengambil data hasil keputusan terbaru
        // $latestDataHasil = History::latest('created_at')->get();
        $latestDataHasil = History::orderBy('created_at', 'desc')->paginate(5);
    
        return view('rekap', compact('latestDataHasil', 'latestValues', 'kategori', 'outputKondisi', 'tindakan'));
    }

    private function kategorikanSuhu($suhu)
    {
        if ($suhu < 18) {
            return 'Dingin (D)';
        } elseif ($suhu >= 18 && $suhu <= 24) {
            return 'Sedang (S)';
        } else {
            return 'Panas (P)';
        }
    }

    private function kategorikanKelembaban($kelembaban)
    {
        if ($kelembaban < 50) {
            return 'Kering (K)';
        } elseif ($kelembaban >= 50 && $kelembaban <= 70) {
            return 'Lembab (L)';
        } else {
            return 'Basah (B)';
        }
    }

    private function kategorikanAmonia($amonia)
    {
        if ($amonia < 15) {
            return 'Rendah (R)';
        } elseif ($amonia >= 15 && $amonia <= 25) {
            return 'Sedang (S)';
        } else {
            return 'Tinggi (T)';
        }
    }

    private function kategorikanUdara($udara)
    {
        if ($udara < 3.6) {
            return 'Rendah (R)';
        } elseif ($udara >= 3.6 && $udara <= 9) {
            return 'Sedang (S)';
        } else {
            return 'Tinggi (T)';
        }
    }

    private function tentukanKondisi($kategori)
    {
        $aturan = [
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Sangat Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Aman'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Basah (B)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Basah (B)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Basah (B)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Basah (B)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Sangat Berbahaya'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Sangat Berbahaya'],
        
            // Tambahan aturan untuk mencakup semua kombinasi indikator
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Sangat Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Sangat Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Aman'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Rendah (R)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Aman'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Aman'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Aman'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Aman'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Sedang (S)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Dingin (D)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Waspada'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Sedang (S)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Sangat Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Sangat Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Kering (K)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Sangat Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Rendah (R)', 'Output' => 'Sangat Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Sedang (S)', 'Output' => 'Sangat Berbahaya'],
            ['PPM' => 'Tinggi (T)', 'Suhu' => 'Panas (P)', 'Kelembaban' => 'Lembab (L)', 'Kecepatan Angin' => 'Tinggi (T)', 'Output' => 'Sangat Berbahaya'],
        ];
        
        foreach ($aturan as $rule) {
            if (
                $rule['PPM'] == $kategori['amonia'] &&
                $rule['Suhu'] == $kategori['suhu'] &&
                $rule['Kelembaban'] == $kategori['kelembaban'] &&
                $rule['Kecepatan Angin'] == $kategori['udara']
            ) {
                return $rule['Output'];
            }
        }

        return 'Tidak Terdefinisi';
    }

    private function tentukanTindakan($outputKondisi)
    {
        $tindakan = [
            'Sangat Aman' => 'Tidak ada tindakan khusus diperlukan.',
            'Aman' => 'Pantau secara berkala.',
            'Waspada' => 'Perhatikan kondisi dan lakukan tindakan pencegahan.',
            'Berbahaya' => 'Ambil tindakan segera.',
            'Sangat Berbahaya' => 'Evakuasi segera dan lakukan tindakan darurat.'
        ];

        return $tindakan[$outputKondisi] ?? 'Tidak ada tindakan yang ditentukan.';
    }
}
