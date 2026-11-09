<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportProduksiNonAPBN extends Model
{
    use HasFactory;
    public $table = 'lap_produksi_swadaya';
    protected $fillable = ['id','satuan_id','lembaga_id','sumber_dana','komoditas_id','varietas_id'];
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
    public function childproduksiswadaya()
    {
        return $this->hasMany(ChildProduksiSwadaya::class,'laporan_produksi_swadaya_id');
    }
}
