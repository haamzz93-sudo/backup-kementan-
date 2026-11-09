<?php

namespace App\Models;

use App\Filament\Resources\PohonIndukResource\RelationManagers\NomorRegistrasiPohonRelationManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PohonInduk extends Model
{
    use HasFactory;
    public $table = 'pohon_induk'; 
    protected $fillable = ['id','nomor_induk','kode_awal','kode_akhir','urut_awal','urut_akhir','lembaga_id','pemilik_pohon_id','lembaga_serti_id','komoditas_id','varietas_id','kelas_benih_id','label_induk','tahun_tanam','tahun_regis','upload','upload_sk','jumlah','komkel_id','jenis_pemilik_id','location','latitude','longitude'];
    public $timestamps = false;
    protected $casts = [
        'dapat_lapor' => 'boolean',
        'location' => 'object'
    ];

    public function province()
    {
        return $this->belongsTo(Provinces::class,'provinces_id');
    }
    public function pemilik_pohon()
     {
         return $this->belongsTo(KepemilikanPohonInduk::class,'pemilik_pohon_id');
     }
    public function jenispemilik()
    {
        return $this->belongsTo(JenisPemilik::class,'jenis_pemilik_id');
    }
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }
    public function varietas()
    {
        return $this->belongsTo(Varietas::class,'varietas_id');
    }
    public function kel_komoditas()
    {
        return $this->belongsTo(KelKomoditas::class,'komkel_id');
    }
    public function kelasbenih()
    {
        return $this->belongsTo(KelasBenih::class,'kelas_benih_id');
    }
    public function nomorregistrasipohon()
    {
        return $this->hasMany(NomorRegistrasi::class,'pohon_induk_id');
    }
    public function kondisipohon()
    {
        return $this->hasMany(KondisiPohon::class,'pohon_induk_id');
    }
    public function lemser()
    {
        return $this->belongsTo(LembagaSertifikasi::class,'lembaga_serti_id');
    }
    
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
}
