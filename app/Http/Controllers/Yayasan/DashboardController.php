<?php

namespace App\Http\Controllers\Yayasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('yayasan.dashboard');
    }
}
