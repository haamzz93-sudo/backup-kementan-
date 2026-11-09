<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    public $table = 'label'; 
    protected $fillable = ['id','lap_sertifikasi_benih_id','varietas_id','kode_awal','satuan_label','terima_label','lot','satuan_id','jumlah_label','status_cetak','status_labeling','status','cms_users_id','tanggal_cetak','cms_users2_id','cms_users2_id','tanggal_labeling'];
    public $timestamps = false;
    
    public function penentuanlabel()
    {
        return $this->belongsTo(LaporanSertifikasiBenih::class,'lap_sertifikasi_benih_id');
    }
    
    public function satuan()
    {
        return $this->belongsTo(Satuan::class,'satuan_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class,'cms_users_id');
    }
}
