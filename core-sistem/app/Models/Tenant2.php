<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant2 extends Model
{
    use HasFactory;
    protected $connection = 'landlord';
    protected $table = 'tenants';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function user() 
    { 
        return $this->belongsTo(User::class);
    }
}
