<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanRanpurModel extends Model
{
    use HasFactory;

    protected $table = 'perizinan_ranpur';
    protected $guarded = ['id'];

    public function userModel()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
