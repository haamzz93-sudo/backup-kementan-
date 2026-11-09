<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikasiNonAPBN extends Model
{
    use HasFactory;
    public $table = 'lap_produksi_swadaya';
    protected $fillable = ['id','satuan_id','lembaga_id','tanggal_lapor','sumber_dana','komoditas_id','varietas_id','produksi_benih','salur_benih'];
    public $timestamps = false;
    public function laporansertifikasinonapbn()
    {
        return $this->hasMany(LaporanSertifikasiNonAPBN::class,'lap_produksi_swadaya_id');
    }
    public function qrnon()
    {
        return $this->hasMany(QRNon::class,'sertifikasi_non_id');
    }
}
