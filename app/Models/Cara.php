<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cara extends Model
{
    use HasFactory;
    public $table = 'cara'; 
    protected $fillable = ['golongan_id','cara_banyak','btg_bwh'];
    public $timestamps = false;
    public function golongan (){
        return $this->belongsTo(Golongan::class);
    }
    public function laporantargetbenih()
    {
        return $this->hasMany(LaporanTargetBenih::class,'cara_id');
    }
}
