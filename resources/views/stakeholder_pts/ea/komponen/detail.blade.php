@extends('layouts.main')
@section('content')
@include('layouts.topbar')

<main id="main-container" class="flex-grow-1">
    <div class="bg-body-light">
        <div class="content content-full">
          <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
              <h1 class="h3 fw-bold mb-1">
                Riwayat Perubahan Konten
              </h1>
            </div>
            <div class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3">
              {{-- <button class="btn btn-sm btn-alt-primary js-class-toggle-enabled" data-toggle="class-toggle" data-target=".timeline" data-class="timeline-centered">
                <i class="fa fa-arrows-alt-h me-1"></i> Toggle Timeline Mode
              </button> --}}
              <a href="{{ route('sp.ea.component_show', $detail->component_id) }}" class="btn btn-sm btn-alt-info js-class-toggle-enabled" data-toggle="class-toggle" data-target=".timeline" data-class="timeline-centered">
                Kembali
              </a>
            </div>
          </div>
        </div>
      </div>
    <div class="content">
        {{-- Informasi Komponen --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold">{{ $detail->title }}</h5>
                <p class="text-muted mb-0">
                    Subdomain: <strong>{{ $detail->component->subdomain->name }}</strong><br>
                    Komponen: <strong>{{ $detail->component->name }}</strong>
                </p>

            </div>
        </div>

        <ul class="timeline timeline-alt">

            @forelse($histories as $h)
        
                <li class="timeline-event">
        
                    {{-- ICON SESUAI JENIS KONTEN --}}
                    <div class="timeline-event-icon 
                        @if($h->content_type === 'Text') bg-info
                        @elseif($h->content_type === 'File') bg-success
                        @elseif($h->content_type === 'Link') bg-warning
                        @else bg-primary
                        @endif">
                        
                        @if($h->content_type === 'Text')
                            <i class="fa fa-font"></i>
                        @elseif($h->content_type === 'File')
                            <i class="fa fa-file-alt"></i>
                        @elseif($h->content_type === 'Link')
                            <i class="fa fa-link"></i>
                        @else
                            <i class="fa fa-info-circle"></i>
                        @endif
        
                    </div>
        
                    <div class="timeline-event-block block">
        
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Perubahan Konten ({{ $h->content_type }})
                            </h3>
        
                            <div class="block-options">
                                <div class="timeline-event-time block-options-item fs-sm fw-semibold">
                                    {{ $h->created_at->format('d M Y - H:i') }}
                                </div>
                            </div>
                        </div>
        
                        <div class="block-content fs-sm">
        
                            {{-- KONTEN TEXT --}}
                            @if($h->content_type === 'Text')
        
                                <div class="p-3 border rounded bg-white mb-4">
                                    {!! nl2br(e($h->text)) !!}
                                </div>
        
                            {{-- KONTEN FILE --}}
                            @elseif($h->content_type === 'File')
        
                                <a href="{{ asset($h->file_path) }}"
                                   class="btn btn-alt-primary mb-4"
                                   target="_blank">
                                    <i class="fa fa-download me-1"></i> Lihat File
                                </a>
        
                            {{-- KONTEN LINK --}}
                            @elseif($h->content_type === 'Link')
        
                                <a href="{{ $h->link_url }}"
                                   class="btn btn-alt-info mb-4"
                                   target="_blank">
                                    <i class="fa fa-external-link-alt me-1"></i>
                                    {{ $h->link_url }}
                                </a>
        
                            @endif
        
                            <p class="text-muted mb-4">
                                @php
                                    $status = strtolower($h->status ?? 'proses');
                                @endphp
                                @switch($status)
                                    @case('selesai')
                                    Status : <span class="badge bg-primary">Selesai</span>
                                        @break
                                    @case('proses')
                                    Status : <span class="badge bg-warning text-light">Proses</span>
                                        @break
                                    @default
                                    Status : <span class="badge bg-secondary">-</span>
                                @endswitch
                                <br>
                                Update Oleh : <strong>{{ $h->updatedBy->name }}</strong>
                            </p>

                        </div>
                    </div>
        
                </li>
        
            @empty
        
                <li class="timeline-event">
                    <div class="timeline-event-icon bg-secondary">
                        <i class="fa fa-info"></i>
                    </div>
                    <div class="timeline-event-block block">
                        <div class="block-content text-center text-muted py-4">
                            Belum ada riwayat perubahan.
                        </div>
                    </div>
                </li>
        
            @endforelse
        
        </ul>        

    </div>

</main>
@endsection
