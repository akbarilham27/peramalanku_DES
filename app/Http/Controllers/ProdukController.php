<?php

namespace App\Http\Controllers;

use App\Imports\ProdukImport;
use Database\Seeders\ProdukSeeder;
use Illuminate\Http\Request;
use App\Models\produk;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ProdukController extends Controller
{
    public function index()
    {
        $data_produk = produk::all();
        return view('produk.produk', compact('data_produk'));
    }

    public function tambahproduk()
    {
        return view('produk.tambahproduk');
    }
    public function insertproduk(Request $request)
    {
        produk::create($request->all());
        return redirect()->route('produk')->with('success', 'Data Berhasil Di Tambah');
    }
    public function tampilkanproduk($id_produk)
    {
        $data_produk = Produk::where('id_produk', $id_produk)->first();

        return view('produk.tampilproduk', compact('data_produk'));
    }
    public function updateproduk(Request $request, $id_produk)
    {
        $data_produk = Produk::where('id_produk', $id_produk)->first();
        $data_produk->update($request->all());
        return redirect()->route('produk')->with('success', 'Data Berhasil Di Update');
    }
    public function deleteproduk(Request $request, $id_produk)
    {
        $data_produk = Produk::where('id_produk', $id_produk)->first();
        $data_produk->delete();
        return redirect()->route('produk')->with('success', 'Data Berhasil Di Delete');
    }
    public function exportPDF()
    {
        $data_produk = Produk::all();
        $pdf = Pdf::loadView('produk.produk-pdf', compact('data_produk'));
        return $pdf->stream('data-produk.pdf');
        // return $pdf->download('data-produk.pdf');
    }

    public function importprodukexel (Request $request)
    {
        $data_produk = $request->file('file');
        $namafile = $data_produk ->getClientOriginalName();
        $data_produk->move ('ProdukImport', $namafile);
        Excel::import(new ProdukImport, \public_path('/ProdukImport/'.$namafile));
        return \redirect()->back();
    }
}
