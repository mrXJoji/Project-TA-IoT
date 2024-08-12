<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataHasil extends Model
{
    use HasFactory;

    protected $table = 'datahasil';
    protected $fillable = [
        'id_suhu',
        'id_kelembaban',
        'id_amonia',
        'id_udara',
        'status'
    ];

    public function suhu()
    {
        return $this->belongsTo(suhu::class, 'id_suhu');
    }

    public function kelembaban()
    {
        return $this->belongsTo(kelembaban::class, 'id_kelembaban');
    }

    public function amonia()
    {
        return $this->belongsTo(amonia::class, 'id_amonia');
    }

    public function udara()
    {
        return $this->belongsTo(udara::class, 'id_udara');
    }
}
