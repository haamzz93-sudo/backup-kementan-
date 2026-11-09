<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanStokProdusen extends Model
{
    use HasFactory;
    public $table = 'stok_op'; 
    public $timestamps = false;
}
