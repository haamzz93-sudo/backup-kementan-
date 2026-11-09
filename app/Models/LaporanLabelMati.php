<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanLabelMati extends Model
{
    use HasFactory;
    public $table = 'lap_label_mati'; 
    protected $fillable = ['id','target_benih_id','tanggal_lapor','jumlah','label_mati','upload','keterangan'];
    public $timestamps = false;
    public function produksibenih()
    {
        return $this->belongsTo(ProduksiBenih::class,'target_benih_id');
    }
}
