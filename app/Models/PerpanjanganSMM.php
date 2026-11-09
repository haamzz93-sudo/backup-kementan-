<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerpanjanganSMM extends Model
{
    use HasFactory;
    public $table = 'subchild_smm'; 
    protected $fillable = ['id','child_smm_id','no_perpanjangan','upload_perpanjangan','tgl_perpanjangan','tgl_berlaku'];
    public $timestamps = false;
    public function sertifikasikompetensi()
    {
        return $this->belongsTo(SertifikasiKompetensi::class,'child_smm_id');
    }
}
