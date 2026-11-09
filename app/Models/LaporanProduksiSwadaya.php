<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanProduksiSwadaya extends Model
{
    use HasFactory;
    public $table = 'lap_produksi_swadaya';
    protected $fillable = ['id','satuan_id','lembaga_id','sumber_dana','komoditas_id','varietas_id','golongan_id','cara_id','kelas_benih_id','nama_dagang'];
    public $timestamps = false;
    protected $casts = [
        'sumber_dana' => 'array',
    ];
    public function produksiumum()
    {
        return $this->belongsTo(ProduksiBenihUmum::class,'lembaga_id');
    }
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }
    public function varietas()
    {
        return $this->belongsTo(Varietas::class,'varietas_id');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class,'satuan_id');
    }
    public function golongan()
    {
        return $this->belongsTo(Golongan::class,'golongan_id');
    }
    public function cara()
    {
        return $this->belongsTo(Cara::class,'cara_id');
    }
    public function kelasbenih()
    {
        return $this->belongsTo(KelasBenih::class,'kelas_benih_id');
    }
    public function childproduksiswadaya()
    {
        return $this->hasMany(ChildProduksiSwadaya::class,'laporan_produksi_swadaya_id');
    }
}
