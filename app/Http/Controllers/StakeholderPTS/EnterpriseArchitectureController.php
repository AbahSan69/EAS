<?php

namespace App\Http\Controllers\StakeholderPTS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pts;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class EnterpriseArchitectureController extends Controller
{
    public function create()
    {
        return view('stakeholder_pts.ea.create');
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
                'user_id' => Auth::id(),
                'nama'    => $request->nama,
                'jenis' => $request->jenis,
            ]);

            // $pts = DB::table('pts')->insertGetId([
            //     'user_id'    => Auth::id(),   // otomatis ambil user yang login
            //     'nama'       => $request->nama,
            //     'jenis'      => $request->jenis,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);

            DB::commit();

            return redirect()->route('sp.progress.index', $pts)
                         ->with('toast_success', 'Data berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function index($id)
    {
        $id_pts = $id;
        return view('stakeholder_pts.ea.index', compact('id_pts'));
    }
}
