<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanProduksiMati extends Model
{
    use HasFactory;
    public $table = 'lap_produksi_mati'; 
    protected $fillable = ['id','target_benih_id','tanggal_lapor','jumlah','produksi_mati','upload','keterangan'];
    public $timestamps = false;
    public function produksibenih()
    {
        return $this->belongsTo(ProduksiBenih::class,'target_benih_id');
    }
}
