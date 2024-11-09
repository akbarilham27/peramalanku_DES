<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPE;
use App\Models\Produk;
use App\Models\Transaksi;

class PeramalanController extends Controller
{
    public function index(Request $request)
    {
        $items = Produk::orderBy('nama_produk')->get();
        $alphaValues = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9];
        $bestAlpha = null;
        $minMae = PHP_INT_MAX;
        $bestValues = [];
        $produk = $request->id_produk;
        $bulanRamalan = $request->bulan_ramalan;
        $selectedAlpha = $request->alpha; // Menangkap input alpha yang dipilih pengguna
        $mae = 0; // Inisialisasi MAE

        if ($produk) {
            // Menghapus data PE sebelumnya untuk produk
            HasilPE::where('produk_id', $produk)->delete();

            if ($selectedAlpha) {
                // Jika pengguna memilih alpha, gunakan yang dipilih
                $bestValues = $this->calculate($produk, floatval($selectedAlpha), $bulanRamalan)['values'];
                $bestAlpha = $selectedAlpha;
                // Menghitung MAE menggunakan method calculateMae
                $mae = $this->calculateMae($bestValues);
            } else {
                // Jika tidak ada alpha yang dipilih, cari alpha terbaik secara default
                foreach ($alphaValues as $alpha) {
                    $currentValues = $this->calculate($produk, $alpha, $bulanRamalan);
                    $currentMae = $this->calculateMae($currentValues['values']); // Menghitung MAE dengan metode terpisah

                    if ($currentMae < $minMae) {
                        $minMae = $currentMae;
                        $bestAlpha = $alpha;
                        $bestValues = $currentValues['values'];
                        $mae = $currentMae;
                    }
                }
            }

            return view('Peramalan.peramalan', compact('items', 'alphaValues', 'bestValues', 'bestAlpha', 'mae'));
        }

        return view('Peramalan.peramalan', compact('items', 'alphaValues', 'bestValues', 'bestAlpha', 'mae'));
    }

    // Menghitung MAE secara terpisah seperti pada kode 1
    public function calculateMae($values)
    {
        $totalError = $maeCount = 0;

        foreach ($values as $value) {
            // Pastikan 'forecast' dan 'jumlah' valid
            if (!isset($value['forecast']) || !isset($value['jumlah']) || !is_numeric($value['forecast']) || !is_numeric($value['jumlah'])) {
                continue;
            }

            $jumlah = floatval($value['jumlah']);
            $forecast = floatval($value['forecast']);

            // Menghitung selisih absolut
            $totalError += abs($jumlah - $forecast);
            $maeCount++;
        }

        return ($maeCount > 0) ? ($totalError / $maeCount) : 0; // Mengembalikan MAE
    }

    // Menghitung forecasting tanpa MAE langsung di dalam metode ini, sama seperti kode 1
    public function calculate(int $item, float $alpha, int $bulanRamalan)
    {
        $data = Transaksi::with('dataproduk')
            ->selectRaw('MONTH(tanggal_pengajuan) as bulan, YEAR(tanggal_pengajuan) as tahun, SUM(jumlah_penjualan) as jumlah')
            ->where('id_produk', $item)
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get()
            ->toArray();

        $values = [];
        $stSebelumnya = 0;
        $sstSebelumnya = 0;

        // Inisialisasi at dan bt
        $at = 0;
        $bt = 0;
        $prevAt = 0; // Menyimpan nilai at untuk forecast
        $prevBt = 0; // Menyimpan nilai bt untuk forecast

        foreach ($data as $key => $transaksi) {
            $jumlah = isset($transaksi['jumlah']) ? floatval($transaksi['jumlah']) : 0;

            // Inisialisasi nilai untuk bulan pertama
            if ($key === 0) {
                $st = $jumlah;
                $sst = $jumlah;
            } else {
                $st = $alpha * $jumlah + (1 - $alpha) * $stSebelumnya;
                $sst = $alpha * $st + (1 - $alpha) * $sstSebelumnya;
            }

            // Hitung at dan bt untuk iterasi saat ini
            $at = (2 * $st) - $sst;
            $bt = ($alpha / (1 - $alpha)) * ($st - $sst);

            // Menghitung forecast menggunakan nilai at dan bt dari iterasi sebelumnya
            if ($key === 0) {
                $forecast = $jumlah; // Atau 0, tergantung logika bisnis Anda
            } else {
                $forecast = max(0, $prevAt + $prevBt);
            }

            $values[] = [
                'bulan' => isset($transaksi['bulan']) ? $transaksi['bulan'] : null,
                'tahun' => isset($transaksi['tahun']) ? $transaksi['tahun'] : null,
                'jumlah' => $jumlah,
                'st' => $st,
                'sst' => $sst,
                'at' => $at,
                'bt' => $bt,
                'forecast' => $forecast,
            ];

            // Update nilai at dan bt untuk iterasi berikutnya
            $prevAt = $at;
            $prevBt = $bt;

            // Update nilai sebelumnya
            $stSebelumnya = $st;
            $sstSebelumnya = $sst;
        }

        // Forecasting untuk periode masa depan
        for ($i = 0; $i < $bulanRamalan; $i++) {
            $nextSt = $alpha * 0 + (1 - $alpha) * $stSebelumnya;
            $nextSst = $alpha * $nextSt + (1 - $alpha) * $sstSebelumnya;
            $nextAt = (2 * $nextSt) - $nextSst;
            $nextBt = ($alpha / (1 - $alpha)) * ($nextSt - $nextSst);
            $nextForecast = max(0, $prevAt + $prevBt); // Menggunakan nilai at dan bt dari iterasi sebelumnya

            $bulanTerakhir = end($values)['bulan'];
            $tahunTerakhir = end($values)['tahun'];

            if ($bulanTerakhir == 12) {
                $bulanTerbaru = 1;
                $tahunTerbaru = $tahunTerakhir + 1;
            } else {
                $bulanTerbaru = $bulanTerakhir + 1;
                $tahunTerbaru = $tahunTerakhir;
            }

            $values[] = [
                'bulan' => $bulanTerbaru,
                'tahun' => $tahunTerbaru,
                'jumlah' => 0, // Karena ini adalah prediksi
                'st' => $nextSt,
                'sst' => $nextSst,
                'at' => $nextAt,
                'bt' => $nextBt,
                'forecast' => $nextForecast,
            ];

            // Update nilai sebelumnya untuk forecasting berikutnya
            $stSebelumnya = $nextSt;
            $sstSebelumnya = $nextSst;
            $prevAt = $nextAt;
            $prevBt = $nextBt;
        }

        return [
            'values' => $values,
        ];
    }
}


    // protected function saveForecastValues($produk, $values, $alpha)
    // {
    //     foreach ($values as $value) {
    //         HasilPE::create([
    //             'produk_id' => $produk,
    //             'bulan' => $value['bulan'],
    //             'tahun' => $value['tahun'],
    //             'jumlah' => $value['jumlah'],
    //             'st' => $value['st'],
    //             'sst' => $value['sst'],
    //             'at' => $value['at'],
    //             'bt' => $value['bt'],
    //             'forecast' => $value['forecast'],
    //             'alpha' => $alpha,
    //         ]);
    //     }
    // }

