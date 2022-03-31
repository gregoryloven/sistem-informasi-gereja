<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lingkungan extends Model
{
    use HasFactory;
    protected $table = 'lingkungans';
    protected $primaryKey = 'id';

    public function paroki()
    {
    	return $this->belongsTo(Paroki::class, 'paroki_id');
    }

    public function kbg()
    {
    	return $this->hasMany(Kbg::class, 'lingkungan_id', 'id');
    }
}
