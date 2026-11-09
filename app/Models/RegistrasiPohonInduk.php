<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiPohonInduk extends Model
{
    use HasFactory;
    public $table = 'child_pohon_induk';
    public function pohoninduk()
    {
        return $this->belongsTo(PohonInduk::class,'pohon_induk_id');
    }
}
