@extends('layouts.main')
@section('content')
@include('layouts.topbar')
<main id="main-container" class="flex-grow-1">
    <div class="bg-image d-flex align-items-center justify-content-center text-center"
     style="background-image: url('{{ asset('oneui/media/photos/photo36@2x.jpg') }}');
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;">

    <!-- Overlay gradasi -->
    <div style="position: absolute; top:0; left:0; width:100%; height:100%;
                background: rgba(0,0,0,0.3);"> 
    </div>
    <!-- Konten -->
    <div class="content content-full position-relative">
        <h1 class="display-4 fw-semibold text-white mb-2">
          ENTERPRISE ARCHITECTURE SYSTEM
        </h1>
        {{-- <p class="fs-4 fw-normal text-white-50 mb-5">
            Lead paragraph containing a quick description of your product.
        </p> --}}
        <div class="row justify-content-center">
            <!-- Card 1 -->
            <div class="col-12 col-md-6 col-lg-4 mb-3">
              <a href="{{ route('sp.ea.create') }}" 
                 class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4"
                 style="min-height: 180px;">
                <i class="fa fa-sitemap fa-3x mb-3"></i>
                <span class="fw-semibold text-center">
                  ENTERPRISE <br> ARCHITECTURE
                </span>
              </a>
            </div>
          
            <!-- Card 2 -->
            <div class="col-12 col-md-6 col-lg-4 mb-3">
              <a href="{{ route('sp.progress.load') }}" 
                 class="btn btn-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4"
                 style="min-height: 180px;">
                <i class="fa fa-tasks fa-3x mb-3"></i>
                <span class="fw-semibold text-center">
                  PROJECT PROGRESS <br> & MONITORING
                </span>
              </a>
            </div>
          </div>
          
    </div>
</div>

</main>
@endsection
