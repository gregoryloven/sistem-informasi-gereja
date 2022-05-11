<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krisma extends Model
{
    use HasFactory;
    protected $table = 'krismas';
    protected $primaryKey = 'id';

    public function user()
    {
    	return $this->belongsTo(User::class, 'users_id');
    }

    public function romo()
    {
    	return $this->belongsTo(User::class, 'id_romo');
    }

    public function paroki()
    {
    	return $this->belongsTo(Paroki::class, 'parokis_id');
    }
}
