<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiGudangDetail extends Model
{
    use HasFactory;
    public $table = 'lokasi_gudang_detail'; 
    protected $fillable = ['id','lembaga_id','jenis_penyimpanan_id','provinces_id','regencies_id','districts_id','villages_id','alamat','kapasitas','keterangan'];
    public $timestamps = false;
    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class);
    }
    public function districts()
    {
        return $this->belongsTo(Districts::class);
    }
    public function villages()
    {
        return $this->belongsTo(Villages::class);
    }
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
    public function jenispenyimpanan()
    {
        return $this->belongsTo(JenisPenyimpanan::class,'jenis_penyimpanan_id');
    }
}
