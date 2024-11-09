<?php

namespace App\Http\Controllers;

use App\Models\HasilPE;
use App\Models\Produk;
use Illuminate\Http\Request;

class HasilPEController extends Controller
{
    public function index(Request $request)
    {
        $produk = $request->id_produk;
        $tahun = $request->tahun;

        $items = null;

        $products = Produk::all();

        if ($produk && $tahun) {
            $items = HasilPE::where('produk_id', $produk)->where('tahun', $tahun)->get();
        }

        return view('hasil.grafik_evaluasi', compact('items', 'products'));
    }
}
