<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPelayananLainnya extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran_pelayanan_lainnyas';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
