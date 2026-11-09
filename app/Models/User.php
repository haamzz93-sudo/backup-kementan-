<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'lembaga_id',
        'lokasi_produksi_detail_id',
        'username',
        'password',
        'no_hp',
    ];
    public function provinces()
    {
        return $this->belongsTo(Provinces::class,'lembaga_id');
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class,'lembaga_id');
    }
    public function districts()
    {
        return $this->belongsTo(Districts::class,'lembaga_id');
    }
    public function villages()
    {
        return $this->belongsTo(Villages::class,'lembaga_id');
    }
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
