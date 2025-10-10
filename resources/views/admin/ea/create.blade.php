@extends('layouts.main')
@section('content')
@include('layouts.topbar')
<main id="main-container" class="flex-grow-1">
    <div class="bg-body-extra-light">
        <div class="content content-boxed py-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-alt">
              <li class="breadcrumb-item">
                <a class="link-fx" href="{{ route('admin.dashboard_admin') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                Enterprise Architecture
              </li>
            </ol>
          </nav>
        </div>
      </div>

    <div class="content">
            <form action="{{ route('admin.ea.create') }}" method="GET">
                <div class="input-group">
                  <input type="text" class="form-control" name="search" placeholder="Cari Perguruan Tinggi" value="{{ request()->input('search') }}">
                  <!-- Search Icon as Submit Button -->
                  <button class="input-group-text btn btn-primary" type="submit">
                    <i class="fa fa-fw fa-search"></i>
                  </button>
                </div>
            </form>
            <br>
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                  <h3 class="block-title">List Perguruan Tinggi (Total : -) </h3>
                  <div class="block-options">
                    <button type="button" class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled me-1" title="Tambah Data" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-extra-large-tambah">
                        <i class="fa fa-fw fa-plus"></i>
                        <span>Tambah Data</span>
                      </button>
                  </div>
                </div>
                <div class="block-content">
                  <div class="table-responsive">
                    <table class="table table-vcenter">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 100px;">
                            No
                          </th>
                          <th>Perguruan Tinggi</th>
                          <th>Jenis</th>
                          <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                      </thead>
                      @if ($pts->count() > 0)
                      @php
                        $no = 0;
                      @endphp
                      @foreach ($pts as $list_pts)
                      <tbody>
                                      <tr>
                            <td class="text-center">
                              {{ $no = $no + 1 }}
                            </td>
                            <td class="fw-semibold fs-sm">
                                {{ $list_pts->nama }}
                              </td>
                            <td class="fw-semibold fs-sm">
                              {{ $list_pts->jenis }}
                            </td>
                            <td class="text-center">
                              <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete" title="Hapus" onclick="confirmationHapusData('{{ route('admin.ea.delete_pts', $list_pts->id) }}')">
                                  <i class="fa fa-fw fa-trash"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                        @endforeach
                        @else
                                <tr>
                                  <td colspan="9" class="text-center text-danger fw-semibold fs-sm">Belum Ada Data atau Data Tidak Ditemukan.</td>
                                </tr>
                                @endif
                    </table>
                  </div>
                </div>
              </div>
        </div>

        <!-- modal Tamnbah Data -->
        <div class="modal fade" id="modal-block-vcenter-extra-large-tambah" tabindex="-1" aria-labelledby="modal-block-vcenter" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                  <div class="block-header block-header-default">
                    <h3 class="block-title">Modal Tambah PTS</h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="block-content fs-sm">
                    <form class="space-y-4" action="{{ route('admin.ea.store_pts') }}" method="POST">
                      @csrf
                      <div class="row">
                        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
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
                <div class="block-content block-content-full text-end bg-body">
                  <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-sm btn-primary"">Buat EA</button>
                </div>
              </form>
              </div>
    </div>
    
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmationHapusData(url) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: 'Data yang dipilih akan dihapus dari sistem!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#B22222',
            cancelButtonColor: '#A9A9A9',
            confirmButtonText: 'Ya',
            closeOnConfirm: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
</script>
@endsection