@extends('layout.admin')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1 class="m-0">Update Data Produk</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                      <li class="breadcrumb-item active">Update Produk</li>
                  </ol>
              </div><!-- /.col -->
          </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
<div class="container mt-5 center">
  <div class="row justify-content-center">
    <div class="col-8">
      <div class="card">
        <div class="card-body">
          <form action="/updateproduk/{{ $data_produk->id_produk }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">ID Produk</label>
              <input type="text" name="id_produk" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp" value="{{ $data_produk->id_produk }}">
              <div id="id_produk" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
              <input type="text" name="nama_produk" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp" value="{{ $data_produk->nama_produk }}">
              <div id="nama_produk" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Jenis Produk</label>
              <input type="text" name="jenis_produk" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp" value="{{ $data_produk->jenis_produk }}">
              <div id="jenis_produk" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Harga Produk</label>
              <input type="text" name="harga_produk" class="form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp" value="{{ $data_produk->harga_produk }}">
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
@endsection