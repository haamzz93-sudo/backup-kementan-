<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesPerbanyakanBenih extends Model
{
    use HasFactory;
    
    public $table = 'lap_benih_tumbuh'; 
    protected $fillable = ['id','target_benih_id','jumlah_entres','dokumen_pengajuan','keterangan_dokumen','tanggal_lapor','man_total','pengadaan_benih','benih_mati','benih_reokulasi','upload','keterangan'];
    public $timestamps = false;
    public function produksibenih()
    {
        return $this->belongsTo(ProduksiBenih::class,'target_benih_id');
    }
    public function laporanbenihptm()
    {
        return $this->belongsTo(LaporanBenihPTM::class,'target_benih_id');
    }
}
