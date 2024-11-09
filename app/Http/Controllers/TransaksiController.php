<?php

namespace App\Http\Controllers;
use App\Models\transaksi;
use App\Models\produk;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\TransaksiImport;

class TransaksiController extends Controller
{
    public function transaksi()
    {
        $data_transaksi = Transaksi::with('produk')->get();
        return view('transaksi.transaksi', compact('data_transaksi'));
    }

    public function tambahtransaksi()
    {
        $data_produk = produk::all();
        $data_transaksi = transaksi::all();
        return view('transaksi.tambahtransaksi', compact('data_produk','data_transaksi'));
    }
    public function inserttransaksi(Request $request)
    {
        transaksi::create($request->all());
        return redirect()->route('transaksi')->with('success', 'Data Berhasil Di Tambah');
    }
    public function tampilkantransaksi($id_transaksi)
    {
        $data_produk = Produk::all();
        $data_transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
        return view('transaksi.tampiltransaksi', compact('data_transaksi','data_produk'));
    }
    public function updatetransaksi(Request $request, $id_transaksi)
    {
        $data_transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
        $data_transaksi->update($request->all());
        return redirect()->route('transaksi')->with('success', 'Data Berhasil Di Update');
    }
    public function deletetransaksi(Request $request, $id_transaksi)
    {
        $data_transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
        $data_transaksi->delete();
        return redirect()->route('transaksi')->with('success', 'Data Berhasil Di Delete');
    }
   
    public function importtransaksiexel (Request $request)
    {
        $data_transaksi = $request->file('file');
        $namafile = $data_transaksi ->getClientOriginalName();
        $data_transaksi->move ('TransaksiImport', $namafile);
        Excel::import(new TransaksiImport, \public_path('/TransaksiImport/'.$namafile));
        return \redirect()->back();
    }

    public function deletesemuatransaksi ()
    {
        Transaksi::truncate();
        return redirect()->back();
    }
}
