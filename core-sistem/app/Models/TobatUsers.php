<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TobatUsers extends Model
{
    use HasFactory;
    protected $table = 'tobat_users';
    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToOne(User::class, 'user_id', 'id');
    }

    public function tobats()
    {
        return $this->belongsToOne(Tobat::class, 'tobat_id', 'id');
    }
}
