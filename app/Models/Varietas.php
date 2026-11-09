<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Varietas extends Model
{
    use HasFactory;
    public $table = 'varietas'; 
    protected $fillable = ['komkel_id','komoditas_id','nama_varietas','kode','produsen_id','no_sk','tahun_daftar','upload_produk','upload_penciri','upload_deskripsi','no_reg','iklim','wil_adaptasi','asal','varietas_sanggah_id'];
    public $timestamps = false;
    protected $casts = [
        'wil_adaptasi' => 'array',
        'iklim' => 'array',
    ];

    public function laporantargetbenih()
    {
        return $this->hasMany(LaporanTargetBenih::class,'varietas_id');
    }
    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class,'produsen_id','id');
    }
    
    public function kelkomoditas()
    {
        return $this->belongsTo(KelKomoditas::class,'komkel_id');
    }
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }
    public function pohoninduk()
    {
        return $this->belongsTo(PohonInduk::class,'varietas_id');
    }
}
