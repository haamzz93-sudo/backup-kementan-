<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    public $table = 'satuan'; 
    protected $fillable = ['nama_satuan'];
    public $timestamps = false;
    
    public function laporantargetbenih()
    {
        return $this->hasMany(LaporanTargetBenih::class,'satuan_id');
    }
}
