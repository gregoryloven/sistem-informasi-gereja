<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelayananLainnya extends Model
{
    use HasFactory;
    protected $table = 'pelayanan_lainnyas';
    protected $primaryKey = 'id';
}
