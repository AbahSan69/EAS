@extends('layouts.main')
<style>
.component-card {
    border: 1px solid #e5e7eb;
    transition: all 0.25s ease-in-out;
}
.component-card:hover {
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    transform: translateY(-4px);
}
.progress {
    background-color: #f5f6f7;
    border-radius: 6px;
}
.progress-bar.bg-warning { background-color: #fbc02d !important; }
.progress-bar.bg-success { background-color: #28a745 !important; }
.badge.bg-primary { background-color: #3b82f6 !important; }
hr { margin-top: 1rem; margin-bottom: 2rem; }
.btn-disabled {
    pointer-events: none;
    opacity: 0.6;
}
</style>

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
                        {{ $subdomain->name }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold">{{ $subdomain->name }}</h4>
                <p class="text-muted mb-0">Daftar komponen pada subdomain ini</p>
            </div>
            <div>
                <span class="badge bg-primary fs-6">Progress: {{ $progress }}%</span>
            </div>
        </div>

        <hr>

        <div class="row">
            @if($subkomponendetail->count() > 0)
                @foreach ($subkomponendetail as $component)
                    @php
                        $hasAccess = in_array($component->id, $userPermissions ?? []); // 🔹 Cek izin user
                    @endphp

                    <div class="col-md-4 mb-4">
                        <div class="component-card p-4 rounded shadow-sm bg-white h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-2">{{ $component->name }}</h6>
                                <p class="text-muted small mb-3">{{ $component->description ?? 'Belum ada deskripsi.' }}</p>

                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar {{ $component->progress == 100 ? 'bg-success' : 'bg-warning' }}"
                                         style="width: {{ $component->progress }}%;">
                                    </div>
                                </div>
                                <span class="small text-muted">{{ $component->progress }}% terisi</span>
                            </div>

                            <div class="mt-3 text-end">
                                {{-- 🔒 Cek apakah user punya akses --}}
                                @if ($hasAccess)
                                    {{-- ✅ User punya izin --}}
                                    @if ($component->progress > 0)
                                        @if ($subdomain->name === 'Stakeholder')
                                            <a href="{{ route('sp.ea.stakeholder_show', $component->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                               <i class="bi bi-person-vcard"></i> Lihat Data Stakeholder
                                            </a>
                                        @else
                                            <a href="{{ route('sp.ea.component_show', $component->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                               <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        @endif
                                    @else
                                        {{-- Belum ada konten --}}
                                        @if ($subdomain->name === 'Stakeholder')
                                            <a href="{{ route('sp.ea.stakeholder_show', $component->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                               <i class="bi bi-person-vcard"></i> Lihat Data Stakeholder
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-outline-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#dynamic-content-modal"
                                                data-id="{{ $component->id }}"
                                                data-university-id="{{ $subdomain->university_id }}"
                                                data-target="component"
                                                data-action-url="{{ route('sp.ea.component_content_simpan') }}">
                                                <i class="bi bi-pencil"></i> Isi Sekarang
                                            </button>
                                        @endif
                                    @endif
                                @else
                                    {{-- 🚫 Tidak punya izin --}}
                                    <button class="btn btn-sm btn-secondary btn-disabled" title="Anda tidak memiliki akses ke komponen ini">
                                        <i class="bi bi-lock"></i> Tidak Ada Akses
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-danger fw-semibold fs-sm">Belum Ada Konten Subdomain.</p>
            @endif
        </div>
    </div>
</main>

{{-- 🚀 Modal Dinamis --}}
<div class="modal fade" id="dynamic-content-modal" tabindex="-1" aria-labelledby="modal-block-vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Tambah Konten <span id="modal-title-suffix"></span></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="block-content fs-sm">
                    <form id="form-dynamic-content" class="space-y-4" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="component_id" id="dynamic_component_id" value="">
                        <input type="hidden" name="subdomain_id" id="dynamic_subdomain_id" value="">
                        <input type="hidden" name="university_id" id="dynamic_university_id" value="">

                        <div class="mb-4">
                            <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul ..." required>
                        </div>

                        <div class="mb-4">
                            <label for="dynamic_jenis_konten" class="form-label">Pilih Jenis Konten</label>
                            <select class="form-select" id="dynamic_jenis_konten" name="jenis_konten" required>
                                <option selected disabled value="">Pilih Jenis Konten</option>
                                <option value="Text">Text</option>
                                <option value="File">File (dokumen atau gambar)</option>
                                <option value="Link">Link URL (link dokumen atau gambar)</option>
                            </select>
                        </div>

                        <div id="dynamic_konten_dinamis"></div>
                </div>

                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit" class="btn btn-sm btn-primary">Tambah</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi SweetAlert untuk konfirmasi hapus data
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
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Ambil elemen-elemen penting dari modal tunggal
        const dynamicModal = document.getElementById('dynamic-content-modal');
        const form = document.getElementById('form-dynamic-content');
        const jenisKontenSelect = document.getElementById('dynamic_jenis_konten');
        const kontenContainer = document.getElementById('dynamic_konten_dinamis');
        const componentIdInput = document.getElementById('dynamic_component_id');
        const subdomainIdInput = document.getElementById('dynamic_subdomain_id');
        const universityIdInput = document.getElementById('dynamic_university_id');
        const modalTitleSuffix = document.getElementById('modal-title-suffix');
        const titleInput = document.getElementById('title');

        if (!dynamicModal) return; // Keluar jika modal tidak ditemukan

        // 1. Logika saat modal ditampilkan (mengisi data dinamis)
        dynamicModal.addEventListener('show.bs.modal', function (event) {
            // Ambil tombol yang memicu modal
            const button = event.relatedTarget; 
            
            // Ambil data dari atribut data-* tombol
            const id = button.getAttribute('data-id');
            const universityId = button.getAttribute('data-university-id');
            const target = button.getAttribute('data-target'); // 'component' atau 'subdomain'
            const actionUrl = button.getAttribute('data-action-url');

            // Reset Form (Penting!)
            form.reset(); 
            kontenContainer.innerHTML = '';
            jenisKontenSelect.value = ''; // Set select ke disabled default option

            // Set Form Action URL
            form.setAttribute('action', actionUrl);
            
            // Set Hidden Inputs
            universityIdInput.value = universityId;
            
            if (target === 'component') {
                componentIdInput.value = id;
                subdomainIdInput.value = '';
                modalTitleSuffix.textContent = 'Komponen'; // Mengubah judul modal
            } else if (target === 'subdomain') {
                componentIdInput.value = '';
                subdomainIdInput.value = id;
                modalTitleSuffix.textContent = 'Subdomain'; // Mengubah judul modal
            }
        });

        // 2. Logika perubahan jenis konten
        jenisKontenSelect.addEventListener('change', function () {
            const selected = this.value;
            kontenContainer.innerHTML = ''; 

            if (selected === 'Text') {
                kontenContainer.innerHTML = `
                    <div class="mb-4">
                        <label class="form-label" for="content">Konten Teks</label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Masukkan konten teks..." required></textarea>
                    </div>
                `;
            } 
            else if (selected === 'File') {
                kontenContainer.innerHTML = `
                    <div class="mb-4">
                        <label class="form-label" for="file_content">Upload File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file_content" name="file_content" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" required>
                        <small class="text-muted">Format: jpg, png, pdf, doc | Maks: 2MB</small>
                    </div>
                `;
            } 
            else if (selected === 'Link') {
                kontenContainer.innerHTML = `
                    <div class="mb-4">
                        <label class="form-label" for="link_url">Link URL <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="link_url" name="link_url" placeholder="Masukkan link dokumen atau gambar..." required>
                    </div>
                `;
            }
        });

        // 3. Validasi sebelum submit
        form.addEventListener('submit', function (e) {
            const jenis = jenisKontenSelect.value;
            let valid = true;
            let pesan = '';

            // Validasi Judul
            const title = titleInput.value.trim();
            if (!title) {
                valid = false;
                pesan = 'Judul wajib diisi.';
            }

            // Validasi berdasarkan jenis konten (hanya dijalankan jika Judul valid)
            if (valid) {
                if (jenis === 'Text') {
                    // Validasi content di sini, gunakan document.getElementById('content')
                    const content = document.getElementById('content')?.value.trim();
                    if (!content) {
                        valid = false;
                        pesan = 'Konten teks wajib diisi.';
                    }
                } 
                else if (jenis === 'File') {
                    const fileInput = document.getElementById('file_content');
                    if (!fileInput || !fileInput.files.length) {
                        valid = false;
                        pesan = 'File wajib dipilih.';
                    } else {
                        const file = fileInput.files[0];
                        const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
                        const fileExtension = file.name.split('.').pop().toLowerCase();
                        if (!allowedExtensions.includes(fileExtension)) {
                            valid = false;
                            pesan = 'Format file tidak diizinkan.';
                        } else if (file.size > 2 * 1024 * 1024) {
                            valid = false;
                            pesan = 'Ukuran file maksimal 2MB.';
                        }
                    }
                } 
                else if (jenis === 'Link') {
                    const link = document.getElementById('link_url')?.value.trim();
                    const urlPattern = /^(https?:\/\/)[\w\-]+(\.[\w\-]+)+[/#?]?.*$/;
                    if (!link) {
                        valid = false;
                        pesan = 'Link URL wajib diisi.';
                    } else if (!urlPattern.test(link)) {
                        valid = false;
                        pesan = 'Masukkan URL yang valid.';
                    }
                } 
                else if (!jenis) {
                    valid = false;
                    pesan = 'Silakan pilih jenis konten terlebih dahulu.';
                }
            }


            if (!valid) {
                e.preventDefault(); // batalkan submit
                alert(pesan);
            }
        });
    });
</script>