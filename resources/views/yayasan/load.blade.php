@extends('layouts.main')
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
            Load Universitas
          </li>
        </ol>
      </nav>
    </div>
  </div>
    <div class="content content-full py-6">
        <h1 class="h2 text-center mb-4">LOAD <br> ENTERPRISE ARCHITECTURE</h1>
        <div class="content">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <form action="{{ route('yayasan.load_pts') }}" method="post">
                  @csrf
                  <div class="block block-rounded">
                    <div class="block-header block-header-default">
                      <h3 class="block-title">Enterprise Architecture</h3>
                    </div>
                    <div class="block-content block-content-full">
                      <div class="mx-0 mx-md-6 mx-xl-8">
                        <div class="mb-4">
                            <label for="status" class="form-label">Pilih PTS</label>
                            <select class="form-select" id="id_pts" name="id_pts" required>
                                <option selected="" disabled>Pilih PTS</option>
                                @foreach ($pts as $list_pts)
                                    <option value="{{ $list_pts->id }}">{{ $list_pts->nama }}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-end push">
                    <button type="submit" class="btn btn-sm btn-primary">
                      <i class="fa fa-cycle me-1"></i> Load Data
                    </button>
                    
                  </div>
                </form>
              </div>
            </div>
          </div>
    </div>
</main>
@endsection

