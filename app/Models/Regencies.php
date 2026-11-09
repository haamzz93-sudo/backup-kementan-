<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regencies extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','latitude','longitude','provinces_id'];
    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany(Districts::class);
    }
    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
    
    public function pemohon()
    {
        return $this->hasMany(Pemohon::class);
    }

    public function provincessebaran()
    {
        return $this->belongsTo(ProvincesSebaran::class,'provinces_id');
    }
}
