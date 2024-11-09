<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk'; // Primary key

    public $incrementing = false; // Non-increment key
    protected $keyType = 'string'; // Primary key berupa string

    protected $guarded = []; // Semua field bisa diisi (mass assignable)
}

