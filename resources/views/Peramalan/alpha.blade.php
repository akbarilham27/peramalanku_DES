@extends('layout.admin')
@section('content')
<div class="content-wrapper" style="min-height: 690.2px;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Peramalan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Peramalan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="pull-left">
                                <!-- <strong class="card-title">DATA SALES</strong> -->
                            </div>
                            <div class="pull-right">
                                <form id="peramalanForm" action="{{ route('alpha.index') }}" method="GET">
                                    <legend>Data Peramalan DES</legend>


                                    <div class="form-group">
                                        <label for="id_produk">Nama Produk</label>
                                        <select class="form-control" name="id_produk">
                                            @foreach ($items as $item)
                                            <option value="{{ $item->id_produk }}" {{ request()->id_produk == $item->id_produk ? 'selected' : '' }}>
                                                {{ $item->nama_produk }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="bulan_ramalan">Ramal Bulan Kedepan</label>
                                        <select class="form-control" name="bulan_ramalan">
                                            <option value="1" {{ request()->bulan_ramalan == '1' ? 'selected' : '' }}>1 Bulan</option>
                                            <option value="2" {{ request()->bulan_ramalan == '2' ? 'selected' : '' }}>2 Bulan</option>
                                            <option value="3" {{ request()->bulan_ramalan == '3' ? 'selected' : '' }}>3 Bulan</option>
                                            <option value="4" {{ request()->bulan_ramalan == '4' ? 'selected' : '' }}>4 Bulan</option>
                                            <option value="5" {{ request()->bulan_ramalan == '5' ? 'selected' : '' }}>5 Bulan</option>
                                            <option value="6" {{ request()->bulan_ramalan == '6' ? 'selected' : '' }}>6 Bulan</option>
                                        </select>
                                    </div>



                                    <div class="form-group">
                                        <label for="alpha">Pilih Alpha</label>
                                        <select class="form-control" name="alpha">
                                            <option value="">Otomatis (Alpha Terbaik)</option>
                                            @foreach ($alphaValues as $alpha)
                                            <option value="{{ $alpha }}" {{ request()->alpha == $alpha ? 'selected' : ''
                                                }}>
                                                {{ $alpha }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Hitung Peramalan</button>
                                </form>

                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div>
                                <strong>Mean Absolute Error (MAE): </strong> {{ number_format($mae, 2) }}
                            </div>
                            <div>
                                <strong>Alpha Value Used: </strong> {{ $bestAlpha ? number_format($bestAlpha, 1) : 'N/A'
                                }}
                            </div>


                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Tahun</th>
                                        <th scope="col">Bulan</th>
                                        <th scope="col">Aktual</th>
                                        <th scope="col">A'</th>
                                        <th scope="col">A''</th>
                                        <th scope="col">at</th>
                                        <th scope="col">bt</th>
                                        <th scope="col">Forecast</th>
                                        <th scope="col">Error MAE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestValues as $value)
                                    <tr>
                                        <td>{{ $value['tahun'] }}</td>
                                        <td>{{ $value['bulan'] }}</td>
                                        <td>{{ $value['jumlah'] }}</td>
                                        <td>{{ $value['st'] }}</td>
                                        <td>{{ $value['sst'] }}</td>
                                        <td>{{ $value['at'] }}</td>
                                        <td>{{ $value['bt'] }}</td>
                                        <td>{{ $value['forecast'] }}</td>
                                        <td>{{ abs($value['jumlah'] - $value['forecast']) }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cards-categories">
        <h4 style="padding-left: 10px;">Grafik Peramalan Penjualan Alat Musik</h4>
    </div>

    <div class="chart-container" style="position: relative; height: 50vh;">
        <canvas id="myChart" style="width: 82%;"></canvas>
    </div>

    <div id="bestAlphaResult" style="margin-top: 20px;">
        <!-- Tempat untuk menampilkan hasil peramalan terbaik -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var actualData = {!! json_encode(array_column($bestValues, 'jumlah')) !!};
        var forecastData = {!! json_encode(array_column($bestValues, 'forecast')) !!};
        forecastData[0] = null;
        actualData.pop();

        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_map(function($value) {
                    return $value['tahun'] . '-' . str_pad($value['bulan'], 2, '0', STR_PAD_LEFT);
                }, $bestValues)) !!},
                datasets: [
                    {
                        label: 'Actual',
                        data: actualData,
                        borderColor: 'red',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Forecast',
                        data: forecastData,
                        borderColor: 'blue',
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        labels: {!! json_encode(array_map(function($value) {
                            return $value['tahun'] . '-' . str_pad($value['bulan'], 2, '0', STR_PAD_LEFT);
                        }, $bestValues)) !!}
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
@endsection


















































































































