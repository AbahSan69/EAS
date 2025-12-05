@extends('layouts.main')
<style>
  .domain-section {
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 10px;
    overflow: hidden;
  }
  .domain-header {
    background: #f7f7f7;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .domain-header:hover {
    background: #eee;
  }
  .domain-body {
    display: none;
    padding: 10px;
    background: #fff;
  }
  .chevron {
    transition: transform 0.2s ease;
  }
  .chevron.rotate {
    transform: rotate(90deg);
  }
  table.permission-table {
    width: 100%;
    border-collapse: collapse;
  }
  .permission-table th, .permission-table td {
    border: 1px solid #ddd;
    padding: 5px;
  }
  .permission-table th {
    background-color: #f0f0f0;
  }
</style>
@section('content')
  @include('layouts.topbar')
  <main id="main-container" class="flex-grow-1">
    {{-- === BREADCRUMB === --}}
    <div class="bg-body-extra-light">
      <div class="content content-boxed py-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ route('sp.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a class="link-fx" href="">Daftar Stakeholder</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              {{ isset($stakeholder) ? 'Edit' : 'Tambah' }} Stakeholder
            </li>
          </ol>
        </nav>
      </div>
    </div>
    
    <div class="content">
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">
            <i class="fa fa-pencil-alt me-1"></i> 
            {{ isset($stakeholder) ? 'Edit Pengaturan Stakeholder: ' . $stakeholder->name : 'Tambah Stakeholder Baru' }}
          </h3>
          <div class="block-options">
            <a href="" class="btn btn-sm btn-alt-secondary">
              <i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
          </div>
        </div>
    
        <div class="block-content fs-sm">
          <form id="dynamic-data-form" 
            {{-- PERBAIKAN KRITIS: Menentukan aksi form berdasarkan mode Create/Edit --}}
                action="{{ isset($stakeholder) ? route('sp.ea.stakeholder_update', $stakeholder->id) : route('sp.ea.stakeholder_store') }}" 
                method="POST" 
                enctype="multipart/form-data">    
            @csrf
            @if(isset($stakeholder)) 
              @method('PUT')
              <input type="hidden" name="id" value="{{ $stakeholder->id }}">
              <input type="hidden" name="component_name" value="{{ $target_component_name }}">
              <input type="hidden" name="component_id" value="{{ $target_component_id }}">
            @endif

            @if (!isset($stakeholder) && isset($target_component_name))
              <input type="hidden" name="component_name" value="{{ $target_component_name }}">
            @endif

            @if (!isset($stakeholder) && isset($target_component_id))
              <input type="hidden" name="component_id" value="{{ $target_component_id }}">
            @endif
                    
            <h4 class="content-heading pt-0">Informasi Dasar Stakeholder</h4>
                    
            {{-- === FIELD DATA DASAR STAKEHOLDER === --}}
            <div class="row">
              <div class="col-md-6 mb-4">
                <label for="stakeholder_name" class="form-label">Nama Stakeholder <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="stakeholder_name" name="name" placeholder="Masukkan nama stakeholder..." 
                          value="{{ old('name', $stakeholder->name ?? '') }}" required>
                  @error('name')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-4">
                <label for="dynamic_status" class="form-label">Status</label>
                @php $selected_status = old('status', $stakeholder->status ?? ''); @endphp
                <select class="form-select" id="dynamic_status" name="status" required>
                  <option selected disabled value="">Pilih Status</option>
                  <option value="Aktif" @if($selected_status == 'Aktif') selected @endif>Aktif</option>
                  <option value="Nonaktif" @if($selected_status == 'Nonaktif') selected @endif>Nonaktif</option>
                </select>
                @error('status')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
                    
            {{-- === FIELD EMAIL DAN PASSWORD BARU DITAMBAHKAN === --}}
            <div class="row">
              <div class="col-md-6 mb-4">
                <label for="stakeholder_email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="stakeholder_email" name="email" placeholder="Masukkan alamat email..." 
                        value="{{ old('email', $stakeholder->email ?? '') }}" required>
                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
                        
              {{-- Field Password (Wajib saat Create, Opsional saat Edit) --}}
              <div class="col-md-6 mb-4">
                <label for="stakeholder_password" class="form-label">
                  Password 
                  {{-- Tampilkan tanda wajib hanya jika mode CREATE --}}
                  @if(!isset($stakeholder)) <span class="text-danger">*</span> @else <span class="text-muted">(Kosongkan jika tidak diubah)</span> @endif
                </label>
                <input type="password" class="form-control" id="stakeholder_password" name="password" 
                        placeholder="{{ isset($stakeholder) ? 'Diisi jika ingin mengganti password' : 'Masukkan password...' }}" 
                        {{-- Hanya tambahkan atribut 'required' jika mode CREATE --}}
                        {{ !isset($stakeholder) ? 'required' : '' }}>
                @error('password')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
                    
            <div class="row">
              {{-- Field Konfirmasi Password (Hanya ditampilkan saat mode Create atau jika Password diisi) --}}
              <div class="col-md-6 mb-4">
                <label for="stakeholder_password_confirmation" class="form-label">
                  Konfirmasi Password
                  @if(!isset($stakeholder)) <span class="text-danger">*</span> @endif
                </label>
                <input type="password" class="form-control" id="stakeholder_password_confirmation" name="password_confirmation" 
                        placeholder="Ketik ulang password..."
                        {{ !isset($stakeholder) ? 'required' : '' }}>
                @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
                    
            <hr>
                    
            {{-- === 2. FIELD HAK AKSES MULTILEVEL (TIDAK BERUBAH) === --}}
            <div style="margin-bottom: 10px;">
              <label><input type="checkbox" id="checkAllDomain"> <b>Pilih Semua Domain</b></label> |
              <label><input type="checkbox" id="checkAllLihat"> Lihat</label>
              <label><input type="checkbox" id="checkAllCreate"> Create</label>
              <label><input type="checkbox" id="checkAllUpdate"> Update</label>
              <label><input type="checkbox" id="checkAllDelete"> Delete</label>
            </div>
                    
            @foreach($all_access_modules as $domain)
              <div class="domain-section">
                <div class="domain-header" data-target="#domain-body-{{ $domain->id }}">
                  <div>
                    <input type="checkbox" class="domain-check" data-domain="{{ $domain->id }}">
                      {{ $domain->name }}
                  </div>
                  <span class="chevron">▶</span>
                </div>
                    
                <div class="domain-body" id="domain-body-{{ $domain->id }}">
                  <table class="permission-table">
                    <thead>
                      <tr>
                        <th>Subdomain</th>
                        <th>Component</th>
                        <th>Lihat</th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($domain->subdomain as $sub)
                        <tr style="background:#fafafa;">
                          <td colspan="6">
                            <input type="checkbox" class="subdomain-check" data-domain="{{ $domain->id }}" data-subdomain="{{ $sub->id }}">
                            <i>{{ $sub->name }}</i>
                          </td>
                        </tr>
                        @foreach($sub->component as $comp)
                          @php
                            $existing = $existing_permissions[$comp->id] ?? [];
                          @endphp
                          <tr>
                            <td></td>
                            <td>
                              <input type="checkbox" class="component-check"
                                      data-domain="{{ $domain->id }}"
                                      data-subdomain="{{ $sub->id }}"
                                      data-component="{{ $comp->id }}"
                                      {{ !empty($existing) ? 'checked' : '' }}>
                              {{  $comp->name  }}
                            </td>
                            @foreach(['lihat','create','update','delete'] as $aksi)
                              <td>
                                <input type="checkbox"
                                        name="permissions[{{ $comp->id }}][]"
                                        value="{{ $aksi }}"
                                        class="access-check access-{{ $aksi }}"
                                        data-component="{{ $comp->id }}"
                                        {{ in_array($aksi, $existing) ? 'checked' : '' }}
                                        {{ empty($existing) ? 'disabled' : '' }}>
                              </td>
                            @endforeach
                          </tr>
                        @endforeach
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endforeach
            <hr>        
            {{-- Tombol Simpan --}}
            <div class="text-end border-top pt-3">
              <button type="submit" class="btn btn-primary" id="btn-submit-dynamic">
                <i class="fa fa-save me-1"></i> Simpan Data
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const accessTypes = ['lihat','create','update','delete'];
    
    // ===== COLLAPSE HANDLER =====
    document.querySelectorAll('.domain-header').forEach(header => {
      header.addEventListener('click', function(e) {
        // jangan trigger collapse kalau klik checkbox
        if (e.target.tagName.toLowerCase() === 'input') return;
        const body = document.querySelector(this.dataset.target);
        const chevron = this.querySelector('.chevron');
        const isVisible = body.style.display === 'block';
        body.style.display = isVisible ? 'none' : 'block';
        chevron.classList.toggle('rotate', !isVisible);
      });
    });
    
    // ===== CHECKBOX LOGIC =====
    function toggleAccessForComponent(compId, enabled, autoCheck = false) {
      document.querySelectorAll(`[data-component="${compId}"].access-check`).forEach(acc => {
        acc.disabled = !enabled;
        if (enabled && autoCheck) acc.checked = true;
        if (!enabled) acc.checked = false;
      });
    }
    
    // Check All Domain
    const checkAllDomain = document.getElementById('checkAllDomain');
    if (checkAllDomain) {
      checkAllDomain.addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll('.domain-check, .subdomain-check, .component-check').forEach(el => el.checked = checked);
        document.querySelectorAll('.access-check').forEach(acc => {
          acc.disabled = !checked;
          if (checked) acc.checked = true;
          else acc.checked = false;
        });
      });
    }
    
    // Domain → Subdomain & Component
    document.querySelectorAll('.domain-check').forEach(dom => {
      dom.addEventListener('change', function() {
        const domainId = this.dataset.domain;
        const checked = this.checked;
        document.querySelectorAll(`[data-domain="${domainId}"]`).forEach(el => {
          el.checked = checked;
          if (el.classList.contains('access-check')) {
            el.disabled = !checked;
            if (checked) el.checked = true;
          else el.checked = false;
          }
        });
        document.querySelectorAll(`[data-domain="${domainId}"].component-check`).forEach(comp => {
          toggleAccessForComponent(comp.dataset.component, checked, checked);
        });
      });
    });
    
    // Subdomain → Component
    document.querySelectorAll('.subdomain-check').forEach(sub => {
      sub.addEventListener('change', function() {
        const subId = this.dataset.subdomain;
        const checked = this.checked;
        document.querySelectorAll(`[data-subdomain="${subId}"].component-check`).forEach(comp => {
          comp.checked = checked;
          toggleAccessForComponent(comp.dataset.component, checked, checked);
        });
      });
    });
    
    // Component → Access
    document.querySelectorAll('.component-check').forEach(comp => {
      comp.addEventListener('change', function() {
        toggleAccessForComponent(this.dataset.component, this.checked);
      });
    });
    
    // Check All per Access Column
    accessTypes.forEach(type => {
      const el = document.getElementById(`checkAll${type.charAt(0).toUpperCase() + type.slice(1)}`);
      if (!el) return;
      el.addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll(`.access-${type}`).forEach(acc => {
          if (!acc.disabled) acc.checked = checked;
        });
      });
    });
  });
</script>
    