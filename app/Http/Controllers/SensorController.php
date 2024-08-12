<?php

namespace App\Http\Controllers;

use App\Models\amonia;
use App\Models\kelembaban;
use App\Models\suhu;
use App\Models\udara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    public function getData()
{
    $data = suhu::select('waktu', 'suhu_udara')
                ->orderBy('waktu', 'desc')
                ->take(10)
                ->get();
    
    return response()->json($data);
}


    public function getData2()
    {
        $data = kelembaban::select('waktu', 'kelembaban_udara')->orderBy('waktu', 'desc')
        ->take(10)->get();
        return response()->json($data);
    }

    public function getData3()
    {
        $data = amonia::select('waktu', 'amonia')->orderBy('waktu', 'desc')
        ->take(10)->get();
        return response()->json($data);
    }

    public function getData4()
    {
        $data = udara::select('waktu', 'kecepatan_udara')->orderBy('waktu', 'desc')
        ->take(10)->get();
        return response()->json($data);
    }

    public function getDataKnob()
    {
        $latestData = Suhu::select('waktu', 'suhu_udara')
            ->latest('waktu')
            ->first();
    
        if ($latestData) {
            return response()->json(['suhu_udara' => $latestData->suhu_udara]);
        }
    
        return response()->json(['suhu_udara' => null]);
    }

    public function getDataKnob2()
    {
        $latestData = kelembaban::select('waktu', 'kelembaban_udara')
            ->latest('waktu')
            ->first();
    
        if ($latestData) {
            return response()->json(['kelembaban_udara' => $latestData->kelembaban_udara]);
        }
    
        return response()->json(['kelembaban_udara' => null]);
    }

    public function getDataKnob3()
    {
        $latestData = amonia::select('waktu', 'amonia')
            ->latest('waktu')
            ->first();
    
        if ($latestData) {
            return response()->json(['amonia' => $latestData->amonia]);
        }
    
        return response()->json(['amonia' => null]);
    }

    public function getDataKnob4()
    {
        $latestData = udara::select('waktu', 'kecepatan_udara')
            ->latest('waktu')
            ->first();
    
        if ($latestData) {
            return response()->json(['kecepatan_udara' => $latestData->kecepatan_udara]);
        }
    
        return response()->json(['kecepatan_udara' => null]);
    }
    
}
