<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasLiturgi extends Model
{
    use HasFactory;
    protected $table = 'petugas_liturgis';
    protected $primaryKey = 'id';

    public function list_event()
    {
    	return $this->hasMany(ListEvent::class, 'petugas_liturgi_id', 'id');
    }
}
