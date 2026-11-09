<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
class ExportLembaga extends Model
{
    use HasFactory;
    protected $casts = [
        'location' => 'object',
        'jenis_kompetensi' => 'object'
    ];
    public $table = 'lembaga'; 
    protected $fillable = ['id','jenis_kompetensi','provinces_id','regencies_id','districts_id','villages_id','rt','rw','location','kodepos','nama_lembaga','lembaga_serti_id','jenis_lembaga_id','jenis_produsen_id','smm','sedia_bwg_pth','alamat','koordinat','latitude','longitude','nama_kepala','no_telp','lokasi_produksi_detail_id','lokasi_gudang_detail_id','status','upload','status_stok'];
    public $timestamps = false;
    public function provinces()
    {
        return $this->belongsTo(Provinces::class,'provinces_id');
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class,'regencies_id');
    }
    public function districts()
    {
        return $this->belongsTo(Districts::class,'districts_id');
    }
    public function villages()
    {
        return $this->belongsTo(Villages::class,'villages_id');
    }
    public function jenis_lembaga()
    {
        return $this->belongsTo(JenisLembaga::class,'jenis_lembaga_id');
    }
    public function jenis_produsen()
    {
        return $this->belongsTo(JenisProdusen::class,'jenis_produsen_id');
    }
    public function saranalembaga()
    {
        return $this->hasMany(SaranaLembaga::class,'lembaga_id');
    }
    public function lokasiproduksidetail()
    {
        return $this->hasMany(LokasiProduksiDetail::class,'lembaga_id');
    }
    public function lokasigudangdetail()
    {
        return $this->hasMany(LokasiGudangDetail::class,'lembaga_id');
    }
    public function sertifikatkompetensi()
    {
        return $this->hasMany(SertifikatKompetensi::class,'lembaga_id');
    }
    public function user()
    {
        return $this->hasMany(User::class,'lembaga_id')->join('model_has_roles','model_has_roles.model_id','users.id')->where('model_has_roles.role_id', 6);
    }
    public function user1()
    {
        return $this->hasMany(User::class,'lembaga_id')->join('model_has_roles','model_has_roles.model_id','users.id')->where('model_has_roles.role_id', 8);
    }
    
    
}
