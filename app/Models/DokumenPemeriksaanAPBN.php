<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPemeriksaanAPBN extends Model
{
    use HasFactory;
    public $table = 'dok_pemeriksaan_apbn'; 
    protected $fillable = ['id','target_benih_id','jenis_dokumen','upload_dokumen','keterangan','created_at','updated_at','no_induk_sertifikasi'];
    public $timestamps = true;
    public function targetbenih()
    {
        return $this->belongsTo(TargetBenih::class,'target_benih_id');
    }
}
