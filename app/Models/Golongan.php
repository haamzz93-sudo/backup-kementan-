<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;
    public $table = 'golongan'; 
    protected $fillable = ['gol_banyak'];
    public $timestamps = false;
    public function cara()
    {
        return $this->hasMany(Cara::class);
    }
}
