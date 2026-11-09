<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarietasSebar extends Model
{
    use HasFactory;
    public $table = 'varietas_sebar'; 
    protected $fillable = ['lembaga_id','provinces_id','regencies_id','komkel_id','komoditas_id','varietas_id','tanggal_lapor_sebar','luas_sebar'];
    public $timestamps = false;

    public function varietas()
    {
        return $this->belongsTo(Varietas::class,'varietas_id');
    }
    
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }

    public function kelkomoditas()
    {
        return $this->belongsTo(KelKomoditas::class,'komkel_id');
    }

    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class);
    }
}
