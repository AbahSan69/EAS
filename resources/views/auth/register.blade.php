<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>EAS Register</title>
        <meta name="description" content="EAS Register">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="index, follow">
        <link rel="shortcut icon" href="{{ asset('oneui/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('oneui/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('oneui/media/favicons/apple-touch-icon-180x180.png') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('oneui/css/oneui.min.css') }}"><link id="css-theme" rel="stylesheet" href="{{ asset('oneui/css/themes/amethyst.min.css') }}">
    </head>
    <body>
        @include('sweetalert::alert')
        <div id="page-container">
            <main id="main-container">
                <div class="hero-static d-flex align-items-center">
                    <div class="w-100">
                        <div class="bg-body-extra-light">
                            <div class="content content-full">
                                <div class="row g-0 justify-content-center">
                                    {{-- Mengubah lebar kolom utama agar bisa menampung 3 kolom internal --}}
                                    <div class="col-md-11 col-lg-10 col-xl-9 py-4 px-4 px-lg-5"> 
                                        <div class="text-center">
                                            <p class="mb-2">
                                                <i class="fa fa-2x fa-university text-primary"></i>
                                            </p>
                                            <h1 class="h4 mb-1">
                                                Pendaftaran Institusi EAS
                                            </h1>
                                            <p class="text-muted mb-3">
                                                Daftarkan Organisasi Anda dan kedua akun admin dalam satu halaman.
                                            </p>
                                        </div>
                                        
                                        <form class="js-validation-signup" action="{{ route('register') }}" method="POST">
                                            @csrf
                                            
                                            {{-- CONTAINER UTAMA TIGA KOLOM SEJAJAR --}}
                                            <div class="row">
                                                
                                                {{-- KOLOM 1: DATA ORGANISASI & UNIT --}}
                                                <div class="col-lg-4"> 
                                                    <h5 class="fw-bold text-primary mb-3 mt-4 border-bottom pb-1">1. Data Organisasi & Unit</h5>
                                                    <p class="text-muted fs-sm mb-3">Masukkan nama entitas induk dan unit pelaksana Anda.</p>
                                                    
                                                    <div class="mb-4">
                                                        <label class="form-label" for="yayasan_name">Nama Yayasan/Organisasi Induk</label>
                                                        <input type="text" class="form-control form-control-lg form-control-alt" id="yayasan_name" name="yayasan_name" placeholder="Contoh: Yayasan Pendidikan Mulia" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="campus_name">Nama Universitas/Unit Kerja</label>
                                                        <input type="text" class="form-control form-control-lg form-control-alt" id="campus_name" name="campus_name" placeholder="Contoh: Universitas Teknologi Mulia" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="jenis_pts">Jenis Perguruan Tinggi (PT)</label>
                                                        <select class="form-select form-control-lg form-control-alt" id="jenis_pts" name="jenis_pts" required>
                                                            <option value="" disabled selected>Pilih Jenis PT</option>
                                                            <option value="Universitas">Universitas</option>
                                                            <option value="Institut">Institut</option>
                                                            <option value="Sekolah Tinggi">Sekolah Tinggi</option>
                                                            <option value="Politeknik">Politeknik</option>
                                                            <option value="Akademi">Akademi</option>
                                                            <option value="Akademi Komunitas">Akademi Komunitas</option>
                                                            <option value="Lainnya">Lainnya</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="campus_name">Kode Universitas</label>
                                                        <input type="text" class="form-control form-control-lg form-control-alt" id="campus_code" name="campus_code" placeholder="Contoh: 1234" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="campus_name">Tahun Lahir Perguruan Tinggi</label>
                                                        <input type="text" class="form-control form-control-lg form-control-alt" id="campus_year" name="campus_year" placeholder="Contoh: 2025" required>
                                                    </div>
                                                </div>
                                                
                                                {{-- KOLOM 2: AKUN ADMIN UNIVERSITAS & YAYASAN --}}
                                                <div class="col-lg-4"> 
                                                    <h5 class="fw-bold text-success mb-3 mt-4 border-bottom pb-1">2. Akun Admin Universitas & Yayasan</h5>
                                                    <p class="text-muted fs-sm mb-3">Informasi kontak untuk kedua akun administrator.</p>
                                                    
                                                    <div class="mb-4">
                                                        <label class="form-label" for="campus_admin_name">Nama Lengkap Admin Universitas</label>
                                                        <input type="text" class="form-control form-control-lg form-control-alt" id="campus_admin_name" name="campus_admin_name" placeholder="Nama Admin Universitas" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="campus_admin_email">Email Admin Universitas</label>
                                                        <input type="email" class="form-control form-control-lg form-control-alt" id="campus_admin_email" name="campus_admin_email" placeholder="Email Login Admin Universitas" required>
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <label class="form-label" for="yayasan_admin_name">Nama Lengkap Admin Yayasan</label>
                                                        <input type="text" class="form-control form-control-lg form-control-alt" id="yayasan_admin_name" name="yayasan_admin_name" placeholder="Nama Admin Yayasan" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="yayasan_admin_email">Email Admin Yayasan</label>
                                                        <input type="email" class="form-control form-control-lg form-control-alt" id="yayasan_admin_email" name="yayasan_admin_email" placeholder="Email Login Admin Yayasan" required>
                                                    </div>
                                                </div>
                                                
                                                {{-- KOLOM 3: PASSWORD AKSES --}}
                                                <div class="col-lg-4"> 
                                                    <h5 class="fw-bold text-warning mb-3 mt-4 border-bottom pb-1">3. Password Akses</h5>
                                                    <p class="text-muted fs-sm mb-3">Password ini akan digunakan oleh kedua akun admin.</p>

                                                    <div class="mb-4">
                                                        <label class="form-label" for="password">Password</label>
                                                        <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password" placeholder="Password (Min. 8 Karakter)" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label" for="konfirmasi_password">Konfirmasi Password</label>
                                                        <input type="password" class="form-control form-control-lg form-control-alt" id="konfirmasi_password" name="password_confirmation" placeholder="Ulangi Password" required>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            {{-- AKHIR CONTAINER UTAMA TIGA KOLOM SEJAJAR --}}

                                            {{-- TOMBOL SUBMIT DI BAWAH SEMUA BAGIAN --}}
                                            <div class="row justify-content-center mt-4">
                                                <div class="col-lg-8">
                                                    <button type="submit" id="btn-register" class="btn w-100 btn-alt-success" disabled>
                                                        <i class="fa fa-fw fa-plus me-1 opacity-50"></i> Daftarkan Institusi
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        {{-- Tambahkan tautan ke halaman login --}}
                                        <div class="mt-4 text-center">
                                            <a class="link-fx fs-sm" href="{{ route('login') }}">Sudah punya akun? Login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-sm text-center text-muted py-3">
                            <strong>Created By</strong> © <span data-toggle="year-copy" class="js-year-copy-enabled">2025</span>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <script src="{{ asset('oneui/js/oneui.app.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            var passwordField = document.getElementById("password");
            var confirmPasswordField = document.getElementById("konfirmasi_password");
            var buttonSubmit = document.getElementById("btn-register");
            
            buttonSubmit.disabled = true;

            passwordField.addEventListener("input", validatePasswords);
            confirmPasswordField.addEventListener("input", validatePasswords);
            
            function validatePasswords() {
                var password = passwordField.value;
                var confirmPassword = confirmPasswordField.value;
            
                if (password.length >= 8 && password === confirmPassword) { 
                    confirmPasswordField.style.borderColor = "green";
                    buttonSubmit.disabled = false;
                } else {
                    if (confirmPassword.length > 0) {
                        confirmPasswordField.style.borderColor = "red";
                    } else {
                        confirmPasswordField.style.borderColor = "";
                    }
                    buttonSubmit.disabled = true;
                }
            }
        </script>
    </body>
</html>