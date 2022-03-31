<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paroki extends Model
{
    use HasFactory;
    protected $table = 'parokis';
    protected $primaryKey = 'id';

    public function lingkungan()
    {
    	return $this->hasMany(Lingkungan::class, 'paroki_id', 'id');
    }

    public function keluarga()
    {
    	return $this->hasMany(Keluarga::class, 'paroki_id', 'id');
    }
}
