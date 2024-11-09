<?php

namespace App\Imports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;

class TransaksiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Transaksi([
            'id_transaksi' => $row[0],
            'id_produk' => $row[1],
            'nama_produk' => $row[2],
            'jumlah_penjualan'=> $row[3],
            'tanggal_pengajuan' => $row[4],
        ]);
    }
}
