<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kondisi extends Model
{
    use HasFactory;
    public $table = 'kondisi'; 
    protected $fillable = ['kondisi_sarpras'];
    public $timestamps = false;
}
