<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class udara extends Model
{
    protected $table = 'udaras';

    protected $fillable = ['kecepatan_udara', 'waktu'];

    public function dataHasil()
    {
        return $this->hasMany(DataHasil::class, 'id_udara');
    }
}
