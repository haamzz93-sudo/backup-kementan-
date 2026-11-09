<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasBenih extends Model
{
    use HasFactory;
    public $table = 'kelas_benih'; 
    protected $fillable = ['kelas_benih','kode_kel','kel_benih_id'];
    public $timestamps = false;

    public function kelbenih()
    {
        return $this->belongsTo(KelBenih::class);
    }
    public function laporantargetbenih()
    {
        return $this->hasMany(LaporanTargetBenih::class,'kelas_benih_id');
    }
    public function pohoninduk()
    {
        return $this->belongsTo(PohonInduk::class,'kelas_benih_id');
    }
}
