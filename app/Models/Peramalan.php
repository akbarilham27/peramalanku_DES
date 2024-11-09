<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peramalan extends Model
{
    use HasFactory;
    protected $table = 'peramalan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['tahun', 'bulan', 'nama_produk', 'jumlah', 'pe', 'alpa', 'aktual'];
    protected $hidden = ['created_at', 'updated_at'];

}
