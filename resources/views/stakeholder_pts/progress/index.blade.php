@extends('layouts.main')
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
                EAS - {{ $pts->nama }}
              </li>
            </ol>
          </nav>
        </div>
      </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Architecture Vision</h3>
            </div>
            <div class="block-content">
    
                <div class="row g-3 mb-3">
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.vision.visimisi.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Visi & Misi</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.vision.principle.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Principles</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.vision.bisnis.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Bisnis Strategi</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('sp.ea.vision.objective_driver.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Objective & Drivers</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Gaps</h6>
                            </div>
                        </a>
                    </div>
                </div>
    
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Architecture Bisnis</h3>
            </div>
            <div class="block-content">
    
                <div class="row g-3">
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.bisnis.do.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Digital Organisasi</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.bisnis.bisnis_inovasi.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Bisnis Inovasi</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.bisnis.accountability.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Accountability</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.bisnis.produk.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Produk</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.bisnis.constrain.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Constrains</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sp.ea.bisnis.risk.show', $pts->id) }}" 
                            class="text-decoration-none">
                            <div class="block block-rounded text-center p-3 bg-body-light hover-shadow">
                                <h6 class="fw-bold mb-1 text-dark">Risk</h6>
                            </div>
                        </a>
                    </div>
                </div>
    
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Architecture Vision</h3>
            </div>
            <div class="block-content">
    
                <div class="row g-3">
                    {{-- Arsitektur Informasi --}}
                    <div class="col-md-3">
                        <div class="block block-rounded p-3 bg-body-light h-100">
                            <h6 class="fw-bold text-center mb-3">Arsitektur Informasi</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">Box 1</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">Box 2</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">Box 3</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    {{-- Arsitektur Aplikasi --}}
                    <div class="col-md-3">
                        <div class="block block-rounded p-3 bg-body-light h-100">
                            <h6 class="fw-bold text-center mb-3">Arsitektur Aplikasi</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">App 1</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">App 2</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">App 3</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">App 4</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    {{-- Arsitektur Teknologi --}}
                    <div class="col-md-3">
                        <div class="block block-rounded p-3 bg-body-light h-100">
                            <h6 class="fw-bold text-center mb-3">Arsitektur Teknologi</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">Tech 1</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">Tech 2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    {{-- Arsitektur Keamanan --}}
                    <div class="col-md-3">
                        <div class="block block-rounded p-3 bg-body-light h-100">
                            <h6 class="fw-bold text-center mb-3">Arsitektur Keamanan</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">Secure 1</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="block block-rounded p-3 text-center bg-white border">
                                        <span class="fs-sm">Secure 2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
</main>
@endsection