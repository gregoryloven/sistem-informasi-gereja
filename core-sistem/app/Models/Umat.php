<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umat extends Model
{
    use HasFactory;
    protected $table = 'umats';
    protected $primaryKey = 'id';

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function lingkungan()
    {
    	return $this->belongsTo(Lingkungan::class, 'lingkungan_id');
    }

    public function kbg()
    {
    	return $this->belongsTo(Kbg::class, 'kbg_id');
    }

}
