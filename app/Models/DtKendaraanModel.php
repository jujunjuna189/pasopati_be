<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DtKendaraanModel extends Model
{
    use HasFactory;
    protected $table = 'dt_kendaraan';
    protected $guarded = ['id'];
}
