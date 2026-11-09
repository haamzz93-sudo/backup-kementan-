<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPenyimpanan extends Model
{
    use HasFactory;
    public $table = 'jenis_penyimpanan'; 
    protected $fillable = ['id','nama_penyimpanan'];
    public $timestamps = false;

}
