<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikasiBenih extends Model
{
    use HasFactory;
    public $table = 'target_benih';
    protected $fillable = ['id','nomor_induk','tanggal_lapor','lembaga_id','komoditas_id','varietas_id','kelas_benih_id','jum_target','komkel_id','cara_id','golongan_id','lokasi_produksi_detail_id','tahun','upload_ubah','status','tanggal_lapor_tanam','tanggal_lapor_panen','tanggal_lapor_salur','satuan_id','luas_tanam','tanggal_r_tanam','tanggal_r_panen','tanggal_r_salur','jum_s_benih','jum_s_ada','jum_s_mati','jum_s_salur','keterangan'];
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

    public function batangbawah()
    {
        return $this->hasMany(PenerimaanBatangBawah::class,'target_benih_id');
    }
    public function perbanyakanbenih()
    {
        return $this->hasMany(ProsesPerbanyakanBenih::class,'target_benih_id');
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
    
    public function prosesperbanyakan()
    {
        return $this->hasMany(ProsesPerbanyakanBenih::class,'target_benih_id');
    }
    public function benihptm()
    {
        return $this->hasMany(LaporanBenihPTM::class,'target_benih_id');
    }
    public function pemeriksaantanaman()
    {
        return $this->hasMany(PemeriksaanTanaman::class,'lap_benih_panen_id');
    }
    public function laporansertifikasibenih()
    {
        return $this->hasMany(LaporanSertifikasiBenih::class,'lap_benih_panen_id');
    }
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
}