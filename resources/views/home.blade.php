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
      <!-- Overlay -->
      <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.3);"></div>
      <div class="content content-full position-relative">
        <h1 class="display-4 fw-semibold text-white mb-2">
          EAS
        </h1>
        <h1 class="display-4 fw-semibold text-white mb-2">
          Enterprise Architecture System
        </h1>
      </div>
    </div>
  </main>
@endsection
