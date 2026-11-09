<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','latitude','longitude','provinces_id','regencies_id'];
    public $timestamps = false;

    public function villages()
    {
        return $this->hasMany(Villages::class);
    }
    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class);
    }
}
