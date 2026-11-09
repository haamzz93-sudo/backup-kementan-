<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemohon extends Model
{
    use HasFactory;
    public $table = 'pemohon'; 
    protected $fillable = ['provinces_id','regencies_id','nama_produsen','alamat','nama_kepala','no_telp','kode_v_awal'];
    public $timestamps = false;
    public function provinces()
    {
        return $this->belongsTo(Provinces::class,'provinces_id');
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class,'regencies_id');
    }
    public function varietas()
    {
        return $this->hasMany(Varietas::class,'produsen_id');
    }
    public function varietassanggah()
    {
        return $this->hasMany(VarietasSanggah::class,'produsen_id');
    }
}
