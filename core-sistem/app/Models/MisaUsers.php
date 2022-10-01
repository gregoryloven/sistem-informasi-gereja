<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MisaUsers extends Model
{
    use HasFactory;
    protected $table = 'misa_users';
    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToOne(User::class, 'users_id', 'id');
    }

    public function list_events()
    {
        return $this->belongsToOne(ListEvent::class, 'list_events_id', 'id');
    }
}
