@extends('layout.admin')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Transaksi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Transaksi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container mt-5">

        <!-- Tombol Tambah -->
        <a href="\tambahtransaksi" class="btn btn-outline-secondary mb-3">Tambah +</a>
        
       
        
        
        <!-- Alert Pesan -->
        @if($message = Session::get('success'))
        <div class="alert alert-light" role="alert">
            {{ $message }}
        </div>
        @endif

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Import Data
        </button>
        {{-- <a href="{{ route('exportpdf') }}" class="btn btn-danger mb-3">Export PDF</a> --}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Import Data Transaksi</h1>
                        <button type="button" class="fa fa-times-circle text-danger" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/importtransaksiexel" method="POST" enctype="multipart/form-data">
                            @csrf
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="file" name="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <!-- Input Search -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control"
                    placeholder="Cari Transaksi berdasarkan ID Transaski, ID Produk atau Nama Produk">
            </div>
        
        <form id="hapusSemuaForm" action="{{ route('deletesemuatransaksi') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline-danger mb-3" onclick="return hapusSemuaTransaksi()">Hapus Semua</button>
        </form>
    </div>
        <!-- Tabel Data Transaksi -->
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID Transaksi</th>
                    <th scope="col">ID Produk</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Tanggal Pengajuan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="transaksiTableBody">
                @foreach ($data_transaksi as $transaksi)
                <tr>
                    <th scope="row">{{ $transaksi->id_transaksi }}</th>
                    <td>{{ $transaksi->id_produk }}</td>               
                    <td>{{ $transaksi->produk->nama_produk }}</td>
                    <td>{{ $transaksi->jumlah_penjualan }}</td>
                    <td>{{ $transaksi->tanggal_pengajuan }}</td>
                    <td>
                        <a href="tampilkantransaksi/{{ $transaksi->id_transaksi }}"
                            class="btn btn-outline-warning">Edit</a>
                        <a href="javascript:void(0)" class="btn btn-outline-danger"
                            onclick="hapusTransaksi('{{ $transaksi->id_transaksi  }}')">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- {{ $data_transaksi->links() }} --}}
    </div>

    <!-- Bootstrap JS (Opsional, untuk komponen interaktif) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi hapus transaksi dengan SweetAlert
        function hapusTransaksi(id_transaksi) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil dihapus.',
                        'success'
                    ).then(() => {
                        window.location.href = `deletetransaksi/${id_transaksi}`;
                    });
                }
            });
        }
        function hapusSemuaTransaksi() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil dihapus.',
                        'success'
                    ).then(() => {
                        window.location.href = `deletesemuatransaksi`;
                    });
                }
            }); return false;
        }
    
        // Fungsi untuk filter pencarian
        document.getElementById('searchInput').addEventListener('input', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#transaksiTableBody tr');
    
            rows.forEach(row => {
                let idTransaksi = row.cells[0].textContent.toLowerCase();
                let idProduk = row.cells[1].textContent.toLowerCase();
                let namaProduk = row.cells[2].textContent.toLowerCase();
    
                if (idTransaksi.includes(filter) || idProduk.includes(filter) || namaProduk.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</div>































@endsection