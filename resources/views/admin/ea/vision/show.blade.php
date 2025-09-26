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
                EAS 
              </li>
            </ol>
          </nav>
        </div>
    </div>
    
    <div class="content py-3">
        <div class="content">
            <form action="" method="GET">
                <div class="input-group mb-4">
                    <input type="text" class="form-control" name="q" placeholder="Cari Vision" value="{{ request()->q }}">
                    <!-- Search Icon as Submit Button -->
                    <button class="input-group-text btn btn-primary" type="submit">
                        <i class="fa fa-fw fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Architecture Vision</h3>
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
                                    <th style="width: 100px;">Judul</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($vision as $list_vision)
                                <tbody>
                                    <tr>
                                        <td class="text-center fw-semibold fs-sm">
                                            {{ $no = $no + 1 }}
                                        </td>
                                        <td class="fw-semibold fs-sm">
                                            {{ $list_vision->judul }}
                                        </td>
                                        <td class="fw-semibold fs-sm">
                                            {{ $list_vision->deskripsi }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-sm btn-alt-info js-bs-tooltip-enabled me-2" title="Detail" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-extra-large-detail-{{ $list_vision->id }}">
                                                <i class="fa fa-fw fa-info"></i>
                                              </button>
                                              <button type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-extra-large-tambah-{{ $list_vision->id }}">
                                                <i class="fa fa-fw fa-pencil"></i>
                                              </button>
                                              <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete" title="Hapus" onclick="confirmationHapusData('')">
                                                <i class="fa fa-fw fa-trash"></i>
                                              </button>
                                            </div>
                                          </td>
                                    </tr>
                                </tbody>

                                <!-- Modal Detail Data -->
                <div class="modal fade" id="modal-block-vcenter-extra-large-Detail-{{ $list_vision->id }}" tabindex="-1" aria-labelledby="modal-block-vcenter" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                          <div class="block-header block-header-default">
                            <h3 class="block-title">Modal Detail Vision</h3>
                            <div class="block-options">
                              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                              </button>
                            </div>
                          </div>
                        <div class="block-content fs-sm">
                          <div class="row">
                            <div class="mb-2"><strong>Judul:</strong> {{ $list_vision->judul }} </div>
                            <div class="mb-2"><strong>Deskripsi:</strong> {{ $list_vision->deskripsi }} </div>
                            <div class="mb-2"><strong>Konten:</strong></div>
                          </div>
                          </div>
                          <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- modal Edit Data -->
                  <div class="modal fade" id="modal-block-vcenter-extra-large-tambah-{{ $list_vision->id }}" tabindex="-1" aria-labelledby="modal-block-vcenter" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                          <div class="block-header block-header-default">
                            <h3 class="block-title">Modal Edit Vision</h3>
                            <div class="block-options">
                              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                              </button>
                            </div>
                          </div>
                        <div class="block-content fs-sm">
                        <form class="space-y-4" action="{{ route('ea.vision.update') }}" method="POST">
                        @csrf
                          <input type="hidden" name="id" id="id" value="{{ $list_vision->id }}">
                            <div class="row">
                              <div class="mb-4">
                                <label class="col-sm-4 col-form-label" for="example-hf-judul">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul"  placeholder="Masukan judul ..." value="{{ $list_vision->judul }}" required>
                              </div>
                              <div class="mb-4">
                                <label class="form-label" for="val-suggestions">Deskripsi</span></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Deskripsi ...">{{ $list_vision->deskripsi }}</textarea>
                              </div>
                            </div>
                          </div>
                          <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btn-register" class="btn btn-sm btn-primary">Simpan</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                            @endforeach
                        </table>
                    </div>
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
                    <h3 class="block-title">Modal Tambah Vision</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form class="space-y-4" action="ea.vision.store" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-4">
                            <label class="col-sm-4 col-form-label" for="example-hf-judul">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul"  placeholder="Masukan judul ..." required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="val-suggestions">Deskripsi</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Deskripsi ...."></textarea>
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
</div>

</main>
@endsection