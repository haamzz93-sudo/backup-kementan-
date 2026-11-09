<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiProduksiDetail extends Model
{
    use HasFactory;
    public $table = 'lokasi_produksi_detail'; 
    protected $fillable = ['id','lembaga_id','provinces_id','regencies_id','districts_id','villages_id','alamat','luas'];
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
}
