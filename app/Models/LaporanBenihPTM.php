<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBenihPTM extends Model
{
    use HasFactory;
    public $table = 'lap_benih_panen'; 
    protected $fillable = ['id','target_benih_id','tanggal_panen','jum_panen','man_total','upload','keterangan','status'];
    public $timestamps = false;
    public function produksibenih()
    {
        return $this->belongsTo(ProduksiBenih::class,'target_benih_id');
    }
    public function prosesperbanyakanbenih()
    {
        return $this->hasMany(ProsesPerbanyakanBenih::class,'lap_benih_tumbuh_id');
    }
    public function pemeriksaanpertanaman()
    {
        return $this->hasMany(PemeriksaanTanaman::class,'lap_benih_panen_id');
    }
    public function penentuanlabel()
    {
        return $this->hasMany(LaporanSertifikasiBenih::class,'lap_benih_panen_id');
    }
}
