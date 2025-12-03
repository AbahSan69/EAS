@extends('admin.layouts.main')
@section('content')
<style>
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
                <a class="link-fx" href="{{ route('admin.dashboard_admin') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                Universitas
              </li>
            </ol>
          </nav>
        </div>
    </div>

    <div class="content">
        {{-- 🔍 Form Pencarian --}}
        <form action="{{ route('sp.ea.component_show', $component->id) }}" method="GET">
            <div class="input-group mb-4">
                <input type="text" class="form-control" name="search" placeholder="Cari Stakeholder..." value="{{ request()->input('search') }}">
                <button class="input-group-text btn btn-primary" type="submit">
                    <i class="fa fa-fw fa-search"></i>
                </button>
            </div>
        </form>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">List Stakeholder {{ $component->name }}</h3>
                <div class="block-options">
                    {{-- ➕ Tombol Tambah Data --}}
                    {{-- <button type="button"
                        class="btn btn-sm btn-alt-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#dynamic-data-modal"
                        data-action-url="{{ route('sp.ea.stakeholder_simpan') }}">
                        <i class="fa fa-fw fa-plus"></i> Tambah Data
                    </button> --}}
                    
<a href="{{ route('sp.ea.stakeholder_create', $component->id) }}" class="btn btn-sm btn-alt-primary"><i class="fa fa-fw fa-plus"></i> Tambah Data</a>

                </div>
            </div>

            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $user->name ?? '-' }}</td>
                                    <td>{{ $user->email ?? '-' }}</td>
                                    <td>
                                        Aktif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            {{-- ✏️ Edit --}}
                                            {{-- <button type="button"
                                                class="btn btn-sm btn-alt-warning me-1"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#dynamic-data-modal"
                                                data-mode="edit"
                                                data-id="{{ $user->id }}"
                                                data-title="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                
                                                data-action-url="{{ route('sp.ea.stakeholder_update', $user->id) }}">
                                                <i class="fa fa-fw fa-pencil"></i>
                                            </button> --}}

                                            <a href="{{ route('sp.ea.stakeholder_edit', ['id' => $user->id, 'componentId' => $component->id]) }}" class="btn btn-sm btn-alt-warning me-1"><i class="fa fa-fw fa-pencil"></i></a>

                                            {{-- 🗑️ Hapus --}}
                                            <button type="button"
                                                class="btn btn-sm btn-alt-danger"
                                                title="Hapus"
                                                onclick="confirmationHapusData('{{ route('sp.ea.stakeholder_destroy', $user->id) }}')">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger fw-semibold">
                                        Belum ada data Stakeholder.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- 🚀 Modal Dinamis Tambah/Edit --}}
    <div class="modal fade" id="dynamic-data-modal" tabindex="-1" aria-labelledby="modal-block-vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="modal-title-dynamic">Tambah Stakeholder</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-content fs-sm">
                        <form id="dynamic-data-form" action="" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="dynamic_id">
                            <input type="hidden" name="component_id" id="dynamic_component_id" value="{{ $component->id }}">
                            <input type="hidden" name="component_name" id="dynamic_component_name" value="{{ $component->name }}">

                            <div class="mb-4">
                                <label for="dynamic_title" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="dynamic_title" name="title" placeholder="Masukkan nama lengkap..." required>
                            </div>

                            <div class="mb-4">
                                <label for="dynamic_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="dynamic_email" name="email" placeholder="Masukkan email..." required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="dynamic_password" name="dynamic_password" placeholder="Masukkan password" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="dynamic_konfirmasi_password" name="dynamic_konfirmasi_password" placeholder="Konfirmasi password" required>
                            </div>

                            <div class="mb-4">
                                <label for="dynamic_status" class="form-label">Status</label>
                                <select class="form-select" id="dynamic_status" name="status" required>
                                    <option selected disabled value="">Pilih Status</option>
                                    <option value="Proses">Aktif</option>
                                    <option value="Selesai">Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="block-content block-content-full text-end bg-body">
                                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    })
}

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('dynamic-data-modal');
    const form = document.getElementById('dynamic-data-form');
    const modalTitle = document.getElementById('modal-title-dynamic');
    const idInput = document.getElementById('dynamic_id');
    const titleInput = document.getElementById('dynamic_title');
    const emailInput = document.getElementById('dynamic_email');
    const passwordInput = document.getElementById('dynamic_password');
    const statusSelect = document.getElementById('dynamic_status');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const mode = button.getAttribute('data-mode');
        const actionUrl = button.getAttribute('data-action-url');
        form.reset();
        form.setAttribute('action', actionUrl);

        if (mode === 'edit') {
            modalTitle.textContent = 'Edit Stakeholder';
            idInput.value = button.getAttribute('data-id');
            titleInput.value = button.getAttribute('data-title') || '';
            emailInput.value = button.getAttribute('data-email') || '';
            statusSelect.value = button.getAttribute('data-status') || 'Proses';
            passwordInput.required = false; // optional saat edit
        } else {
            modalTitle.textContent = 'Tambah Stakeholder';
            passwordInput.required = true;
        }
    });
});
</script>

@endsection