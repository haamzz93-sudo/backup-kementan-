<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetBenih extends Model
{
    use HasFactory;
    public $table = 'lembaga';
    protected $fillable = ['id','provinces_id','regencies_id','districts_id','villages_id','rt','rw','kodepos','nama_lembaga','lembaga_serti_id','jenis_lembaga_id','jenis_produsen_id','smm','sedia_bwg_pth','alamat','koordinat','latitude','longitude','nama_kepala','no_telp','lokasi_produksi_detail','lokasi_gudang_detail','status','upload','status_stok'];
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
    public function jenislembaga()
    {
        return $this->belongsTo(JenisLembaga::class,'jenis_lembaga_id');
    }
    public function jenisprodusen()
    {
        return $this->belongsTo(JenisProdusen::class,'jenis_produsen_id');
    }
    public function saranalembaga()
    {
        return $this->belongsTo(SaranaLembaga::class,'lembaga_id');
    }
    public function lokasiproduksidetail()
    {
        return $this->belongsTo(LokasiProduksiDetail::class,'lembaga_id');
    }
    public function lokasigudangdetail()
    {
        return $this->belongsTo(LokasiGudangDetail::class,'lembaga_id');
    }
    public function sertifikatkompetensi()
    {
        return $this->belongsTo(SertifikatKompetensi::class,'lembaga_id');
    }
    public function pohoninduk()
    {
        return $this->hasMany(PohonInduk::class,'lembaga_id');
    }
    public function laporantargetbenih()
    {
        return $this->hasMany(LaporanTargetBenih::class,'lembaga_id');
    }
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
    public function targetsalur()
    {
        return $this->hasMany(TargetSalur::class,'target_benih_id');
    }
}
