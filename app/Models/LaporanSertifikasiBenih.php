<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanSertifikasiBenih extends Model
{
    use HasFactory;
    public $table = 'lap_sertifikasi_benih';
    protected $fillable = ['id','lap_benih_panen_id','no_serti','no_label1','tgl_periksa_akhir','tgl_berlaku','kode','upload'];
    public $timestamps = false;
    protected $casts = [
        'no_serti' => 'json'
    ];
    public function benihptm()
    {
        return $this->belongsTo(LaporanBenihPTM::class,'lap_benih_panen_id');
    }
    
    public function sertifikasibenih()
    {
        return $this->belongsTo(SertifikasiBenih::class,'lap_benih_panen_id');
    }
    public function label()
    {
        return $this->hasMany(Label::class,'lap_sertifikasi_benih_id');
    }
    
}
