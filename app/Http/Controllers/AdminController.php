<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\suhu;
use App\Models\kelembaban;
use App\Models\amonia;
use App\Models\udara;
use App\Models\Datahasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function Welcome(){
        return view('welcome)', compact ('sen'));
    }

    public function getData()
    {
        // Mengambil data dari database
        $data = DB::table('suhus')->select('waktu', 'suhu_udara')->orderBy('waktu', 'asc')->get();

        // Mengembalikan data dalam format JSON
        return response()->json($data);
    }

    public function DataSensor(){
        $suhu = suhu::all();
        $kelembaban = kelembaban::all();
        $amonia = amonia::all();
        $udara = udara::all();
        return view('datasensor', compact('suhu', 'kelembaban', 'amonia', 'udara'));
    }

    public function HasilSensor(){
        return view('hasilsensor');
    }
    
    
    

    public function TambahPengguna(){
        //$adm = User::with('pegawai')->latest()->get();
        $user = User::all();
        return view('tambah-pengguna', compact('user'));
    }

    public function SimpanPengguna(Request $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        return redirect('tambah-pengguna');
    }
}
