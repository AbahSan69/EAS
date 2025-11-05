@extends('layouts.main')

@section('content')
@include('layouts.topbar')

<style>
.image-preview {
    position: relative;
    display: inline-block;
    cursor: zoom-in;
}

.image-preview .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    text-align: center;
    padding: 5px;
    font-size: 12px;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
}

.image-preview:hover .overlay {
    opacity: 1;
}
</style>

<main id="main-container" class="flex-grow-1">
    <div class="bg-body-extra-light">
        <div class="content content-boxed py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('yayasan.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $component->name ?? 'Stakeholder' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="content">
        {{-- 🔍 Form Pencarian --}}
        <form action="{{ route('yayasan.ea.component_show', $component->id) }}" method="GET">
            <div class="input-group mb-4">
                <input type="text" class="form-control" name="search" placeholder="Cari Stakeholder..." value="{{ request()->input('search') }}">
                <button class="input-group-text btn btn-primary" type="submit">
                    <i class="fa fa-fw fa-search"></i>
                </button>
            </div>
        </form>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">List Stakeholder {{ $component->name }}</h3>
                <div class="block-options">
                </div>
            </div>

            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $user->name ?? '-' }}</td>
                                    <td>{{ $user->email ?? '-' }}</td>
                                    <td>
                                        Aktif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger fw-semibold">
                                        Belum ada data Stakeholder.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
