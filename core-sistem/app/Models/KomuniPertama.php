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
    	return $this->belongsTo(User::class, 'users_id');
    }

    public function paroki()
    {
    	return $this->belongsTo(Paroki::class, 'parokis_id');
    }
}
