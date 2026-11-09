<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villages extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','provinces_id','regencies_id','districts_id'];
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
    public function lembagasertifikasi()
    {
        return $this->hasMany(LembagaSertifikasi::class);
    }
    
    public function produsenbenih()
    {
        return $this->hasMany(ProdusenBenih::class);
    }
    public function lokasiproduksidetail()
    {
        return $this->hasMany(LokasiProduksiDetail::class);
    }
}
