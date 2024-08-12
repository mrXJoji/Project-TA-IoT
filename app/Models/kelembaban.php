<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelembaban extends Model
{
    protected $table = 'kelembabans';

    protected $fillable = ['kelembaban_udara', 'waktu'];

    public function dataHasil()
    {
        return $this->hasMany(DataHasil::class, 'id_kelembaban');
    }
}
