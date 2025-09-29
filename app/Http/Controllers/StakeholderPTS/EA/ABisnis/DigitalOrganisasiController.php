<?php

namespace App\Http\Controllers\StakeholderPTS\EA\ABisnis;

use App\Http\Controllers\Controller;
use App\Models\SPBisnis;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

class DigitalOrganisasiController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPBisnis::with(['bisnis_comments.user'])
                ->where('pts_id', $id_pts)
                ->where('bisnis_id', 1);

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $bisnis = $query->get();
        return view('stakeholder_pts.ea.a_bisnis.digital_organisasi.show', compact('id_pts','bisnis'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'status' => 'required',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imagePath = null;
        // if ($request->hasFile('image')) {
        //     // simpan ke folder bisnis_images/{id_pts}
        //     $imagePath = $request->file('image')
        //         ->store("bisnis_images/{$request->id_pts}", 'public');
        // }

        $folder = public_path("bisnis_images/{$request->id_pts}");
        if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
        }

        $fileName = time().'_'.$request->file('image')->getClientOriginalName();
        $request->file('image')->move($folder, $fileName);

        $imagePath = "bisnis_images/{$request->id_pts}/{$fileName}";

        DB::beginTransaction();

        try {
            SPBisnis::create([
                'user_id'  => Auth::id(),
                'pts_id'     => $request->id_pts,
                'bisnis_id' => 1,
                'title'    => $request->title,
                'content' => $request->content,
                'status' => $request->status,
                'image'   => $imagePath,
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
        $id_bisnis = $request->id;

        $validator = Validator::make($request->all(), [
            'title'  => 'required',
            'status' => 'required',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $bisnis = SPBisnis::findOrFail($id_bisnis);

            // if ($request->hasFile('image')) {
            //     // hapus gambar lama kalau ada
            //     if ($bisnis->image && \Storage::disk('public')->exists($bisnis->image)) {
            //         \Storage::disk('public')->delete($bisnis->image);
            //     }
        
            //     // simpan gambar baru ke folder sesuai PTS
            //     $imagePath = $request->file('image')
            //         ->store("bisnis_images/{$request->id_pts}", 'public');
        
            //     $bisnis->image = $imagePath;
            // }

            $imagePath = $bisnis->image; // default pakai gambar lama
            if ($request->hasFile('image')) {
                // hapus gambar lama
                if ($bisnis->image && file_exists(public_path($bisnis->image))) {
                    unlink(public_path($bisnis->image));
                }

                $folder = public_path("bisnis_images/{$request->id_pts}");
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time().'_'.$request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "bisnis_images/{$request->id_pts}/{$fileName}";
            }

            $data = [
                'title'  => $request->title,
                'content' => $request->content,
                'status' => $request->status,
                'image' => $imagePath
            ];

            $bisnis->update($data);

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
        $bisnis = SPBisnis::find($id);

        DB::beginTransaction();
        try {
            // hapus file gambar dari public
            if ($bisnis->image && file_exists(public_path($bisnis->image))) {
                unlink(public_path($bisnis->image));
            }

            $bisnis->delete();
            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }

        // if (!$bisnis) {
        //     return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        // }

        // if ($bisnis->image && \Storage::disk('public')->exists($bisnis->image)) {
        //     \Storage::disk('public')->delete($bisnis->image);
        // }

        // $bisnis->delete();
        // return redirect()->back()
        //                  ->with('toast_success', 'Data Berhasil Dihapus!');
    }
}
