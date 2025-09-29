<?php

namespace App\Http\Controllers\StakeholderPTS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('stakeholder_pts.dashboard');
    }
}
