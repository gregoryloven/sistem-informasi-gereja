<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPetugas extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran_petugas_liturgis';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
