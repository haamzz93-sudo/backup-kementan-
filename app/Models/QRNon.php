<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRNon extends Model
{
    use HasFactory;
    public $table = 'label_non'; 
    protected $fillable = ['id','sertifikasi_non_id','child_smm','no_batch','jumlah_qr','data','keterangan'];
    public $timestamps = false;
    protected $casts = [
        'child_smm' => 'json',
        'data' => 'json'
    ];
    
    public function sertifikasi()
    {
        return $this->belongsTo(SertifikasiNonAPBN::class,'sertifikasi_non_id');
    }
    public function smm()
    {
        return $this->hasMany(SertifikatKompetensi::class,'id','child_smm','no_label');
    }
}
