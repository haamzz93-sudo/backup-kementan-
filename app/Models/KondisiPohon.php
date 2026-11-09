<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiPohon extends Model
{
    use HasFactory;
    public $table = 'child_laporan_pohon'; 
    protected $fillable = ['id','taksiran_perbanyakan','satuan','pohon_induk_id','child_pohon_induk_id','tanggal_lapor','mati','tambah','jml_akhir','upload','keterangan','kapasitas'];
    public $timestamps = false;
    protected $casts = [
        'taksiran_perbanyakan' => 'array'
    ];
    public function pohoninduk()
    {
        return $this->belongsTo(PohonInduk::class,'pohon_induk_id');
    }
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class);
    }
    public function nomorregistrasi()
    {
        return $this->belongsTo(NomorRegistrasi::class,'child_pohon_induk_id');
    }
}
