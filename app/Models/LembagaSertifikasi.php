<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembagaSertifikasi extends Model
{
    use HasFactory; 
    protected $casts = [
        'location' => 'object',
    ];
    public $table = 'lembaga'; 
    protected $fillable = ['id','provinces_id','regencies_id','districts_id','villages_id','rt','rw','kodepos','nama_lembaga','lembaga_serti_id','jenis_lembaga_id','jenis_produsen_id','smm','sedia_bwg_pth','alamat','koordinat','latitude','longitude','nama_kepala','no_telp','lokasi_produksi_detail','lokasi_gudang_detail','status','upload','logo','status_stok','location','stempel'];
    public $timestamps = false;
    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class);
    }
    public function districts()
    {
        return $this->belongsTo(Districts::class);
    }
    public function villages()
    {
        return $this->belongsTo(Villages::class);
    }
    public function saranalembaga()
    {
        return $this->hasMany(SaranaLembaga::class,'lembaga_id');
    }
    public function jenis_lembaga()
    {
        return $this->belongsTo(JenisLembaga::class,'jenis_lembaga_id');
    }
    public function jenis_produsen()
    {
        return $this->belongsTo(JenisProdusen::class,'jenis_produsen_id');
    }
    public function akreditasi()
    {
        return $this->hasMany(Akreditasi::class,'lembaga_id');
    }
    public function user2()
    {
        return $this->hasMany(User::class,'lembaga_id')->join('model_has_roles','model_has_roles.model_id','users.id')->where('model_has_roles.role_id', 7);
    }
}
