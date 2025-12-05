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
                            <a class="link-fx" href="{{ route('yayasan.dashboard') }}">Dashboard</a>
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
                                            <a href="{{ route('yayasan.ea.stakeholder_show', $component->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                               <i class="bi bi-person-vcard"></i> Lihat Data Stakeholder
                                            </a>
                                        @else
                                            <a href="{{ route('yayasan.ea.component_show', $component->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                               <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        @endif
                                    @else
                                        {{-- Belum ada konten --}}
                                        @if ($subdomain->name === 'Stakeholder')
                                            <a href="{{ route('yayasan.ea.stakeholder_show', $component->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                               <i class="bi bi-person-vcard"></i> Lihat Data Stakeholder
                                            </a>
                                        @else
                                            <p class="text-center text-danger fw-semibold fs-sm">Belum Ada Data.</p>
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
    </main>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>