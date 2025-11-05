<?php

namespace App\Http\Controllers\Admin\EA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\SubDomain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class SubKomponenDetailController extends Controller
{
    public function index($id, Request $request)
{
    // Ambil domain berdasarkan ID
    $subdomain = Subdomain::with(['component' => function ($q) use ($request) {
        // Jika ada pencarian, filter di dalam relasi
        if ($request->filled('search')) {
            $search = $request->search;
            $q->where('name', 'like', "%{$search}%");
        }
    }])->findOrFail($id);

    // Ambil hasil relasi yang sudah difilter
    $subkomponendetail = $subdomain->component;

    // Kirim ke view
    return view('admin.ea.komponen.subkomponen', compact('subkomponendetail', 'subdomain'));
}


    public function save_subkomponen(Request $request)
{
    $domain_id = $request->domain_id;
    $validator = Validator::make($request->all(), [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    DB::beginTransaction();

    try {
        SubDomain::create([
            'domain_id'   => $domain_id,
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

    public function update_subkomponen(Request $request)
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
            $subdomain = SubDomain::findOrFail($id);

            $data = [
                'name'  => $request->name,
                'description' => $request->description,
            ];

            $subdomain->update($data);

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

    public function delete_subkomponen($id)
    {
        $subdomain = SubDomain::find($id);

        if (!$subdomain) {
            return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        }

        $subdomain->delete();
        return redirect()->back()
                         ->with('toast_success', 'Data Berhasil Dihapus!');
    }
}
