<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PejabatModel extends Model
{
    use HasFactory;

    protected $table = 'pejabat';
    protected $fillable = ['nama', 'pangkat', 'nrp', 'jabatan', 'satuan'];
}
