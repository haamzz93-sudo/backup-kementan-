<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvincesSebaran extends Model
{
    use HasFactory;
    
    public $table = 'provinces'; 
    public $timestamps = false;

    public function varietassebar()
    {
        //ini artinya cek varietas sebar tergantung pada provinces_id, untuk apa di group by lagi di resourcenya?
        return $this->hasMany(VarietasSebar::class,'provinces_id');
    }
}
