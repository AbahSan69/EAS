@extends('layouts.main')
@section('content')
@include('layouts.topbar')
<main id="main-container" class="flex-grow-1">
  <div class="bg-body-extra-light">
    <div class="content content-boxed py-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
          <li class="breadcrumb-item">
            <a class="link-fx" href="{{ route('sp.dashboard') }}">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            Buat EA
          </li>
        </ol>
      </nav>
    </div>
  </div>
    <div class="content content-full py-6">
        <h1 class="h2 text-center mb-4">BUAT <br> ENTERPRISE ARCHITECTURE</h1>
        <div class="content">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <form action="{{ route('sp.ea.store_pts') }}" method="POST">
                  @csrf
                  <div class="block block-rounded">
                    <div class="block-header block-header-default">
                      <h3 class="block-title">Enterprise Architecture</h3>
                    </div>
                    <div class="block-content block-content-full">
                      <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                      <div class="mx-0 mx-md-6 mx-xl-8">
                        <div class="mb-4">
                          <label class="form-label" for="nama">Nama PTS</label>
                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Universitas Anda ..." required>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label">Jenis PTS</label>
                            <select class="form-select" id="jenis" name="jenis" required>
                              <option selected="" disabled>Pilih Jenis PTS</option>
                              <option value="Universitas">Universitas</option>
                              <option value="Institut">Institut</option>
                              <option value="SekolahTinggi">Sekolah Tinggi</option>
                              <option value="Politeknik">Politeknik</option>
                              <option value="Akademi">Akademi</option>
                            </select>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-end push">
                    <button type="submit" class="btn btn-sm btn-primary">
                      <i class="fa fa-check me-1"></i> Buat EA
                    </button>
                    
                  </div>
                </form>
              </div>
            </div>
          </div>
    </div>
</main>
@endsection
