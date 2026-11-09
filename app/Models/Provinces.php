<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','latitude','longitude','location'];
    public $timestamps = false;

    public function regencies()
    {
        return $this->hasMany(Regencies::class);
    }
    
    protected $casts = [
        'location' => 'object'
    ];
}
