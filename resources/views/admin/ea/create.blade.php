@extends('layouts.main')
@section('content')
<main id="main-container" class="flex-grow-1">
    <div class="content content-full py-6">
        <h1 class="h2 text-center mb-4">BUAT <br> ENTERPRISE ARCHITECTURE</h1>
        <div class="content">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <form action="{{ route('admin.ea.store_pts') }}" method="POST">
                  @csrf
                  <div class="block block-rounded">
                    <div class="block-header block-header-default">
                      <h3 class="block-title">Enterprise Architecture</h3>
                    </div>
                    <div class="block-content block-content-full">
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
