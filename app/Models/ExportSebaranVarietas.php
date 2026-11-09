<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
trait GroupByVarietas
{
    public function scopeGroupByVarietas($query)
    {
        return $query->groupBy('varietas_id','regencies_id');
    }
}
class ExportSebaranVarietas extends Model
{
    use HasFactory, GroupByVarietas;
    public $table = 'varietas_sebar'; 
    public $timestamps = false;

    public function varietas()
    {
        return $this->belongsTo(Varietas::class);
    }
    
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class,'komoditas_id');
    }

    public function kelkomoditas()
    {
        return $this->belongsTo(KelKomoditas::class,'komkel_id');
    }

    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }
    public function regencies()
    {
        return $this->belongsTo(Regencies::class);
    }
}
