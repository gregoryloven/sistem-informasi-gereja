<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelayananLainnya extends Model
{
    use HasFactory;
    protected $table = 'pelayanan_lainnyas';
    protected $primaryKey = 'id';

    public function pendaftaran_pelayanan()
    {
    	return $this->hasMany(PendaftaranPelayananLainnya::class, 'pelayanan_lainnya_id', 'id');
    }
}
