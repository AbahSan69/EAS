<?php

namespace App\Http\Controllers\Admin\EA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\University;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query
        $query = University::query();

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $university = $query->get();

        return view('admin.ea.university.index', compact('university'));
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|unique:universities,name',
            'type'    => 'required',
            'code' => 'required',
            'estabilished_year'  => 'required',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {

            University::create([
                'name'     => $request->name,
                'type'    => $request->type,
                'code' => $request->code,
                'estabilished_year' => $request->estabilished_year
            ]);

            DB::commit();

            return redirect()->back()
                         ->with('toast_success', 'Data berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request)
    {
        $id_university = $request->id;

        $validator = Validator::make($request->all(), [
            'name'     => 'required|unique:universities,name',
            'type'    => 'required',
            'code' => 'required',
            'estabilished_year'  => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $university = University::findOrFail($id_university);

            $data = [
                'name'     => $request->name,
                'type'    => $request->type,
                'code' => $request->code,
                'estabilished_year' => $request->estabilished_year
            ];

            $university->update($data);

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

    public function delete($id)
    {
        $user = University::find($id);

        if (!$user) {
            return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        }

        $user->delete();
        return redirect()->route('admin.ea.university.show')
                         ->with('toast_success', 'Data Berhasil Dihapus!');
    }
}
