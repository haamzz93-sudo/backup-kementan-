<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyaluranStokBenih extends Model
{
    use HasFactory;
    public $table = 'lap_penyaluran_stok';
    protected $fillable = ['id','target_benih_id','provinces_id','regencies_id','districts_id','villages_id','nama_penerima','alamat','upload_dokumen','keperluan','tanggal_lapor','upload_foto','jumlah'];
    public $timestamps = false;

    public function targetbenih()
    {
        return $this->belongsTo(LaporanTargetBenih::class,'target_benih_id');
    }
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
}
