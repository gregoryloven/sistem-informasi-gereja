<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function riwayat()
    {
    	return $this->hasMany(Riwayat::class, 'user_id', 'id');
    }
    
    public function lingkungan()
    {
    	return $this->belongsTo(Lingkungan::class, 'lingkungan_id');
    }

    public function kbg()
    {
    	return $this->belongsTo(Kbg::class, 'kbg_id');
    }
    
    public function keluarga()
    {
    	return $this->hasMany(Keluarga::class, 'keluarga_id', 'id');
    }

    public function baptis()
    {
    	return $this->hasMany(Baptis::class, 'user_id', 'id');
    }

    public function komunipertama()
    {
    	return $this->hasMany(KomuniPertama::class, 'user_id', 'id');
    }

    public function misas()
    {
        return $this->belongsToMany(Misa::class);
    }

    public function tobats()
    {
        return $this->belongsToMany(Tobat::class);
    }

    public function pengurapanorangsakits()
    {
        return $this->belongsToMany(PengurapanOrangSakit::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'agama',
        'lingkungan_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
