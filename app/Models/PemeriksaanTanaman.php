<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanTanaman extends Model
{
    use HasFactory;
    public $table = 'lap_benih_label'; 
    protected $fillable = ['id','lap_benih_panen_id','tanggal_lapor','jumlah_lanjut','jumlah_gagal','jumlah_tunda','satuan_id','man_total','upload','keterangan','status','status_cetak,','status_labeling','verifikasi'];
    public $timestamps = false;
    
    public function sertifikasibenih()
    {
        return $this->belongsTo(SertifikasiBenih::class,'lap_benih_panen_id');
    }
    
    public function benihptm()
    {
        return $this->belongsTo(LaporanBenihPTM::class,'lap_benih_panen_id');
    }
    public function lembaga()
    {
        return $this->belongsTo(TargetBenih::class,'lembaga_id');
    }
}
