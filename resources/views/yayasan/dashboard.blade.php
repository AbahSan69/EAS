@extends('layouts.main')

@section('content')
@include('layouts.topbar')

@php
    // Hitung total progress keseluruhan
    $domainCount = $domains->count();
    $totalDomainProgress = $domains->sum('progress');
    $overallProgress = $domainCount > 0 ? round($totalDomainProgress / $domainCount) : 0;
@endphp

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
                    <span class="fs-4 fw-bold">{{ $overallProgress }}%</span>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="progress mb-2" style="height: 12px;">
                    <div class="progress-bar bg-success"
                        role="progressbar"
                        style="width: {{ $overallProgress }}%;"
                        aria-valuenow="{{ $overallProgress }}"
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <p class="mb-0 fs-sm text-end">Rata-rata kemajuan seluruh Domain</p>
            </div>
        </div>

        {{-- LOOP DOMAIN --}}
        @foreach($domains as $domain)
            <div class="block block-rounded mb-4 shadow-sm">
                <div class="block-header d-flex justify-content-between align-items-center">
                    <h3 class="block-title text-uppercase">{{ $domain->name }}</h3>
                    <span class="text-muted small">Progress: {{ round($domain->progress) }}%</span>
                </div>

                <div class="block-content">
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success"
                             role="progressbar"
                             style="width: {{ round($domain->progress) }}%;"></div>
                    </div>

                    <div class="row g-3 mb-4">
                        {{-- LOOP SUBDOMAIN --}}
                        @foreach($domain->subdomain as $sub)
                            @php
                                $subProgress = round($sub->progress);
                                $progressClass = $subProgress == 100 ? 'bg-success' : 'bg-warning';
                                $buttonClass = $subProgress == 100 ? 'btn-success' : 'btn-outline-primary';

                                // Cek apakah user punya akses ke salah satu komponen dalam subdomain ini
                                $componentIds = $sub->component->pluck('id')->toArray();
                                $hasAccess = count(array_intersect($componentIds, $userPermissions)) > 0;
                            @endphp

                            <div class="col-md-3">
                                <div class="block block-rounded text-center p-3 h-100 border hover-shadow-sm">
                                    <h6 class="fw-bold mb-2">{{ $sub->name }}</h6>

                                    {{-- PROGRESS --}}
                                    <p class="fw-bold fs-5 mb-2 {{ $subProgress == 100 ? 'text-success' : 'text-primary' }}">
                                        {{ $subProgress }}%
                                    </p>

                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar {{ $progressClass }}"
                                             style="width: {{ $subProgress }}%;"></div>
                                    </div>

                                    {{-- INFO SUBDOMAIN TANPA COMPONENT --}}
                                    @if($sub->component->count() === 0 && $sub->subdomain_contents->count() > 0)
                                        <small class="d-block text-muted mb-2">
                                            Subdomain ini belum memiliki komponen, menggunakan subdomain content
                                        </small>
                                    @endif

                                    {{-- BUTTON DETAIL --}}
                                    <a href="{{ $hasAccess ? route('yayasan.ea.content', $sub->id) : 'javascript:void(0)' }}"
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
