<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misa extends Model
{
    use HasFactory;
    protected $table = 'misas';
    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
