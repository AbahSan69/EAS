@extends('layouts.main')
@section('content')
<main id="main-container" class="flex-grow-1">
  <div class="content">
    <div class="py-2 text-center">
      <h1 class="h3 fw-bold mb-2">
        ENTERPRISE ARCHITECTURE
      </h1>
      {{-- <h2 class="h6 fw-medium text-muted mb-0">
        Welcome <a class="fw-semibold" href="be_pages_generic_profile.html">John</a>, everything looks great.
      </h2> --}}
    </div>
  </div>

  <div class="content">
    <div class="row items-push">
      <div class="col">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Vision</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Archtecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-eye fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="{{ route('tes4') }}">
              <span>Buat Archtecture Vision</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row items-push">
      <div class="col">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Bisnis</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Archtecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-handshake fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Buat Archtecture Bisnis</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row items-push">
      <!-- Block 1 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Informasi</dt>
              <dd class="fs-sm fw-medium text-muted mb-0">Architecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-info fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Buat Architecture Informasi</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
    
      <!-- Block 2 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Aplikasi</dt>
              <dd class="fs-sm fw-medium text-muted mb-0">Architecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-desktop fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Buat Architecture Aplikasi</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
    
      <!-- Block 3 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Teknologi</dt>
              <dd class="fs-sm fw-medium text-muted mb-0">Architecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="fa fa-sitemap fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Buat Architecture Teknologi</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
    
      <!-- Block 4 -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Keamanan</dt>
              <dd class="fs-sm fw-medium text-muted mb-0">Architecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="fa fa-headset fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Buat Architecture Keamanan</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row items-push">
      <div class="col-sm-6 col-xxl-3">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Implementasi</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Buat Architecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-gem fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Buat Architecture Implementasi</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xxl-3">
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">Evaluasi</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Architecture</dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-user-circle fs-3 text-primary"></i>
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Buat Architecture Evaluasi</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>  
</main>
@endsection
