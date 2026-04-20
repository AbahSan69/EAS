@extends('layouts.main')
@section('content')
    @include('layouts.topbar')
    <main id="main-container" class="flex-grow-1">
        {{-- Breadcrumb --}}
        <div class="bg-body-extra-light">
            <div class="content content-boxed py-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('yayasan.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            EAS - {{ Auth::user()->detail_role->university->name }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="content">
            {{-- TOTAL PROGRESS --}}
            <div class="block block-rounded bg-primary-darker text-white shadow-lg mb-5">
                <div class="block-header">
                    <h3 class="block-title text-white">TOTAL PROGRESS EAS</h3>
                    <div class="block-options">
                        <span class="fs-4 fw-bold">{{ $progressReport['overall_progress'] }}%</span>
                    </div>
                </div>

                <div class="block-content block-content-full">
                    <div class="progress mb-2" style="height: 12px;">
                        <div class="progress-bar bg-success"
                            style="width: {{ $progressReport['overall_progress'] }}%;">
                        </div>
                    </div>
                    <p class="mb-0 fs-sm text-end">Rata-rata kemajuan seluruh Domain</p>
                </div>
            </div>

            {{-- LOOP DOMAIN --}}
            @foreach($progressReport['domains'] as $domain)
                <div class="block block-rounded mb-4 shadow-sm">
                    {{-- DOMAIN HEADER --}}
                    <div class="block-header d-flex justify-content-between align-items-center">
                        <h3 class="block-title text-uppercase">
                            {{ $domain['domain_name'] }}
                        </h3>
                        <span class="text-muted small">
                            Progress: {{ $domain['progress'] }}%
                        </span>
                    </div>

                    <div class="block-content">
                        {{-- DOMAIN PROGRESS BAR --}}
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-success"
                                style="width: {{ $domain['progress'] }}%;">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            {{-- LOOP SUBDOMAIN --}}
                            @foreach($domain['subdomains'] as $sub)
                                @php
                                    $subProgress = $sub['calculated_progress'];
                                    $progressClass = $subProgress == 100 ? 'bg-success' : 'bg-primary';
                                    $buttonClass = $subProgress == 100 ? 'btn-success' : 'btn-primary';
                                    $hasAccess = true; // Sesuaikan dengan kebutuhan akses Anda
                                @endphp

                                <div class="col-md-3">
                                    <div class="block block-rounded text-center p-3 h-100 border hover-shadow-sm">
                                        {{-- SUBDOMAIN NAME --}}
                                        <h6 class="fw-bold mb-2">
                                            {{ $sub['subdomain_name'] }}
                                        </h6>
                                        {{-- SUBDOMAIN PROGRESS --}}
                                        <p class="fw-bold fs-5 mb-2 {{ $subProgress == 100 ? 'text-success' : 'text-primary' }}">
                                            {{ $subProgress }}%
                                        </p>
                                        <div class="progress mb-3" style="height: 6px;">
                                            <div class="progress-bar {{ $progressClass }}"
                                                style="width: {{ $subProgress }}%;">
                                            </div>
                                        </div>
                                        
                                        {{-- TOTAL REQUIRED COMPONENTS --}}
                                        @php
                                            $filled = $sub['filled_components'];
                                            $empty = $sub['empty_components'];
                                            $subId = $sub['subdomain_id'];
                                        @endphp

                                        <small class="d-block text-muted mb-1">
                                            Total Component: {{ $sub['total_required_components'] }}
                                        </small>

                                        <div id="sub-{{ $subId }}">
    
                                            {{-- SUMMARY --}}
                                            <div class="d-flex justify-content-center gap-3 small mb-2">
        
                                                {{-- TERISI --}}
                                                <a href="javascript:void(0)"
                                                   data-bs-toggle="collapse"
                                                   data-bs-target="#filled-{{ $subId }}"
                                                   class="text-success fw-semibold">
                                                   ✔ {{ $filled }} Terisi
                                                </a>

                                                {{-- BELUM --}}
                                                <a href="javascript:void(0)"
                                                   data-bs-toggle="collapse"
                                                   data-bs-target="#empty-{{ $subId }}"
                                                   class="text-danger fw-semibold">
                                                   ✖ {{ $empty }} Belum
                                                </a>
                                            </div>

                                            {{-- LIST TERISI --}}
                                            <div id="filled-{{ $subId }}" class="collapse" data-bs-parent="#sub-{{ $subId }}">
                                                <ul class="list-group mb-2">
                                                    @forelse($sub['components'] as $comp)
                                                        @if($comp['is_filled'])
                                                            <li class="list-group-item small text-success d-flex justify-content-between">
                                                                <span>✔ {{ $comp['component_name'] }}</span>
                                                                <span>{{ $comp['progress'] }}%</span>
                                                            </li>
                                                        @endif
                                                    @empty
                                                        <li class="list-group-item small text-muted">
                                                            Tidak ada data
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>

                                            {{-- LIST BELUM --}}
                                            <div id="empty-{{ $subId }}" class="collapse" data-bs-parent="#sub-{{ $subId }}">
                                                <ul class="list-group mb-2">
                                                    @forelse($sub['components'] as $comp)
                                                        @if(!$comp['is_filled'])
                                                            <li class="list-group-item small text-danger">
                                                                ✖ {{ $comp['component_name'] }}
                                                            </li>
                                                        @endif
                                                    @empty
                                                        <li class="list-group-item small text-muted">
                                                            Semua sudah terisi 🎉
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>

                                        </div>

                                        {{-- BUTTON DETAIL (dummy karena tidak ada route di dd) --}}
                                        <a href="{{ $hasAccess ? route('yayasan.ea.content', $sub['subdomain_id']) : 'javascript:void(0)' }}"
                                            class="btn btn-sm mt-2 {{ $buttonClass }}"
                                            @unless($hasAccess)
                                                style="pointer-events: none; opacity: 0.5; cursor: not-allowed;"
                                                title="Anda tidak memiliki akses"
                                            @endunless>
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
