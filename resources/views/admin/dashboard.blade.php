@extends('admin.layouts.main')
@section('content')
    <main id="main-container">
      <div class="content">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
          <div class="flex-grow-1 mb-1 mb-md-0">
            <h1 class="h3 fw-bold mb-2">
              Dashboard
            </h1>
            <h2 class="h6 fw-medium fw-medium text-muted mb-0">
              Selamat Datang, {{ Auth::user()->name }}
            </h2>
          </div>
          
        </div>
      </div>
      <div class="content">
        <div class="row items-push">
          <div class="col-sm-6 col-xxl-3">
            <div class="block block-rounded d-flex flex-column h-100 mb-0">
              <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                <dl class="mb-0">
                  <dt class="fs-3 fw-bold">32</dt>
                  <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Admin</dd>
                </dl>
                <div class="item item-rounded-lg bg-body-light">
                  <i class="far fa-user-circle fs-3 text-primary"></i>
                </div>
              </div>
              <div class="bg-body-light rounded-bottom">
                <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span>Lihat Semua Admin</span>
                  <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xxl-3">
            <div class="block block-rounded d-flex flex-column h-100 mb-0">
              <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                <dl class="mb-0">
                  <dt class="fs-3 fw-bold">124</dt>
                  <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Dosen</dd>
                </dl>
                <div class="item item-rounded-lg bg-body-light">
                  <i class="far fa-user-circle fs-3 text-primary"></i>
                </div>
              </div>
              <div class="bg-body-light rounded-bottom">
                <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span>View all customers</span>
                  <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xxl-3">
            <div class="block block-rounded d-flex flex-column h-100 mb-0">
              <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                <dl class="mb-0">
                  <dt class="fs-3 fw-bold">45</dt>
                  <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Siswa</dd>
                </dl>
                <div class="item item-rounded-lg bg-body-light">
                  <i class="far fa-paper-plane fs-3 text-primary"></i>
                </div>
              </div>
              <div class="bg-body-light rounded-bottom">
                <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span>View all messages</span>
                  <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xxl-3">
            <div class="block block-rounded d-flex flex-column h-100 mb-0">
              <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                <dl class="mb-0">
                  <dt class="fs-3 fw-bold">4.5%</dt>
                  <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Kelas</dd>
                </dl>
                <div class="item item-rounded-lg bg-body-light">
                  <i class="fa fa-chart-bar fs-3 text-primary"></i>
                </div>
              </div>
              <div class="bg-body-light rounded-bottom">
                <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between" href="javascript:void(0)">
                  <span>View statistics</span>
                  <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        </main>
@endsection