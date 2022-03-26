<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paroki extends Model
{
    use HasFactory;
    protected $table = 'parokis';
    protected $primaryKey = 'id';
}
