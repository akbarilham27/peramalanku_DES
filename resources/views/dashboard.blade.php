@extends('layout.admin')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Informasi Kartu Statistik -->
  <div class="row">
    <div class="col-lg-4 col-md-8 mb-4">
      <div class="info-box shadow-sm" style="min-height: 110px">
        <span class="info-box-icon bg-secondary elevation-1" style="min-width: 110px"><i class="fas fa-cubes"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah Produk</span>
          <span class="info-box-number">{{ $jumlahProduk }}</span>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-8 mb-4">
      <div class="info-box shadow-sm" style="min-height: 110px">
        <span class="info-box-icon bg-success elevation-1" style="min-width: 110px"><i
            class="fas fa-chart-line"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah Transaksi</span>
          <span class="info-box-number">{{ $jumlahTransaksi }}</span>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-8 mb-4">
      <div class="info-box shadow-sm" style="min-height: 110px">
        <span class="info-box-icon bg-warning elevation-1" style="min-width: 110px"><i
            class="fas fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah User</span>
          <span class="info-box-number">{{ $jumlahUser }}</span>
        </div>
      </div>
    </div>
  </div>

 

  

  <!-- Form Pemilihan Produk -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form id="peramalanForm" action="" method="get" class="form-inline">
        <label for="id_produk" class="mr-2">Pilih Produk</label>
        <select class="form-control mr-3" name="id_produk">
          @foreach ($items as $item)
          <option value="{{ $item->id_produk }}" {{ request()->id_produk == $item->id_produk ? 'selected' : '' }}>
            {{ $item->nama_produk }}
          </option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Tampilkan Data</button>
      </form>
    </div>
  </div>

  <!-- Konten Grafik Penjualan -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Grafik Penjualan Tahun Pertama -->
        <div class="col-lg-6 col-md-12">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0">Penjualan Tahun 2022</h5>
            </div>
            <div class="card-body">
              <div class="chart-container" style="height: 60vh;">
                <canvas id="myChart1"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Grafik Penjualan Tahun Berikutnya -->
        <div class="col-lg-6 col-md-12">
          <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
              <h5 class="card-title mb-0">Penjualan Tahun 2023-2024</h5>
            </div>
            <div class="card-body">
              <div class="chart-container" style="height: 60vh;">
                <canvas id="myChart2"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Total Jumlah Data Penjualan Produk</h5>
          <i class="fas fa-chart-bar fa-lg"></i>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-primary">
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col">Nama Produk</th>
                  <th scope="col" class="text-center">Jumlah Penjualan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center">1</td>
                  <td>Neutrik Jack NC3FXX</td>
                  <td class="text-center">{{ $transNeutrikJackNC3FXX }}</td>
                </tr>
                <tr>
                  <td class="text-center">2</td>
                  <td>Neutrik Jack NC3MXX</td>
                  <td class="text-center">{{ $transNeutrikJackNC3MXX }}</td>
                </tr>
                <tr>
                  <td class="text-center">3</td>
                  <td>Krezt Jack Speakon TSC-033</td>
                  <td class="text-center">{{ $transKreztJackSpeakonTSC }}</td>
                </tr>
                <tr>
                  <td class="text-center">4</td>
                  <td>Focus Jack Mic Male GCA 700/N3P</td>
                  <td class="text-center">{{ $transFocusJackMicMaleGCA }}</td>
                </tr>
                <tr>
                  <td class="text-center">5</td>
                  <td>D Addario S/G Acc. EJ-10 X-Lite</td>
                  <td class="text-center">{{ $transDAddarioSGAccEJXLite }}</td>
                </tr>
                <tr>
                  <td class="text-center">6</td>
                  <td>D Addario S/G Reguler EXL-120</td>
                  <td class="text-center">{{ $transDAddarioSGRegulerEXL }}</td>
                </tr>
                <tr>
                  <td class="text-center">7</td>
                  <td>Centurion CLED 543X RGBW</td>
                  <td class="text-center">{{ $transCenturionCLEDXRGBW }}</td>
                </tr>
                <tr>
                  <td class="text-center">8</td>
                  <td>SREXACT Jack RCA SP116G-C81-BK</td>
                  <td class="text-center">{{ $transSREXACTJackRCASP116G }}</td>
                </tr>
                <tr>
                  <td class="text-center">9</td>
                  <td>SREXACT Jack Male SVP555V-BK-PG</td>
                  <td class="text-center">{{ $transSREXACTJackMaleSVP555V }}</td>
                </tr>
                <tr>
                  <td class="text-center">10</td>
                  <td>Srexact Jack Akai Mono SP102X-POG</td>
                  <td class="text-center">{{ $transSrexactJackAkaiMonoSP102X }}</td>
                </tr>
                <tr>
                  <td class="text-center">11</td>
                  <td>Srexact Jack Stereo Mini SP110AM-G-C81-BK</td>
                  <td class="text-center">{{ $transSrexactJackStereoMiniSP110AM }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer text-muted text-end">
          <small>Data diperbarui secara real-time</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Menyertakan jQuery dan Chart.js untuk membuat grafik -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // Mendapatkan data penjualan dari database dalam bentuk JSON
    const dataPenjualan = {!! json_encode(array_column($bestValues, 'jumlah')) !!}; 
    // Mendapatkan label untuk sumbu x (bulan-tahun)
    const labelsPenjualan = {!! json_encode(array_map(function($value) {
      return strval($value['tahun']) . '-' . str_pad($value['bulan'], 2, '0', STR_PAD_LEFT);
    }, $bestValues)) !!};
  
    // Memisahkan data penjualan menjadi dua bagian, yaitu tahun pertama dan kedua
    const dataTahunPertama = dataPenjualan.slice(0, 12); // 12 bulan pertama
    const labelsTahunPertama = labelsPenjualan.slice(0, 12); // Label untuk tahun pertama
    const dataTahunKedua = dataPenjualan.slice(12, 25); // 12 bulan kedua
    const labelsTahunKedua = labelsPenjualan.slice(12, 25); // Label untuk tahun kedua
  
    // Mencari nilai penjualan tertinggi di tahun pertama untuk dijadikan batas maksimum
    const maxPenjualanTahunPertama = Math.max(...dataTahunPertama); // Nilai maksimum di tahun pertama
  
    // Membatasi nilai di tahun pertama agar tidak melebihi nilai maksimum (maxPenjualanTahunPertama)
    const dataTerbatasTahunPertama = dataTahunPertama.map(value => 
      value > maxPenjualanTahunPertama ? maxPenjualanTahunPertama : value // Membatasi nilai
    );
  
    // Fungsi untuk mengatur konfigurasi grafik Chart.js
    const chartConfig = (ctx, labels, data, label, color) => {
      return new Chart(ctx, {
        type: 'line', // Tipe grafik: line
        data: {
          labels: labels, // Label sumbu x
          datasets: [{
            label: label, // Label dataset
            data: data, // Data penjualan
            backgroundColor: color.background, // Warna latar belakang
            borderColor: color.border, // Warna garis grafik
            borderWidth: 2,
            fill: false // Grafik tidak diisi (hanya garis)
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true, // Tampilkan legenda
              labels: { color: '#333' }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              suggestedMax: maxPenjualanTahunPertama, // Membatasi sumbu y pada grafik pertama
              title: { display: true, text: 'Jumlah Penjualan', color: '#333' }
            }
          }
        }
      });
    };
  
    // Membuat grafik untuk "Penjualan Tahun Pertama" dengan data yang dibatasi pada nilai maksimum
    chartConfig(
      document.getElementById('myChart1').getContext('2d'),
      labelsTahunPertama, dataTerbatasTahunPertama, // Menggunakan data terbatas pada grafik pertama
      'Penjualan Tahun 2022',
      { background: 'rgba(255, 99, 132, 0.2)', border: 'rgba(255, 99, 132, 1)' }
    );
  
    // Membuat grafik untuk "Penjualan Tahun Berikutnya" dengan data asli
    chartConfig(
      document.getElementById('myChart2').getContext('2d'),
      labelsTahunKedua, dataTahunKedua, // Menggunakan data asli pada grafik kedua
      'Penjualan Tahun Berikutnya',
      { background: 'rgba(54, 162, 235, 0.2)', border: 'rgba(54, 162, 235, 1)' }
    );
  </script>


  @endsection