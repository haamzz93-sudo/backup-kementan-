<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSalur extends Model
{
    use HasFactory;
    
    public $table = 'target_salur';
    protected $fillable = ['id','target_benih_id','tanggal_salur','jumlah','keterangan'];
    public $timestamps = false;
    public function laporantargetbenih()
    {
        return $this->belongsTo(LaporanTargetBenih::class,'target_benih_id');
    }
    public function targetbenih()
    {
        return $this->belongsTo(TargetBenih::class,'target_benih_id');
    }
    public function targetsalur()
    {
        return $this->belongsTo(TargetSalur::class,'target_benih_id');
    }
    public function lembaga()
    {
        return $this->belongsTo(TargetBenih::class,'lembaga_id');
    }
    
}
