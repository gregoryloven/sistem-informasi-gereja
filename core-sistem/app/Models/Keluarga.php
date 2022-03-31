<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;
    protected $table = 'keluargas';
    protected $primaryKey = 'id';

    public function user()
    {
    	return $this->belongsTo(User::class, 'id_kepala_keluarga');
    }

    public function kbg()
    {
    	return $this->belongsTo(Kbg::class, 'kbg_id');
    }

    public function lingkungan()
    {
    	return $this->belongsTo(Lingkungan::class, 'lingkungan_id');
    }

    public function paroki()
    {
    	return $this->belongsTo(Paroki::class, 'paroki_id');
    }
}
