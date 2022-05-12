<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurapanOrangSakitUsers extends Model
{
    use HasFactory;
    protected $table = 'pengurapan_orang_sakit_users';
    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToOne(User::class, 'users_id', 'id');
    }

    public function pengurapan_orang_sakits()
    {
        return $this->belongsToOne(Tobat::class, 'pengurapan_orang_sakits_id', 'id');
    }
}
