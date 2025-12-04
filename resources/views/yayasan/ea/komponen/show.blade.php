@extends('layouts.main')

@section('content')
@include('layouts.topbar')

<style>
/* === Styling CSS === */
.image-preview {
    position: relative;
    display: inline-block;
    cursor: zoom-in;
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
    {{-- ====== Breadcrumb ====== --}}
    <div class="bg-body-extra-light">
        <div class="content content-boxed py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt mb-0">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('yayasan.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('yayasan.ea.content', $component->subdomain_id) }}">
                            {{ $component->subdomain->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $component->name ?? 'List Data' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- ====== Konten Utama ====== --}}
    <div class="content">
        {{-- Form Pencarian --}}
        <form action="{{ route('yayasan.ea.component_show', $component->id) }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search"
                       placeholder="Cari {{ $component->name ?? 'Data' }}"
                       value="{{ request()->input('search') }}">
                <button class="input-group-text btn btn-primary" type="submit">
                    <i class="fa fa-fw fa-search"></i>
                </button>
            </div>
        </form>

        {{-- ====== Tabel Data ====== --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title mb-0">List {{ $component->name ?? 'Data' }}</h3>
            </div>

            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-vcenter align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Judul</th>
                                <th>Konten</th>
                                <th>Tipe Konten</th>
                                <th>Status</th>
                                <th class="text-center">Komentar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($component->details->count() > 0)
                            @foreach ($component->details as $list_component)
                                @php
                                    $content = $list_component->contents->sortByDesc('created_at')->first();
                                    $type = strtolower($content->content_type ?? '');
                                    $path = $content->file_path ?? null;
                                    $ext  = $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : null;
                                    $status = strtolower($content->status ?? $list_component->status ?? 'proses');
                                @endphp
                                <tr class="fw-semibold fs-sm">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $list_component->title ?? '-' }}</td>
                                    <td>
                                        {{-- === Konten Preview === --}}
                                        @if ($content)
                                            @if ($type === 'text')
                                                <p class="mb-0 text-truncate" style="max-width: 250px;">
                                                    {!! Str::limit($content->text ?? '❌ Teks Kosong', 100, '...') !!}
                                                </p>
                                            @elseif (in_array($type, ['file', 'file_path']) && $path)
                                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                    <div class="image-preview">
                                                        <img src="{{ asset($path) }}" alt="Preview" class="img-thumbnail"
                                                             style="max-height:60px;"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#imagePreviewModal"
                                                             data-image="{{ asset($path) }}">
                                                        <div class="overlay">Klik untuk lihat</div>
                                                    </div>
                                                @elseif ($ext === 'pdf')
                                                    <button type="button" class="btn btn-sm btn-alt-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#pdfPreviewModal"
                                                            data-pdf="{{ asset($path) }}">
                                                        <i class="fa fa-file-pdf"></i> Lihat PDF
                                                    </button>
                                                @else
                                                    <a href="{{ asset($path) }}" download>
                                                        <i class="fa fa-file text-info me-1"></i> Download File
                                                    </a>
                                                @endif
                                            @elseif (in_array($type, ['link', 'link_url']) && !empty($content->link_url))
                                                <a href="{{ $content->link_url }}" target="_blank" class="d-inline-block text-truncate" style="max-width: 250px;">
                                                    <i class="fa fa-link text-success me-1"></i>{{ $content->link_url }}
                                                </a>
                                            @else
                                                <span class="text-muted fst-italic">Tidak ada konten</span>
                                            @endif
                                        @else
                                            <span class="text-muted fst-italic">Tidak ada konten</span>
                                        @endif
                                    </td>
                                    <td>{{ $content ? ucfirst(str_replace('_', ' ', $content->content_type)) : '-' }}</td>
                                    <td>
                                        @switch($status)
                                            @case('selesai')
                                                <span class="badge bg-primary">Selesai</span>
                                                @break
                                            @case('proses')
                                                <span class="badge bg-warning text-dark">Proses</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">-</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        {{-- <button type="button"
                                            class="btn btn-sm btn-alt-warning open-komentar-modal"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-komentar-tunggal"
                                            data-component-id="{{ $content->id }}">
                                            <i class="fa fa-fw fa-comment"></i>Komentar
                                        </button> --}}
                                        @php
                                        $totalComments = $content->comments->count();
                                        $newComments = $content->comments
                                            ->where('created_at', '>=', now()->subDay()) // komentar 24 jam terakhir
                                            ->count();
                                    @endphp
                                        <button type="button"
                                            class="btn btn-sm btn-alt-warning open-komentar-modal position-relative"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-komentar-tunggal"
                                            data-component-id="{{ $content->id }}">
                                            
                                            <i class="fa fa-fw fa-comment"></i> Komentar ({{ $totalComments }})
                                    
                                            {{-- Badge Komentar Baru --}}
                                            @if($newComments > 0)
                                                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                                                    {{ $newComments }}
                                                </span>
                                            @endif
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-danger fw-semibold">
                                    Belum Ada Data Detail Komponen.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- ====== MODALS ====== --}}
{{-- Modal Preview Gambar --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="image-preview-full" src="" alt="Preview" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

{{-- Modal Preview PDF --}}
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe id="pdf-preview-frame" src="" width="100%" height="700px" style="border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

{{-- Modal Komentar --}}
<div class="modal fade" id="modal-komentar-tunggal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Komentar</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>

                <form id="form-kirim-komentar" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="modal-component-id" value="">

                    <div class="block-content fs-sm">
                        <div class="mb-3">
                            <h5>Riwayat Komentar</h5>
                            <div id="riwayat-komentar-area">
                                <p class="text-muted">Pilih item untuk memuat komentar...</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="comment">Komentar</label>
                            <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="Tulis komentar..."></textarea>
                        </div>
                    </div>

                    <div class="text-end bg-body p-3 rounded-bottom">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ====== SCRIPT ====== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imgModal = document.getElementById('imagePreviewModal');
    const pdfModal = document.getElementById('pdfPreviewModal');
    const imagePreviewFull = document.getElementById('image-preview-full');
    const pdfPreviewFrame = document.getElementById('pdf-preview-frame');

    imgModal?.addEventListener('show.bs.modal', e => {
        const img = e.relatedTarget.getAttribute('data-image');
        if (imagePreviewFull && img) imagePreviewFull.src = img;
    });
    imgModal?.addEventListener('hidden.bs.modal', () => imagePreviewFull.src = '');

    pdfModal?.addEventListener('show.bs.modal', e => {
        const pdf = e.relatedTarget.getAttribute('data-pdf');
        if (pdfPreviewFrame && pdf) pdfPreviewFrame.src = pdf;
    });
    pdfModal?.addEventListener('hidden.bs.modal', () => pdfPreviewFrame.src = '');
});

$(document).ready(function() {
    const routeSaveComment = '{{ route('yayasan.ea.saveComments') }}';
    const getCommentsUrlTemplate = '{{ route('yayasan.ea.getComments', ['id' => ':id']) }}';

    $('.open-komentar-modal').on('click', function() {
        const componentContentId = $(this).data('component-id'); 
        $('#modal-component-id').val(componentContentId);

        const riwayatArea = $('#riwayat-komentar-area');
        riwayatArea.html('<p class="text-info"><i class="fa fa-spinner fa-spin"></i> Memuat komentar...</p>');

        const getCommentsUrl = getCommentsUrlTemplate.replace(':id', componentContentId);

        $.ajax({
            url: getCommentsUrl,
            method: 'GET',
            success: function(response) {
                if (!response.success) {
                    riwayatArea.html('<p class="text-danger">Gagal memuat komentar.</p>');
                    return;
                }

                let html = '';
                if (response.comments && response.comments.length > 0) {
                    response.comments.forEach(c => {
                        html += `<div class="border-bottom py-2">
                            <strong>${c.user_name}</strong>
                            <p class="mb-1">${$('<div>').text(c.comment).html()}</p>
                            <small class="text-muted">${c.created_at}</small>
                        </div>`;
                    });
                } else {
                    html = '<p class="text-muted">Belum ada komentar.</p>';
                }
                riwayatArea.html(html);
            },
            error: function() {
                riwayatArea.html('<p class="text-danger">Gagal memuat komentar.</p>');
            }
        });
    });

    $('#form-kirim-komentar').on('submit', function(e) {
        e.preventDefault();
        const contentId = $('#modal-component-id').val();
        const comment = $('#comment').val();

        if (!comment || !comment.trim()) {
            return Swal.fire('Peringatan', 'Komentar tidak boleh kosong', 'warning');
        }

        $.ajax({
            url: routeSaveComment,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                component_content_id: contentId,
                comment: comment
            },
            success: function(res) {
                if (res.success) {
                    Swal.fire('Berhasil', res.message, 'success');
                    $('#comment').val('');
                    $('.open-komentar-modal[data-component-id="'+contentId+'"]').trigger('click');
                } else {
                    Swal.fire('Gagal', 'Gagal menyimpan komentar', 'error');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const errs = xhr.responseJSON.errors;
                    let text = Object.values(errs).map(arr => arr.join(' ')).join(' ');
                    Swal.fire('Error', text, 'error');
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                }
            }
        });
    });
});

</script>
@endsection
