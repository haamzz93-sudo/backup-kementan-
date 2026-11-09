<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    use HasFactory;
    public $table = 'komoditas'; 
    protected $fillable = ['kd_kom','grp_kom','komkel_id','nama','nama_latin','masa_dormansi'];
    public $timestamps = false;
    
    public function laporantargetbenih()
    {
        return $this->hasMany(LaporanTargetBenih::class,'komoditas_id');
    }
    public function kelkomoditas()
    {
        return $this->belongsTo(KelKomoditas::class,'komkel_id');
    }
    public function varietas()
    {
        return $this->hasMany(Varietas::class,'komoditas_id');
    }
    public function varietassanggah()
    {
        return $this->hasMany(VarietasSanggah::class,'komoditas_id');
    }

    public function varietassebar()
    {
        return $this->hasMany(VarietasSebar::class,'komoditas_id');
    }
    public function pohoninduk()
    {
        return $this->belongsTo(PohonInduk::class,'komoditas_id');
    }
    
    public function kondisipohon()
    {
        return $this->belongsTo(KondisiPohon::class,'komoditas_id');
    }
}
