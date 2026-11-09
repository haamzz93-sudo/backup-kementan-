<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorRegistrasi extends Model
{
    use HasFactory;
    public $table = 'child_pohon_induk'; 
    protected $fillable = ['id','lembaga_id','no_registrasi','pohon_induk_id','jumlah_pohon','pemilik_pohon_id','lembaga_serti_id'];
    public $timestamps = false;
    public function pohoninduk()
    {
        return $this->belongsTo(PohonInduk::class,'pohon_induk_id');
    }
    public function pemilikpohon()
    {
        return $this->belongsTo(KepemilikanPohonInduk::class,'pemilik_pohon_id');
    }
    public function lembagasertifikasi()
    {
        return $this->belongsTo(LembagaSertifikasi::class,'lembaga_serti_id');
    }
    public function kondisipohon()
    {
        return $this->hasMany(KondisiPohon::class,'child_pohon_induk_id');
    }
}
