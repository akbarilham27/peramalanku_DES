
@extends('layout.admin')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1 class="m-0">Tambah Data Produk</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                      <li class="breadcrumb-item active">Tambah Produk</li>
                  </ol>
              </div><!-- /.col -->
          </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
<div class="container mt-10 center">
  <div class = "row justify-content-center">
      <div class="col-8">
          <div class="card">
              <div class="card-body">
                  <form action="/insertproduk" method="POST" enctype="multipart/form-data">
                    @csrf
                      <div class="mb-3">
                        <label for="" class="form-label">ID Produk</label>
                        <input type="text" name="id_produk" class="form-control" >
                        <div id="id_produk" class="form-text"></div>
                      </div>
                      <div class="mb-3">
                          <label for="" class="form-label">Nama Produk</label>
                          <input type="text" name="nama_produk" class="form-control">
                          <div id="nama_produk" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Jenis Produk</label>
                          <input type="text" name="jenis_produk" class="form-control">
                          <div id="jenis_produk" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Harga Produk</label>
                          <input type="text" name="harga_produk" class="form-control">
                          <div id="harga_produk" class="form-text"></div>
                        </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
              </div>
          </div>
      </div>
  </div>
  
  {{-- <button type="button" class="btn btn-outline-secondary">Tambah +</button> --}}
 
</div>
</div>

<!-- Bootstrap JS (Opsional, untuk komponen interaktif) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection