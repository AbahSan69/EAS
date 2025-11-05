@extends('admin.layouts.main')
@section('content')
<main id="main-container" class="flex-grow-1">
    <div class="bg-body-extra-light">
        <div class="content content-boxed py-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-alt">
              <li class="breadcrumb-item">
                <a class="link-fx" href="{{ route('admin.dashboard_admin') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a class="link-fx" href="{{ route('admin.ea.domain.show') }}">Domain</a>
              </li>
              <li class="breadcrumb-item">
                Sub Domain
              </li>
            </ol>
          </nav>
        </div>
      </div>

    <div class="content">
            <form action="{{ route('admin.ea.subdomain.show', $domain->id ) }}" method="GET">
                <div class="input-group">
                  <input type="text" class="form-control" name="search" placeholder="Cari Sub Domain {{ $domain->name }} " value="{{ request()->input('search') }}">
                  <!-- Search Icon as Submit Button -->
                  <button class="input-group-text btn btn-primary" type="submit">
                    <i class="fa fa-fw fa-search"></i>
                  </button>
                </div>
            </form>
            <br>
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                  <h3 class="block-title">List Sub Domain {{ $domain->name }} </h3>
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
                          <th>Nama Sub Domain</th>
                          <th>Lihat</th>
                          <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                      </thead>
                      @if ($subdomain->count() > 0)
                      @php
                        $no = 0;
                      @endphp
                      @foreach ($subdomain as $list_subdomain)
                      <tbody>
                                      <tr>
                            <td class="text-center">
                              {{ $no = $no + 1 }}
                            </td>
                            <td class="fw-semibold fs-sm">
                                {{ $list_subdomain->name }}
                              </td>
                            <td class="fw-semibold fs-sm">
                                <a type="button" class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled me-2" title="Lihat" href="{{ route('admin.ea.component.show', $list_subdomain->id) }}">
                                    <i class="fa fa-fw fa-eye"></i>
                                    <span>Lihat</span>
                                </a>
                            </td>
                            <td class="text-center">
                              <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-extra-large-tambah-{{ $list_subdomain->id }}">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete" title="Hapus" onclick="confirmationHapusData('{{ route('admin.ea.subdomain.delete_subdomain', $list_subdomain->id) }}')">
                                  <i class="fa fa-fw fa-trash"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
                                  </tbody>

                                  <!-- modal Edit Data -->
        <div class="modal fade" id="modal-block-vcenter-extra-large-tambah-{{ $list_subdomain->id }}" tabindex="-1" aria-labelledby="modal-block-vcenter" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                  <div class="block-header block-header-default">
                    <h3 class="block-title">Modal Edit Sub Domain</h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="block-content fs-sm">
                    <form class="space-y-4" action="{{ route('admin.ea.subdomain.update_subdomain') }}" method="POST">
                      @csrf
                      <input type="hidden" name="id" id="id" value="{{ $list_subdomain->id }}">
                      <div class="row">
                        <div class="mb-4">
                          <label class="col-sm-4 col-form-label" for="example-hf-nama">Nama <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="name" name="name"  placeholder="Masukan nama ..." value="{{ $list_subdomain->name }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Deskripsi</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Masukan Deskripsi">{{ old('description', $list_subdomain->description) }}</textarea>
                        </div>
                  </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                  <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                  <button type="submit" id="btn-register" class="btn btn-sm btn-primary"">Tambah</button>
                </div>
              </form>
              </div>
            </div>
          </div>

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
                    <h3 class="block-title">Modal Tambah Domain</h3>
                    <div class="block-options">
                      <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-fw fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="block-content fs-sm">
                    <form class="space-y-4" action="{{ route('admin.ea.subdomain.save_subdomain') }}" method="POST">
                      @csrf
                      <input type="hidden" name="domain_id" id="domain_id" value="{{ $domain->id }}">
                      <div class="row">
                        <div class="mb-4">
                          <label class="col-sm-4 col-form-label" for="example-hf-nama">Nama <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="name" name="name"  placeholder="Masukan nama ..." required>
                        </div>
                        <div class="mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-email">Deskripsi</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                        </div>
                  </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                  <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                  <button type="submit" id="btn-register" class="btn btn-sm btn-primary"">Tambah</button>
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