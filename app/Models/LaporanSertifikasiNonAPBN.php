<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanSertifikasiNonAPBN extends Model
{
    use HasFactory;
    public $table = 'sertifikasi_non'; 
    protected $fillable = ['id','lap_produksi_swadaya_id','tanggal_lapor','jenis_dokumen','upload_dokumen','upload_penyaluran'];
    public $timestamps = false;
    public function laporanswadaya()
    {
        return $this->belongsTo(LaporanProduksiSwadaya::class,'lap_produksi_swadaya_id');
    }
}
