<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportSertifikatKompetensi extends Model
{
    use HasFactory;
    public $table = 'child_smm'; 
    protected $fillable = ['id','lembaga_id','no_serti','status','komkel_id','jenis_kompetensi','komoditas_id','varietas_id','luas_lahan','upload','tgl_awal','tgl_akhir'];
    public $timestamps = false;
    protected $casts = [
        'komkel_id' => 'json',
        'jenis_kompetensi' => 'json'
    ];
    
    public function kelkomoditas()
    {
        return $this->belongsToMany(KelKomoditas::class,'child_smm','id','komkel_id');
    }
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }
    public function varietas()
    {
        return $this->belongsTo(Varietas::class,'varietas_id');
    }
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
    public function perpanjangansmm()
    {
        return $this->hasMany(PerpanjanganSMM::class,'child_smm_id');
    }
}
