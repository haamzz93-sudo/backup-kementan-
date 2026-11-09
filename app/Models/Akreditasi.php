<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    use HasFactory;
    public $table = 'lembaga_sertifikasi'; 
    protected $fillable = ['id','lembaga_id','no_akre','tanggal_awal','tanggal_akhir','upload_serti'];
    public $timestamps = false;

    public function lembagasertifikasi()
    {
        return $this->belongsTo(LembagaSertifikasi::class,'lembaga_id');
    }
}
