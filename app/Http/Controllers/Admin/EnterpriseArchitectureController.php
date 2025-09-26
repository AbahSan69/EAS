<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Auth;

class EnterpriseArchitectureController extends Controller
{
    public function create()
    {
        return view('admin.ea.create');
    }

    public function store_pts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'jenis'    => 'required',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $pts = Pts::create([
                'user_id' => Auth::user()->id,
                'nama'    => $request->nama,
                'jenis' => $request->jenis,
            ]);

            DB::commit();

            return redirect()->route('admin.ea.index', $pts->id)
                         ->with('toast_success', 'Data berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function index($id)
    {
        $id_pts = $id;
        return view('admin.ea.index', compact('id_pts'));
    }
}
