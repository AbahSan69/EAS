@extends('admin.layouts.main')
@section('content')
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
</main>

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
                                <small class="d-block text-muted mb-2">
                                    Total Component: {{ $sub['total_required_components'] }}
                                </small>

                                {{-- BUTTON DETAIL (dummy karena tidak ada route di dd) --}}
                                <a href="{{ route('admin.ea.university.content', [
                                    'id' => $sub['subdomain_id'],
                                    'UniversityId' => $university_id
                                ]) }}"
                               class="btn btn-sm mt-2 {{ $buttonClass }}">
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

@endsection