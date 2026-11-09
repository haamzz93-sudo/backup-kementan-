<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanStokBenih extends Model
{
    use HasFactory;
    
    public $table = 'lap_pengadaan_stok';
    protected $fillable = ['id','target_benih_id','provinces_id','regencies_id','districts_id','villages_id','lembaga_penyedia','alamat','keperluan','tanggal_lapor','upload_foto','upload_dokumen','jumlah'];
    public $timestamps = false;

    public function stokprodusen()
    {
        return $this->belongsTo(StokProdusen::class,'target_benih_id');
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
