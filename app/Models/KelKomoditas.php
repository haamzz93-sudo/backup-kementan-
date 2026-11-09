<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelKomoditas extends Model
{
    use HasFactory;
    public $table = 'kel_komoditas'; 
    protected $fillable = ['id','nama_kelompok'];
    public $timestamps = false;
    public function pohoninduk()
    {
        return $this->belongsTo(PohonInduk::class,'komkel_id');
    }
    public function laporantargetbenih()
    {
        return $this->hasMany(LaporanTargetBenih::class,'komkel_id');
    }
    public function komoditas()
    {
        return $this->hasMany(Komoditas::class,'komkel_id');
    }
    
    public function sertifikatkompetensi()
    {
        return $this->hasMany(SertifikatKompetensi::class,'komkel_id');
    }
}
