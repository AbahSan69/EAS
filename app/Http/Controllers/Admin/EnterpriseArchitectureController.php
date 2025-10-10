<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class EnterpriseArchitectureController extends Controller
{
    public function create(Request $request)
    {
        $query = Pts::query();

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('jenis', 'like', "%{$search}%");
            });
        }

        $pts = $query->get();
        return view('admin.ea.create', compact('pts'));
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

            return redirect()->route('admin.progress.index', $pts->id)
                         ->with('toast_success', 'Data berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete_pts($id)
    {
        $pts = Pts::find($id);

        if (!$pts) {
            return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        }

        $pts->delete();
        return redirect()->route('admin.ea.create')
                         ->with('toast_success', 'Data Berhasil Dihapus!');
    }

    public function index($id)
    {
        $id_pts = $id;
        return view('admin.ea.index', compact('id_pts'));
    }
}
