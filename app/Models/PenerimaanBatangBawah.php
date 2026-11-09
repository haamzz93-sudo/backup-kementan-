<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBatangBawah extends Model
{
    use HasFactory;
    public $table = 'lap_pengadaan_btgbwh';
    protected $fillable = ['id','target_benih_id','jenis_ada_id','dokumen_pengajuan','keterangan_dokumen','tanggal_lapor','jumlah_biji','jumlah','upload','keterangan','man_total','varietas_id'];
    public $timestamps = false;
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
}
