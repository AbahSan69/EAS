<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\University;
use App\Models\RoleDetails;
use Exception;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function halaman_login()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'Field Email atau Username wajib diisi.',
            'password.required' => 'Field Password wajib diisi.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $user = User::where(function ($query) use ($request) {
                $query->where('name', $request->name)
                  ->orWhere('email', $request->name);
                })
                ->first();

    
        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Login berhasil, arahkan ke halaman dashboard
            Auth::loginUsingId($user->id);
            return redirect()->intended('/dashboard')->with('toast_success', 'Berhasil login!');
        }
    
        // Jika login gagal
        return redirect('/')->with('toast_error', 'Nama atau password salah!');
    }

    public function halaman_register()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        // --- Bagian 1: Data Organisasi & Unit ---
        'yayasan_name' => ['required', 'string', 'max:255'],
        'campus_name' => ['required', 'string', 'max:255', 'unique:universities,name'],
        'jenis_pts' => ['required', 'string', Rule::in([
            'Universitas', 'Institut', 'Sekolah Tinggi', 'Politeknik', 'Akademi', 'Akademi Komunitas', 'Lainnya'
        ])],
        'campus_code' => ['nullable', 'string', 'max:50'],
        'campus_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],

        // --- Bagian 2: Akun Admin Universitas & Yayasan ---
        'campus_admin_name' => ['required', 'string', 'max:255'],
        'campus_admin_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],

        'yayasan_admin_name' => ['required', 'string', 'max:255'],
        'yayasan_admin_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],

        // --- Bagian 3: Password Akses ---
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'password_confirmation' => ['required'],
    ]);

    if ($validator->fails()) {
        return redirect('register')->withErrors($validator)->withInput();
    }

    if ($request->campus_admin_email === $request->yayasan_admin_email) {
        return redirect()->back()->withErrors([
            'yayasan_admin_email' => 'Email Yayasan tidak boleh sama dengan Admin Universitas.'
        ])->withInput();
    }

    DB::beginTransaction();

    try {
        // Simpan Universitas
        $university = University::create([
            'name' => $request->campus_name,
            'type' => $request->jenis_pts,
            'code' => $request->campus_code,
            'estabilished_year' => $request->campus_year,
        ]);

        // Buat Role Detail
        $role_detail_admin = RoleDetails::create([
            'role_id' => 2,
            'university_id' => $university->id,
            'name' => 'Admin Universitas',
            'position' => 'Admin Universitas',
        ]);

        $role_detail_yayasan = RoleDetails::create([
            'role_id' => 3,
            'university_id' => $university->id,
            'name' => 'Yayasan',
            'position' => 'Yayasan',
        ]);

        // Buat Akun Admin Kampus
        $userAdminKampus = User::create([
            'role_detail_id' => $role_detail_admin->id,
            'name' => $request->campus_admin_name,
            'email' => $request->campus_admin_email,
            'password' => Hash::make($request->password),
        ]);

        // Buat Akun Admin Yayasan
        $userAdminYayasan = User::create([
            'role_detail_id' => $role_detail_yayasan->id,
            'name' => $request->yayasan_admin_name,
            'email' => $request->yayasan_admin_email,
            'password' => Hash::make($request->password),
        ]);

        DB::commit();

        return redirect()->route('halaman_login')
            ->with('toast_success', 'Registrasi berhasil! Silakan login menggunakan akun Anda.');
    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Register gagal: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
    }
}


    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session to ensure security
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect to the login page with a success message
        return redirect('/')->with('toast_success', 'Berhasil Logout.');
    }
}
