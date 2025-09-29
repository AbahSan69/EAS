<?php

namespace App\Http\Controllers\Yayasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProgressMonitoringController extends Controller
{
    public function load()
    {
        $pts = Pts::all();     // ambil banyak data
        return view('yayasan.load', compact('pts'));
    }

    public function load_pts(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_pts'     => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $id_pts = $request->id_pts;

            $pts = Pts::findOrFail($id_pts);
            if($pts)
            {
                return redirect()->route('yayasan.index', $pts->id)
                         ->with('toast_success', 'Selamat Datang Kembali!');
            }else
            {
                return redirect()->route('yayasan.load')
                         ->with('toast_error', 'Terjadi Kesalahan!');
            }
    }

    public function index($id)
    {
        $pts = Pts::findOrFail($id);
        return view('yayasan.index', compact('pts'));
    }
}
