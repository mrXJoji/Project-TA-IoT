<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'history';

    // Menentukan kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'suhu',
        'kelembaban',
        'amonia',
        'udara',
        'outputKondisi',
        'tindakan',
        'created_at',
        'updated_at'
    ];

    // Menonaktifkan pengisian otomatis timestamp jika Anda ingin mengisi created_at dan updated_at secara manual
    public $timestamps = true;
}
