<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormLabel extends Model
{
    use HasFactory;
    protected $casts = [
        'json_form' => 'json',
    ];
    public $table = 'form_label'; 
    protected $fillable = ['id','golongan_id','cara_id','json_form'];
    public $timestamps = false;
    
    public function golongan() {
        return $this->belongsTo(Golongan::class,'golongan_id');
    }
    public function cara(){
        return $this->belongsTo(Cara::class,'cara_id');
    }
}
