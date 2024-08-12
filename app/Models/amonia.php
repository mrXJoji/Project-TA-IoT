<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class amonia extends Model
{
    protected $table = 'amonias';

    protected $fillable = ['amonia','waktu'];

    public function dataHasil()
    {
        return $this->hasMany(DataHasil::class, 'id_amonia');
    }
}
