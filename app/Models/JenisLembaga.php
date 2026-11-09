<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLembaga extends Model
{
    use HasFactory;
    public $table = 'jenis_lembaga'; 
    protected $fillable = ['nama_jenis'];
    public $timestamps = false;
    
    public function produsenbenih()
    {
        return $this->belongsTo(ProdusenBenih::class);
    }
    public function targetbenih()
    {
        return $this->hasMany(TargetBenih::class);
    }
}
