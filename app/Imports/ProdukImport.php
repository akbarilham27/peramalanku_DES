<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;

class ProdukImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produk([
            'id_produk' => $row[0],
            'nama_produk' => $row[1],
            'jenis_produk' => $row[2],
            'harga_produk' => $row[3],
       ]);
    }
}
