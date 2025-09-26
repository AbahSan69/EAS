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
            <a class="link-fx" href="{{ route('yayasan.index', $id_pts) }}">Home</a>
          </li>
          <li class="breadcrumb-item">
            Visi & Misi
          </li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="content">
    <form action="{{ route('yayasan.vision.visimisi.show', $id_pts) }}" method="GET">
      <div class="input-group mb-4">
        <input type="text" class="form-control" name="search" placeholder="Cari visimisi" value="{{ request()->input('search') }}">
        <!-- Search Icon as Submit Button -->
        <button class="input-group-text btn btn-primary" type="submit">
          <i class="fa fa-fw fa-search"></i>
        </button>
      </div>
    </form>
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">List Visi & Misi </h3>
        <div class="block-options">
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
                <th class="text-center" style="width: 100px;">Aksi</th>
              </tr>
            </thead>
            @if ($vision->count() > 0)
              @php
                $no = 0;
              @endphp
              @foreach ($vision as $list_visimisi)
                <tbody>
                  <tr>
                    <td class="text-center">
                      {{ $no = $no + 1 }}
                    </td>
                    <td class="fw-semibold fs-sm">
                      {{ $list_visimisi->title }}
                    </td>
                    <td class="fw-semibold fs-sm">
                      @if ($list_visimisi->content)
                        {{ $list_visimisi->content }}
                      @else
                        <span class="fw-semibold fs-sm">Tidak ada text</span>
                      @endif
                    </td>
                    <td>
                      @if($list_visimisi->image)
                        <div class="image-preview" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $list_visimisi->id }}">
                          <img src="{{ asset('storage/'.$list_visimisi->image) }}" 
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
                      @switch($list_visimisi->status)
                        @case('Proses')
                          <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-primary-light text-dark">
                            {{ $list_visimisi->status }}
                          </span>
                        @break
                        @case('Selesai')
                          <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">
                            {{ $list_visimisi->status }}
                          </span>
                        @break
                        @default
                          <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-secondary-light text-secondary">
                            {{ $list_visimisi->status }}
                          </span>
                      @endswitch
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled me-2" title="Comment" data-bs-toggle="modal" data-bs-target="#modal-block-vcenter-extra-large-komentar-{{ $list_visimisi->id }}">
                        <i class="fa fa-fw fa-comment"></i>
                        <span>Komentar</span>
                      </button>
                    </td>
                  </tr>
                </tbody>

                <!-- Modal -->
                <div class="modal fade" id="imageModal-{{ $list_visimisi->id }}" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <div class="modal-body text-center">
                        <img src="{{ asset('storage/'.$list_visimisi->image) }}" class="img-fluid" alt="gambar detail">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- modal Edit Data -->
                <div class="modal fade" id="modal-block-vcenter-extra-large-komentar-{{ $list_visimisi->id }}" tabindex="-1" aria-labelledby="modal-block-vcenter" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
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
                            @forelse($list_visimisi->vision_comments as $cmt)
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
                          <form class="space-y-4" action="{{ route('yayasan.vision.visimisi.save_comment') }}" method="POST">
                          @csrf
                            <input type="hidden" name="id" id="id" value="{{ $list_visimisi->id }}">
                            <div class="row">
                              <div class="mb-4">
                                <label class="form-label" for="val-suggestions">Komentar</span></label>
                                <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="comment ..."></textarea>
                              </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                          <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                          <button type="submit" id="btn-register" class="btn btn-sm btn-primary">Kirim</button>
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