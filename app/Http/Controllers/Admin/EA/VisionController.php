<?php

namespace App\Http\Controllers\Admin\EA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisionController extends Controller
{
    public function show()
    {
        return view('admin.ea.vision.show');
    }
}
