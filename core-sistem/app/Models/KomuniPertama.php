<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomuniPertama extends Model
{
    use HasFactory;
    protected $table = 'komuni_pertamas';
    protected $primaryKey = 'id';

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function romo()
    {
    	return $this->belongsTo(User::class, 'id_romo');
    }
    
    public function paroki()
    {
    	return $this->belongsTo(Paroki::class, 'paroki_id');
    }
}
