
@extends('layout.admin')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1 class="m-0">Tambah Data User</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                      <li class="breadcrumb-item active">Tambah User</li>
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
                  <form action="/insertuser" method="POST" enctype="multipart/form-data">
                    @csrf
                      <div class="mb-3">
                          <label for="" class="form-label">Nama User</label>
                          <input type="text" name="name" class="form-control">
                          <div id="name" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Email</label>
                          <input type="email" name="email" class="form-control">
                          <div id="email" class="form-text"></div>
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control">
                          <div id="password" class="form-text"></div>
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