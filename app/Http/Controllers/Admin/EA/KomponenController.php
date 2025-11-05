<?php

namespace App\Http\Controllers\Admin\EA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class KomponenController extends Controller
{
    public function index(Request $request)
    {
         // Mulai query
         $query = Domain::query();

         // Jika ada pencarian
         if ($request->filled('search')) {
             $search = $request->search;
 
             $query->where(function ($q) use ($search) {
                 $q->where('name', 'like', "%{$search}%");
             });
         }
 
        $komponen = $query->get();
        return view('admin.ea.komponen.index', compact('komponen'));
    }

    public function save_komponen(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    DB::beginTransaction();

    try {
        Domain::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        DB::commit();

        return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan!');
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
    }
}

    public function update_komponen(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name'  => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $domain = Domain::findOrFail($id);

            $data = [
                'name'  => $request->name,
                'description' => $request->description,
            ];

            $domain->update($data);

            DB::commit();

            return redirect()->back()
                         ->with('toast_success', 'Data berhasil diperbarui!')
                         ->with('activeTab', 'akun');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                         ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                         ->with('activeTab', 'akun');
        }
    }

    public function delete_komponen($id)
    {
        $domain = Domain::find($id);

        if (!$domain) {
            return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        }

        $domain->delete();
        return redirect()->route('admin.ea.komponen.komponen')
                         ->with('toast_success', 'Data Berhasil Dihapus!');
    }
}
