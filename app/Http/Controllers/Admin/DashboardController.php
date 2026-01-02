<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\University;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $domain = Domain::all();

        return view('admin.dashboard', [
            'domain' => $domain,
            'totalUniversity' => University::count(),
            'totalDomain' => Domain::count(),
        ]);
    }
}
