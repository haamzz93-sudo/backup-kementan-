<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
class ProduksiBenihUmum extends Model
{
    use HasFactory;
    protected $casts = [
        'location' => 'object',
    ];
    public $table = 'lembaga'; 
    protected $fillable = [
        'id',
        'provinces_id',
        'regencies_id',
        'districts_id',
        'villages_id',
        'nama_lembaga',
        'jenis_lembaga_id',
        'jenis_produsen_id',
        'nama_kepala',
        'alamat',
        'rt',
        'rw',
        'kodepos',
        'no_telp',
        'location',
        'koordinat',
        'latitude',
        'longitude',
        'upload',
        'logo'
    ];
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
    public function jenis_lembaga()
    {
        return $this->belongsTo(JenisLembaga::class,'jenis_lembaga_id');
    }
    public function jenis_produsen()
    {
        return $this->belongsTo(JenisProdusen::class,'jenis_produsen_id');
    }
    public function laporanproduksiswadaya()
    {
        return $this->hasMany(LaporanProduksiSwadaya::class,'lembaga_id');
    }
    public function sertifikasinon()
    {
        return $this->hasMany(SertifikasiNonAPBN::class,'lap_produksi_swadaya_id');
    }
    public function lembagasertifikasi()
    {
        return $this->belongsTo(LembagaSertifikasi::class,'lembaga_serti_id');
    }
}
