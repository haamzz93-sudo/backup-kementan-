<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulasi extends Model
{
    use HasFactory;
    
    public $table = 'regulasi';
    protected $fillable = ['id','lembaga_id','lingkup','nama_regulasi','upload','keterangan'];
    public $timestamps = false;
    public function lembaga()
    {
        return $this->belongsTo(ProdusenBenih::class,'lembaga_id');
    }
}
