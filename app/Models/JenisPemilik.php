<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPemilik extends Model
{
    use HasFactory;
    public $table = 'jenis_pemilik'; 
    protected $fillable = ['id','nama_jenis'];
    public $timestamps = false;
}
