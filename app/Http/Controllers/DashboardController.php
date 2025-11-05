<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $roleRoutes = [
            'Super Admin' => 'admin.dashboard_admin',
            'Stakeholder PTS' => 'sp.dashboard',
            'Yayasan' => 'yayasan.dashboard',
        ];

        $userRole = Auth::user()->detail_role->role?->name;

        // Redirect ke dashboard sesuai role atau tampilkan 403 jika role tidak dikenali
        return isset($roleRoutes[$userRole])
            ? redirect()->route($roleRoutes[$userRole])
            : abort(403, 'Role tidak dikenali!');
    }
}
