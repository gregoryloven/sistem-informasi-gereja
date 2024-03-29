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

    public function user()
    {
    	return $this->hasMany(User::class, 'kbg_id', 'id');
    }

    public function umat()
    {
    	return $this->hasMany(Umat::class, 'kbg_id', 'id');
    }

    public function keluarga()
    {
    	return $this->hasMany(Keluarga::class, 'kbg_id', 'id');
    }
}
