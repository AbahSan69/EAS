@extends('layouts.app')

@section('content')
<div class="card shadow p-4 text-center">
    <h4 class="mb-3">Halaman {{ request()->path() }}</h4>
    <p>Ini halaman placeholder. Silakan kembangkan konten sesuai kebutuhan EA.</p>
    <a href="{{ route('ea.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>
@endsection
