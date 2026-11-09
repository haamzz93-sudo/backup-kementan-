<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelBenih extends Model
{
    use HasFactory;
    public $table = 'kel_benih'; 
    protected $fillable = ['nama_kelompok'];
    public $timestamps = false;
}
