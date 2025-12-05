@extends('layouts.main')
@section('content')
    @include('layouts.topbar')
    <style>
        /* Styling CSS Image Preview*/
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
        <div class="bg-body-extra-light">
            <div class="content content-boxed py-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('sp.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="{{ route('sp.ea.content', $component->subdomain_id) }}">{{ $component->subdomain->name }}</a>
                        </li>
                        {{-- Navigasi Breadcrumb Disesuaikan --}}
                        <li class="breadcrumb-item" aria-current="page">
                            {{ $component->name ?? 'List Data' }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="content">
            <form action="{{ route('sp.ea.component_show', $component->id) }}" method="GET">
                <div class="input-group mb-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari {{ $component->name ?? 'Data' }}" value="{{ request()->input('search') }}">
                    <button class="input-group-text btn btn-primary" type="submit">
                        <i class="fa fa-fw fa-search"></i>
                    </button>
                </div>
            </form>

            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">List {{ $component->name ?? 'Data' }}</h3>
                    <div class="block-options">
                        {{-- 🎯 TRIGGER TAMBAH DATA (Menggunakan Modal Dinamis) --}}
                        {{-- <button type="button"
                            class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled me-1"
                            title="Tambah Data"
                            data-bs-toggle="modal"
                            data-bs-target="#dynamic-data-modal"
                            data-action-url="{{ route('sp.ea.component_content_simpan') }}"
                            data-component-id="{{ $component->id }}">
                            <i class="fa fa-fw fa-plus"></i> Tambah Data
                        </button> --}}

                        @if(in_array('create', $permissions))
                            <button type="button"
                                    class="btn btn-sm btn-alt-primary me-1"
                                    title="Tambah Data"
                                    data-bs-toggle="modal"
                                    data-bs-target="#dynamic-data-modal"
                                    data-action-url="{{ route('sp.ea.component_content_simpan') }}"
                                    data-component-id="{{ $component->id }}">
                                <i class="fa fa-fw fa-plus"></i> Tambah Data
                            </button>
                        @else
                            <button class="btn btn-sm btn-alt-primary me-1" disabled>
                                <i class="fa fa-fw fa-plus"></i> Tambah Data
                            </button>
                        @endif
                    </div>
                </div>
            
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 100px;">No</th>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Tipe Konten</th>
                                    <th>Status</th>
                                    <th>Komentar</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            @if ($component->details->count() > 0)
                                @foreach ($component->details as $list_component)
                                    @php
                                        $content = $list_component->contents->sortByDesc('created_at')->first();
                                        $type = strtolower($content->content_type ?? '');
                                        $path = $content->file_path ?? null;
                                        $ext  = $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : null;
                                    @endphp
                                    <tr> 
                                        {{-- Kolom 1: Nomor Urut --}} 
                                        <td class="text-center fw-semibold fs-sm"> {{ $loop->iteration }} </td>
                                        {{-- Kolom 2: Judul Detail --}}
                                        <td class="fw-semibold fs-sm">
                                            {{ $list_component->title ?? '-' }}
                                        </td>
                                        {{-- Kolom 3: Konten Preview --}}
                                        <td class="fw-semibold fs-sm">
                                            @if ($content)
                                                @if ($type === 'text')
                                                    {{-- 📝 Konten Teks --}}
                                                    <p class="mb-1 text-truncate" style="max-width: 250px;">
                                                        {!! Str::limit($content->text ?? '❌ Teks Kosong', 100, '...') !!}
                                                    </p>
                    
                                                @elseif (in_array($type, ['file', 'file_path']) && $path)
                                                    {{-- 📁 Konten File --}}
                                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                        {{-- 🖼️ Gambar --}}
                                                        <div class="image-preview"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#imagePreviewModal"
                                                                data-image="{{ asset($path) }}">
                                                            <img src="{{ asset($path) }}"
                                                                    alt="Preview"
                                                                    class="img-thumbnail"
                                                                    style="max-height:60px; cursor:pointer;">
                                                            <div class="overlay">Klik untuk lihat</div>
                                                        </div>

                                                    @elseif ($ext === 'pdf')
                                                        {{-- 📄 PDF --}}
                                                        <button type="button"
                                                                class="btn btn-sm btn-alt-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#pdfPreviewModal"
                                                                data-pdf="{{ asset($path) }}">
                                                            <i class="fa fa-file-pdf"></i> Lihat PDF
                                                        </button>
                                                    @else
                                                        {{-- 📦 File Lain --}}
                                                        <p class="mb-1">
                                                            <i class="fa fa-file me-1 text-info"></i>
                                                            <a href="{{ asset($path) }}" download>Download File</a>
                                                        </p>
                                                    @endif
                    
                                                @elseif (in_array($type, ['link', 'link_url']) && !empty($content->link_url))
                                                    {{-- 🔗 Link --}}
                                                    <p class="mb-1">
                                                        <i class="fa fa-link me-1 text-success"></i>
                                                        <a href="{{ $content->link_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;">
                                                            {{ $content->link_url }}
                                                        </a>
                                                    </p>
                    
                                                @else
                                                    <span class="text-muted fst-italic">Tidak ada konten</span>
                                                @endif
                                            @else
                                                <span class="text-muted fst-italic">Tidak ada konten</span>
                                            @endif
                                        </td>
                            
                                        {{-- Kolom 4: Tipe Konten --}}
                                        <td class="fw-semibold fs-sm">
                                            {{ $content ? ucfirst(str_replace('_', ' ', $content->content_type)) : '-' }}
                                        </td>
                    
                                        {{-- Kolom 5: Status --}}
                                        <td class="fw-semibold fs-sm">
                                            @php
                                                $status = strtolower($content->status ?? $list_component->status ?? 'proses');
                                            @endphp
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
                    
                                        {{-- Kolom 6: Komentar --}}
                                        <td>
                                            {{-- <button type="button"
                                                            class="btn btn-sm btn-alt-warning open-komentar-modal"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-komentar-tunggal"
                                                            data-component-id="{{ $content->id }}">
                                                        <i class="fa fa-fw fa-comment"></i><span>Komentar</span>
                                            </button> --}}
                                            @php
                                                $userId = Auth::id();
                                                // Total komentar
                                                $totalComments = $content->comments->count();
                                                // Ambil record last_read
                                                $readStatus = \App\Models\CommentRead::where('user_id', $userId)
                                                                ->where('component_content_id', $content->id)
                                                                ->first();

                                                // Jika belum pernah membaca komentar (record tidak ada)
                                                if (!$readStatus) {
                                                    // Semua komentar belum dibaca
                                                    $unreadComments = $totalComments;
                                                } else {
                                                    // Hitung komentar baru setelah last_read_at
                                                    $unreadComments = $content->comments
                                                                        ->where('created_at', '>', $readStatus->last_read_at)
                                                                        ->count();
                                                }
                                            @endphp

                                            <button type="button"
                                                    class="btn btn-sm btn-alt-warning open-komentar-modal position-relative"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-komentar-tunggal"
                                                    data-component-id="{{ $content->id }}">

                                                <i class="fa fa-fw fa-comment"></i> Komentar ({{ $totalComments }})

                                                {{-- Badge komentar baru --}}
                                                @if($unreadComments > 0)
                                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                                                        {{ $unreadComments }}
                                                    </span>
                                                @endif
                                            </button>
                                        </td>
                    
                                        {{-- Kolom 7: Aksi --}}
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('sp.ea.gaps', $list_component->id) }}" class="btn btn-sm btn-alt-info me-2" title="Gaps">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </a>
                                                {{-- Edit --}}
                                                @if(in_array('update', $permissions))
                                                    <button type="button"
                                                            class="btn btn-sm btn-alt-warning me-2"
                                                            title="Edit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#dynamic-data-modal"
                                                            data-mode="edit"
                                                            data-id="{{ $list_component->id }}"
                                                            data-title="{{ $list_component->title ?? '' }}"
                                                            data-jenis="{{ ucfirst(strtolower($content->content_type ?? '')) }}"
                                                            data-content="{{ $content->text ?? $content->link_url ?? '' }}"
                                                            data-file="{{ $content?->file_path ? asset($content->file_path) : '' }}"
                                                            data-status="{{ ucfirst($content->status ?? 'Proses') }}"
                                                            data-action-url="{{ route('sp.ea.component_content_update', $list_component->id) }}">
                                                        <i class="fa fa-fw fa-pencil"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-alt-warning me-2" disabled>
                                                        <i class="fa fa-fw fa-pencil"></i>
                                                    </button>
                                                @endif
                            
                                                {{-- Hapus --}}
                                                @if(in_array('delete', $permissions))
                                                    <button type="button"
                                                            class="btn btn-sm btn-alt-danger"
                                                            title="Hapus"
                                                            onclick="confirmationHapusData('{{ route('sp.ea.component_content_delete', $list_component->id) }}')">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-alt-danger" disabled>
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>         
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-danger fw-semibold fs-sm">
                                        Belum Ada Data Detail Komponen.
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- 🚀 MODAL DINAMIS UNTUK TAMBAH & EDIT DATA DETAIL --}}
        <div class="modal fade" id="dynamic-data-modal" tabindex="-1" aria-labelledby="modal-block-vcenter" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title" id="modal-title-dynamic">Tambah Data Komponen</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
  
                        <div class="block-content fs-sm">
                            <form id="dynamic-data-form" action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="dynamic_id">
                                <input type="hidden" name="component_id" id="dynamic_component_id" value="{{ $component->id }}">
  
                                {{-- Judul --}}
                                <div class="mb-4">
                                    <label for="dynamic_title" class="form-label">Judul <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="dynamic_title" name="title" placeholder="Masukkan judul ..." required>
                                </div>
  
                                {{-- Jenis Konten --}}
                                <div class="mb-4">
                                    <label for="dynamic_jenis_konten" class="form-label">Pilih Jenis Konten</label>
                                    <select class="form-select" id="dynamic_jenis_konten" name="jenis_konten" required>
                                        <option selected disabled value="">Pilih Jenis Konten</option>
                                        <option value="Text">Text</option>
                                        <option value="File">File</option>
                                        <option value="Link">Link URL</option>
                                    </select>
                                </div>
  
                                {{-- Konten Dinamis --}}
                                <div id="dynamic_konten_dinamis"></div>
  
                                {{-- Status --}}
                                <div class="mb-4">
                                    <label for="dynamic_status" class="form-label">Status</label>
                                    <select class="form-select" id="dynamic_status" name="status" required>
                                        <option selected disabled value="">Pilih Status</option>
                                        <option value="Proses">Proses</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="btn-submit-dynamic">Simpan</button>
                        </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
  
        <!-- Modal Preview Gambar -->
        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img id="image-preview-full" src="" alt="Preview" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Preview PDF -->
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
                            </div>

                            <div class="text-end bg-body p-3 rounded-bottom">
                                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // FUNGSI KONFIRMASI HAPUS DATA (Menggunakan SweetAlert2)
        function confirmationHapusData(url) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Data yang dipilih akan dihapus dari sistem!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#B22222',
                cancelButtonColor: '#A9A9A9',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal', // Tambahkan text untuk tombol batal agar lebih jelas
            }).then((result) => {
                if (result.isConfirmed) {
                    // Periksa apakah URL valid sebelum pengalihan
                    if (url) { 
                        window.location.href = url;
                    } else {
                        console.error('URL untuk penghapusan tidak ditemukan.');
                    }
                }
            });
        }

        // Variabel untuk elemen wrapper konten dinamis
        const kontenWrapper = document.getElementById('dynamic_konten_dinamis');

        /**
        * FUNGSI DINAMIS UTAMA: Merender field input berdasarkan tipe konten yang dipilih.
        * @param {string} type - Tipe konten ('text', 'file', 'link').
        * @param {string} value - Nilai konten (untuk 'text' atau 'link').
        * @param {string} filePath - Path file (untuk 'file').
        */
        function renderDynamicField(type, value = '', filePath = '') {
            // Guard Clause: Keluar jika kontenWrapper tidak ditemukan
            if (!kontenWrapper) {
                console.error('Elemen #dynamic_konten_dinamis tidak ditemukan.');
                return;
            }

            // Normalisasi tipe ke huruf kecil (lebih aman)
            const normalizedType = type ? type.toLowerCase() : ''; 
        
            // Bersihkan konten sebelumnya
            kontenWrapper.innerHTML = '';

            // Tampilkan konten yang relevan
            switch (normalizedType) {
                case 'text':
                    kontenWrapper.innerHTML = `
                        <div class="mb-4">
                            <label class="form-label" for="dynamic_content">Konten Teks</label>
                            <textarea class="form-control" id="dynamic_content" name="content" rows="5" placeholder="Masukkan teks..." required>${value || ''}</textarea>
                        </div>`;
                break;
                case 'file':
                    // Perhatikan: Name input diubah menjadi 'content' jika Anda ingin 
                    // menggunakan satu field 'content' di backend untuk semua tipe, 
                    // atau pertahankan 'file_path' jika memang berbeda.
                    // Saya menggunakan 'file_path' seperti kode asli Anda untuk upload.
                    kontenWrapper.innerHTML = `
                        <div class="mb-4">
                            <label class="form-label" for="dynamic_file">Upload File</label>
                            <input type="file" class="form-control" id="dynamic_file" name="file_content" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <small class="text-muted">Maksimal 2MB (Format: Gambar, PDF, DOCX)</small>
                            ${filePath ? `
                            <div class="mt-3">
                                <p class="mb-1 fw-semibold">File Sebelumnya:</p>
                                ${filePath.match(/\.(jpg|jpeg|png)$/i) 
                                    ? `<img src="${filePath}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">`
                                    : `<a href="${filePath}" target="_blank" class="d-block text-primary">${filePath.split('/').pop()}</a>`
                                }
                            </div>` : ''}
                        </div>`;
                break;
                case 'link':
                    // Name input diubah menjadi 'content' jika Anda ingin 
                    // menggunakan satu field 'content' di backend untuk semua tipe.
                    // Saya menggunakan 'link_url' seperti kode asli Anda.
                    kontenWrapper.innerHTML = `
                        <div class="mb-4">
                            <label class="form-label" for="dynamic_link_url">Link URL</label>
                            <input type="url" class="form-control" id="dynamic_link_url" name="link_url" placeholder="https://contoh.com" value="${value || ''}" required>
                        </div>`;
                break;
                default:
                    // Biarkan kosong atau tampilkan pesan default jika tidak ada tipe yang dipilih
                    kontenWrapper.innerHTML = '';
                break;
            }
        }

        // --- LISTENER DOM CONTENT LOADED (Hanya Ada Satu) ---
        document.addEventListener('DOMContentLoaded', function () {
            // Deklarasi variabel menggunakan 'const' untuk elemen yang tidak berubah
            const modal = document.getElementById('dynamic-data-modal');
            const form = document.getElementById('dynamic-data-form');
            const jenisSelect = document.getElementById('dynamic_jenis_konten');
            const modalTitle = document.getElementById('modal-title-dynamic');
            const idInput = document.getElementById('dynamic_id');
            const titleInput = document.getElementById('dynamic_title');
            const statusSelect = document.getElementById('dynamic_status');

            // Gunakan Optional Chaining (?.) untuk memastikan elemen ada sebelum menambahkan listener
            // 1. LISTENER MODAL DINAMIS (TAMBAH/EDIT)
            modal?.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const mode = button.getAttribute('data-mode');
                const actionUrl = button.getAttribute('data-action-url');

                // Reset form dan isi ulang
                form?.reset(); // Gunakan Optional Chaining
                // Konten wrapper sudah dideklarasikan di scope global
                if(kontenWrapper) kontenWrapper.innerHTML = '';
            
                // Atur nilai default/reset
                idInput.value = '';
                // Pastikan URL Aksi selalu ada
                form?.setAttribute('action', actionUrl || '#');

                if (mode === 'edit') {
                    modalTitle.textContent = 'Edit Data Komponen';

                    const id = button.getAttribute('data-id');
                    const title = button.getAttribute('data-title') || '';
                    const jenis = button.getAttribute('data-jenis') || ''; 
                    const content = button.getAttribute('data-content') || '';
                    const filePath = button.getAttribute('data-file') || '';
                    const status = button.getAttribute('data-status') || 'Proses';

                    idInput.value = id;
                    titleInput.value = title;
                
                    // Pilih opsi di <select> menggunakan nilai *sesuai case* yang ada di <option> (misal: 'Text', 'File', 'Link').
                    // Jika nilai di <option> adalah Kapital, harus disesuaikan.
                    // Asumsi: Nilai <option> di HTML adalah 'Text', 'File', 'Link' (huruf kapital di awal)
                    jenisSelect.value = jenis.charAt(0).toUpperCase() + jenis.slice(1);
                    statusSelect.value = status;

                    // Panggil fungsi renderDynamicField
                    renderDynamicField(jenis, content, filePath);
                } else {
                    modalTitle.textContent = 'Tambah Data Komponen';
                    // Panggil dengan string kosong saat Tambah untuk memastikan bersih
                    renderDynamicField(''); 
                }
            });

            // 2. LISTENER PERUBAHAN JENIS KONTEN
            jenisSelect?.addEventListener('change', function () {
                // Panggil fungsi renderDynamicField dengan nilai <select> yang sudah diubah ke huruf kecil
                // dan tanpa nilai (reset) saat user ganti jenis secara manual
                renderDynamicField(this.value, ''); 
            });


            // 3. LISTENER MODAL PREVIEW GAMBAR DAN PDF (Perbaikan Masalah Preview)
            const imgModal = document.getElementById('imagePreviewModal');
            const pdfModal = document.getElementById('pdfPreviewModal');
            const imagePreviewFull = document.getElementById('image-preview-full');
            const pdfPreviewFrame = document.getElementById('pdf-preview-frame');

            // Pastikan elemen preview ada
            imgModal?.addEventListener('show.bs.modal', e => {
                const trigger = e.relatedTarget || e.target;
                const img = trigger?.getAttribute('data-image');
                if (imagePreviewFull && img) imagePreviewFull.src = img;
            });


            pdfModal?.addEventListener('show.bs.modal', e => {
                const pdf = e.relatedTarget.getAttribute('data-pdf');
                if(pdfPreviewFrame && pdf) {
                    pdfPreviewFrame.src = pdf;
                }
            });

            pdfModal?.addEventListener('hidden.bs.modal', () => {
                // Hapus sumber saat modal ditutup untuk menghentikan pemuatan (good practice)
                if(pdfPreviewFrame) {
                    pdfPreviewFrame.src = '';
                }
            });
        });

        $(document).ready(function() {
            const getCommentsUrlTemplate = '{{ route('sp.ea.getComments', ['id' => ':id']) }}';
            const updateReadUrl = '{{ route('sp.ea.comment_read') }}'; // route update last_read_at

            $('.open-komentar-modal').on('click', function() {
                const componentContentId = $(this).data('component-id'); 
                $('#modal-component-id').val(componentContentId);

                const riwayatArea = $('#riwayat-komentar-area');
                riwayatArea.html('<p class="text-info"><i class="fa fa-spinner fa-spin"></i> Memuat komentar...</p>');

                const getCommentsUrl = getCommentsUrlTemplate.replace(':id', componentContentId);

                // 1️⃣ Ambil komentar via AJAX
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

                        // 2️⃣ Setelah komentar berhasil dimuat → update last_read_at
                        $.ajax({
                            url: updateReadUrl,
                            method: "POST",
                            data: {
                                component_content_id: componentContentId,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {
                                // 3️⃣ Hapus badge komentar baru (tanpa reload)
                                $('[data-component-id="' + componentContentId + '"] .badge').remove();
                            }
                        });
                    },
                    error: function() {
                        riwayatArea.html('<p class="text-danger">Gagal memuat komentar.</p>');
                    }
                });
            });
        });
    </script>
@endsection