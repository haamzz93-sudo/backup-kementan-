<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepemilikanPohonInduk extends Model
{
    use HasFactory;
    protected $casts = [
        'location' => 'object',
        'dapat_lapor' => 'boolean',
    ];
    public $table = 'pemilik_pohon'; 
    protected $fillable = ['id','provinces_id','lembaga_id','dapat_lapor','lembaga_serti_id','regencies_id','districts_id','villages_id','rt','rw','kodepos','nama_lembaga','alamat','koordinat','latitude','longitude','nama_kepala','no_telp','upload','jenis_pemilik_id','location'];
    public $timestamps = false;
    public function provinces()
    {
        return $this->belongsTo(Provinces::class,'provinces_id');
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class,'regencies_id');
    }
    public function districts()
    {
        return $this->belongsTo(Districts::class,'districts_id');
    }
    public function villages()
    {
        return $this->belongsTo(Villages::class,'villages_id');
    }
    public function jenis_pemilik()
    {
        return $this->belongsTo(JenisPemilik::class,'jenis_pemilik_id');
    }
    public function lemser()
    {
        return $this->belongsTo(LembagaSertifikasi::class,'lembaga_serti_id');
    }
    public function pohoninduk()
    {
        return $this->hasMany(PohonInduk::class,'pemilik_pohon_id');
    }
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'id');
    }
}
