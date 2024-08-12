<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suhu extends Model
{
    protected $table = 'suhus';

    protected $fillable = ['suhu_udara', 'waktu'];

    public function dataHasil()
    {
        return $this->hasMany(DataHasil::class, 'id_suhu');
    }
}
