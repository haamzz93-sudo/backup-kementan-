<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProdusen extends Model
{
    use HasFactory;
    public $table = 'jenis_produsen'; 
    protected $fillable = ['nama_jenis','kode'];
    public $timestamps = false;
    public function targetbenih()
    {
        return $this->hasMany(TargetBenih::class);
    }
    
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class);
    }
}
