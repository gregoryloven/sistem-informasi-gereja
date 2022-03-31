<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kbg extends Model
{
    use HasFactory;
    protected $table = 'kbgs';
    protected $primaryKey = 'id';

    public function lingkungan()
    {
    	return $this->belongsTo(Lingkungan::class, 'lingkungan_id');
    }

    public function keluarga()
    {
    	return $this->hasMany(Keluarga::class, 'paroki_id', 'id');
    }
}
