<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $roleRoutes = [
            '1' => 'admin.dashboard_admin',
            '2' => 'sp.dashboard',
            '3' => 'yayasan.dashboard',
        ];

        $userRole = Auth::user()->role_id;

        // Redirect ke dashboard sesuai role atau tampilkan 403 jika role tidak dikenali
        return isset($roleRoutes[$userRole])
            ? redirect()->route($roleRoutes[$userRole])
            : abort(403, 'Role tidak dikenali!');
    }
}
