@extends('layouts.main')
@section('content')
@include('layouts.topbar')
<style>
  .image-preview {
  position: relative;
  display: inline-block;
  cursor: zoom-in; /* kaca pembesar */
}

.image-preview .overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.6);
  color: #fff;
  text-align: center;
  padding: 5px;
  font-size: 12px;
  opacity: 0;
  transition: opacity 0.3s ease;
  border-bottom-left-radius: .25rem;
  border-bottom-right-radius: .25rem;
}

.image-preview:hover .overlay {
  opacity: 1;
}

</style>
<main id="main-container" class="flex-grow-1">
  <div class="bg-body-extra-light">
      <div class="content content-boxed py-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ route('sp.progress.index', $id_pts) }}">Home</a>
            </li>
            <li class="breadcrumb-item">
              produk
            </li>
          </ol>
        </nav>
      </div>
    </div>

  <div class="content">
          <form action="{{ route('sp.ea.bisnis.produk.show', $id_pts) }}" method="GET">
              <div class="input-group mb-4">
                <input type="text" class="form-control" name="search" placeholder="Cari produk" value="{{ request()->input('search') }}">
                <!-- Search Icon as Submit Button -->
                <button class="input-group-text btn btn-primary" type="submit">
                  <i class="fa fa-fw fa-search"></i>
                </button>
              </div>
          </form>
          <div class="block block-rounded">
              <div class="block-header block-header-default">
                <h3 class="block-title">List produk</h3>
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
                        <th>Judul</th>
                        <th>Konten Text</th>
                        <th>Konten Gambar</th>
                        <th>Status</th>
                        <th>Komentar</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                      </tr>
                    </thead>
                    @if ($bisnis->count() > 0)
                    @php
                      $no = 0;
                    @endphp
                    @foreach ($bisnis as $list_produk)
                      <tbody>
                        <tr>
                          <td class="text-center">
                            {{ $no = $no + 1 }}
                          </td>
                          <td class="fw-semibold fs-sm">
                              {{ $list_produk->title }}
                            </td>
                            <td class="fw-semibold fs-sm">
                              @if ($list_produk->content)
                                {{ $list_produk->content }}
                              @else
                                <span class="fw-semibold fs-sm">Tidak ada text</span>
                              @endif
                            </td>
                            <td>
                              @if($list_produk->image)
                                <div class="image-preview" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $list_produk->id }}">
                                  <img src="{{ asset('storage/'.$list_produk->image) }}" 
                                  alt="gambar" 
                                  width="80" 
                                  class="img-thumbnail">
                                  <div class="overlay">🔍 Lihat Gambar</div>
                                </div>
                              @else
                                  <span class="fw-semibold fs-sm">Tidak ada gambar</span>
                              @endif
                            </td>
                            <td class="fw-semibold fs-sm">
                              @switch($list_produk->status)
                                @case('Proses')
                                  <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-primary-light text-dark">
                                    {{ $list_produk->status }}
                                  </span>
                                @break
                                @case('Selesai')
                                  <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">
                                    {{ $list_produk->status }}
                                  </span>
                                @break
                                @default
                                  <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-secondary-light text-secondary">
                                    {{ $list_produk->status }}
                                  </span>
                              @endswitch
                            </td>
                          <td>
                            <button type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled me-2" title="komentar" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-extra-large-komentar-{{ $list_produk->id }}">
                              <i class="fa fa-fw fa-comment"></i>
                              <span>Komentar</span>
                          </button>
                          </td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-extra-large-tambah-{{ $list_produk->id }}">
                                  <i class="fa fa-fw fa-pencil"></i>
                              </button>
                              <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete" title="Hapus" onclick="confirmationHapusData('{{ route('sp.ea.bisnis.produk.delete', $list_produk->id) }}')">
                                <i class="fa fa-fw fa-trash"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
                      </tbody>

                      <!-- Modal Gambar -->
                      <div class="modal fade" id="imageModal-{{ $list_produk->id }}" taprodukndex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                          <div class="modal-content">
                            <div class="modal-body text-center">
                              <img src="{{ asset('storage/'.$list_produk->image) }}" class="img-fluid" alt="gambar detail">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- modal komentar -->
                      <div class="modal fade" id="modal-block-vcenter-extra-large-komentar-{{ $list_produk->id }}" tabindex="-1" aria-labelledby="modal-block-vcenter" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="bicument">
                          <div class="modal-content">
                            <div class="block block-rounded block-transparent mb-0">
                              <div class="block-header block-header-default">
                                <h3 class="block-title">Modal Komentar</h3>
                                <div class="block-options">
                                  <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                  </button>
                                </div>
                              </div>
                              <div class="block-content fs-sm">
                                <div class="mb-3">
                                  <h5>Riwayat Komentar</h5>
                                  @forelse($list_produk->bisnis_comments as $cmt)
                                    <div class="border p-2 mb-2 rounded">
                                      <strong>{{ $cmt->user->name }}</strong> 
                                      <span class="badge bg-info">{{ $cmt->status_review }}</span>
                                      <p class="mb-1">{{ $cmt->comment }}</p>
                                      <small class="text-muted">{{ $cmt->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                  @empty
                                    <p class="text-muted">Belum ada komentar</p>
                                  @endforelse
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
                      <div class="modal fade" id="modal-block-vcenter-extra-large-tambah-{{ $list_produk->id }}" tabindex="-1" aria-labelledby="modal-block-vcenter" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="bicument">
                          <div class="modal-content">
                            <div class="block block-rounded block-transparent mb-0">
                              <div class="block-header block-header-default">
                                <h3 class="block-title">Modal Edit produk</h3>
                                <div class="block-options">
                                  <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                  </button>
                                </div>
                              </div>
                              <div class="block-content fs-sm">
                                <form class="space-y-4" action="{{ route('sp.ea.bisnis.produk.update') }}" method="POST">
                                @csrf
                                  <input type="hidden" name="id" id="id" value="{{ $list_produk->id }}">
                                  <div class="row">
                                    <div class="mb-4">
                                      <label class="col-sm-4 col-form-label" for="example-hf-title">Judul <span class="text-danger">*</span></label>
                                      <input type="text" class="form-control" id="title" name="title" title="title"  placeholder="Masukan judul ..." value="{{ $list_produk->title }}" required>
                                    </div>
                                    <div class="mb-4">
                                      <label class="form-label" for="val-suggestions">Konten</span></label>
                                      <textarea class="form-control" id="content" name="content" rows="5" placeholder="content ...">{{ $list_produk->content }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                      <label for="status" class="form-label">Pilih Status</label>
                                      <select class="form-select" id="status" name="status" required>
                                        <option selected="" disabled>Pilih Status</option>
                                        <option value="Proses" {{ old('status', $list_produk->status ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ old('status', $list_produk->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                      </select>
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
          <div class="modal-dialog modal-dialog-centered" role="bicument">
            <div class="modal-content">
              <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                  <h3 class="block-title">Modal Tambah produk</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content fs-sm">
                  <form class="space-y-4" action="{{ route('sp.ea.bisnis.produk.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_pts" id="id_pts" value="{{ $id_pts }}">
                    <div class="row">
                      <div class="mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-title">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" title="title" placeholder="Masukan judul ..."required>
                      </div>
                      <div class="mb-4">
                        <label class="form-label" for="val-suggestions">Konten</span></label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="content ..."></textarea>
                      </div>
                      <div class="mb-4">
                        <label class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control" name="image">
                        <small class="text-muted">Format: jpg, png, jpeg | Maks: 2MB</small>
                    </div>
                      <div class="mb-4">
                            <label for="status" class="form-label">Pilih PTS</label>
                            <select class="form-select" id="status" name="status" required>
                                <option selected="" disabled>Pilih Status</option>
                                    <option value="Proses">Proses</option>
                                    <option value="Selesai">Selesai</option>
                            </select>
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
<!-- Tambahkan di layout utama (layouts.main) atau di file blade ini sebelum </body> -->
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