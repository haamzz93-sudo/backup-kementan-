<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenguranganStokBenih extends Model
{
    use HasFactory;
    public $table = 'lap_pengurangan_stok';
    protected $fillable = ['id','target_benih_id','tanggal_lapor','upload_foto','jumlah','solusi','keterangan'];
    public $timestamps = false;

    public function targetbenih()
    {
        return $this->belongsTo(LaporanTargetBenih::class,'target_benih_id');
    }
    
}
