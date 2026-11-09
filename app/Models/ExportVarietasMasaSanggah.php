<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportVarietasMasaSanggah extends Model
{
    use HasFactory;
    public $table = 'varietas_sanggah'; 
    protected $fillable = ['id','komoditas_id','komkel_id','nama_varietas','produsen_id','tanggal_entri','upload_deskripsi','pemulia','peneliti','no_reg','tahun_daftar','no_sk','wil_adaptasi','asal','provinces_id','upload_produk','upload_penciri','deskripsi_baru','id_sumber_data','verifikasi','tambah','regencies_id','nama_pemohon','alamat','latitude','longitude','koordinat','nama_kepala','no_telp','tambah_pemohon','prov_id','negara'
    ];
    public $timestamps = false;

    public function pemohon()
    {
        return $this->belongsTo(Pemohon::class,'produsen_id');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }
    public function kelkomoditas()
    {
        return $this->belongsTo(KelKomoditas::class,'komkel_id');
    }
}
