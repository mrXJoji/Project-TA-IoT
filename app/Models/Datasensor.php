<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSensor extends Model
{
    protected $table = 'datasensor';

    protected $fillable = ['data', 'waktu'];
}
