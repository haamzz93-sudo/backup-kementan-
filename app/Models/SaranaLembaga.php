<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranaLembaga extends Model
{
    use HasFactory;
    public $table = 'lap_sarana_lembaga'; 
    protected $fillable = ['id','lembaga_id','sarpras_lembaga','kondisi_id','upload','keterangan','tahun_pengadaan','sumber_dana','qty'];
    public $timestamps = false;
    protected $casts = [
        'upload' => 'array',
    ];
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
    public function lembagasertifikasi()
    {
        return $this->belongsTo(LembagaSertifikasi::class,'lembaga_id');
    }
    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class);
    }
}
