<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baptis extends Model
{
    use HasFactory;
    protected $table = 'baptiss';
    protected $primaryKey = 'id';

    public function user()
    {
    	return $this->belongsTo(User::class, 'users_id');
    }

    public function wali_baptis_ayah()
    {
    	return $this->belongsTo(User::class, 'wali_baptis_ayah');
    }

    public function wali_baptis_ibu()
    {
    	return $this->belongsTo(User::class, 'wali_baptis_ibu');
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
