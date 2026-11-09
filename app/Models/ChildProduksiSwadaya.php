<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildProduksiSwadaya extends Model
{
    use HasFactory;
    public $table = 'child_produksi_swadaya'; 
    protected $fillable = ['id','laporan_produksi_swadaya_id','tanggal_lapor','produksi_benih','salur_benih','child_smm','jumlah_qr','no_batch','data','keterangan','kode_urut_awal','no_induk_sertifikasi','no_awal','no_akhir','no_sertifikat','dicetak_oleh','jumlah_download','boleh_download','no_registrasi_pohon','pemilik_pohon','alamat_pohon','pohon_induk_id','jumlah_label_download','boleh_label_download','jumlah_generate_excel','generate_excel'];
    public $timestamps = false;
    protected $casts = [
        'child_smm' => 'json',
        'data' => 'json'
    ];
    public function laporanproduksi()
    {
        return $this->belongsTo(LaporanProduksiSwadaya::class,'laporan_produksi_swadaya_id');
    }
    public function smm()
    {
        return $this->belongsToMany(SertifikasiKompetensi::class,'id','child_smm','no_label');
    }
}
