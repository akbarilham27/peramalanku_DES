<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPE extends Model
{
    use HasFactory;

    protected $table = 'hasil_p_e';

    protected $fillable = [
        'produk_id',
        'bulan',
        'tahun',
        'jumlah',
        'st',
        'sst',
        'at',
        'bt',
        'forecast',
        'pe',
        'alpha',
    ];
}
