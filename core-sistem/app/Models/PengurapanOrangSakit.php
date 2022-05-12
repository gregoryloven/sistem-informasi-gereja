<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurapanOrangSakit extends Model
{
    use HasFactory;
    protected $table = 'pengurapan_orang_sakits';
    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
