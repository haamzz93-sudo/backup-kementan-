<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportProduksiStok extends Model
{
    use HasFactory;
    public $table = 'target_benih';
    public $timestamps = false;

     public function lembaga()
    {
        return $this->belongsTo(TargetBenih::class,'lembaga_id');
    }
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }
    public function varietas()
    {
        return $this->belongsTo(Varietas::class,'varietas_id');
    }
    public function kelkomoditas()
    {
        return $this->belongsTo(KelKomoditas::class,'komkel_id');
    }
    public function kelasbenih()
    {
        return $this->belongsTo(KelasBenih::class,'kelas_benih_id');
    }
    public function cara()
    {
        return $this->belongsTo(Cara::class,'cara_id');
    }
    public function golongan()
    {
        return $this->belongsTo(Golongan::class,'golongan_id');
    }
    
    public function satuan()
    {
        return $this->belongsTo(Satuan::class,'satuan_id');
    }
    public function lokasiproduksidetail()
    {
        return $this->belongsTo(LokasiProduksiDetail::class,'lokasi_produksi_detail_id');
    }
    public function produksi()
    {
        return $this->hasMany(ProsesPerbanyakanBenih::class,'target_benih_id');
    }
    public function produksimati()
    {
        return $this->hasMany(LaporanProduksiMati::class, 'target_benih_id', 'id');
    }
    public function ptm()
    {
        return $this->hasMany(LaporanBenihPTM::class,'target_benih_id');
    }
    public function ptmmati()
    {
        return $this->hasMany(LaporanLabelMati::class,'target_benih_id');
    }
    public function pengadaanstok()
    {
        return $this->hasMany(PengadaanStokBenih::class,'target_benih_id');
    }
    public function penguranganstok()
    {
        return $this->hasMany(PenguranganStokBenih::class,'target_benih_id');
    }
    public function penyaluranstok()
    {
        return $this->hasMany(PenyaluranStokBenih::class,'target_benih_id');
    }
    public function targetsalur()
    {
        return $this->hasMany(TargetSalur::class,'target_benih_id');
    }
}