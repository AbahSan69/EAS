<?php

namespace App\Http\Controllers\Admin\EA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuBDomain;
use App\Models\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class ComponentController extends Controller
{
    public function index($id, Request $request)
{
    $domain = $id;
    // Ambil domain berdasarkan ID
    $subdomain = SubDomain::with(['component' => function ($q) use ($request) {
        // Jika ada pencarian, filter di dalam relasi
        if ($request->filled('search')) {
            $search = $request->search;
            $q->where('name', 'like', "%{$search}%");
        }
    }])->findOrFail($id);

    // Ambil hasil relasi yang sudah difilter
    $component = $subdomain->component;

    // Kirim ke view
    return view('admin.ea.component', compact('component', 'subdomain','domain'));
}


    public function save_component(Request $request)
{
    $subdomain_id = $request->domain_id;
    $validator = Validator::make($request->all(), [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    DB::beginTransaction();

    try {
        Component::create([
            'subdomain_id'   => $subdomain_id,
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

    public function update_component(Request $request)
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
            $component = Component::findOrFail($id);

            $data = [
                'name'  => $request->name,
                'description' => $request->description,
            ];

            $component->update($data);

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

    public function delete_component($id)
    {
        $component = Component::find($id);

        if (!$component) {
            return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        }

        $component->delete();
        return redirect()->back()
                         ->with('toast_success', 'Data Berhasil Dihapus!');
    }
}
