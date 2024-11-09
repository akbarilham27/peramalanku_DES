<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produks')->insert([
            'id_produk' => 'BRGP00020',
            'nama_produk' => 'Neutrik Jack NC3FXX',
            'jenis_produk'=>'Jack Mikrofon',
            'harga_produk'=>'63.680'
        ]);
    }
}
