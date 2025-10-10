<?php

namespace App\Http\Controllers\Admin\EA\ABisnis;

use App\Http\Controllers\Controller;
use App\Models\SPBisnis;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SPBisnisHistory;
use Illuminate\Support\Facades\File;
use Exception;

class AccountabilityController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPBisnis::with([
            // ambil history terbaru + user yang update
            'latestHistory.updatedBy',
            // ambil semua history kalau mau ditampilkan juga
            'histories.updatedBy',
            // ambil komentar + user
            'bisnis_comments.user'
            ])
            ->where('pts_id', $id_pts)
            ->where('bisnis_id', 3);

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // cari di judul bisnis
                $q->where('title', 'like', "%{$search}%")
                // cari di history (content)
                ->orWhereHas('histories', function ($qh) use ($search) {
                  $qh->where('content', 'like', "%{$search}%");
                });
            });
        }

        $bisnis = $query->get();

        return view('admin.ea.a_bisnis.accountability.show', compact('id_pts', 'bisnis'));
    }

    public function save(Request $request)
    {
        // ✅ Validasi input
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:255',
            'status'  => 'required|in:Proses,Selesai',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_pts'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // ✅ Simpan master
            $bisnis = SPBisnis::create([
                'user_id'   => Auth::id(),
                'pts_id'    => $request->id_pts,
                'bisnis_id' => 3,
                'title'     => $request->title,
            ]);

            // ✅ Simpan gambar (jika ada)
            $imagePath = null;
            // if ($request->hasFile('image')) {
            // simpan ke folder bisnis_images/{id_pts}
            //     $imagePath = $request->file('image')
            //         ->store("bisnis_images/{$request->id_pts}", 'public');
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("bisnis_images/{$request->id_pts}/{$bisnis->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "bisnis_images/{$request->id_pts}/{$bisnis->id}/{$fileName}";
            }

            // ✅ Simpan ke history
            SPBisnisHistory::create([
                'sp_bisnis_id' => $bisnis->id,
                'content'      => $request->content,
                'image'        => $imagePath,
                'status'       => $request->status,
                'updated_by'    => Auth::id(),
            ]);

            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'      => 'required|integer|exists:sp_architecture_bisnis,id',
            'title'   => 'required|string|max:255',
            'status'  => 'required|in:Proses,Selesai',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $bisnis = SPBisnis::findOrFail($request->id);

            // ✅ Kelola gambar
            $imagePath = null;
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
            if ($request->hasFile('image')) {
                $folder = public_path("bisnis_images/{$request->id_pts}/{$bisnis->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "bisnis_images/{$request->id_pts}/{$bisnis->id}/{$fileName}";
            }

            // ✅ Tambah history baru
            SPBisnisHistory::create([
                'sp_bisnis_id' => $bisnis->id,
                'content'      => $request->content,
                'image'        => $imagePath,
                'status'       => $request->status,
                'updated_by'    => Auth::id(),
            ]);

            DB::commit();

            return redirect()->back()
                ->with('toast_success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $bisnis = SPBisnis::findOrFail($id);

            // ✅ Hapus semua file gambar dari setiap history
            foreach ($bisnis->histories as $history) {
                if ($history->image && file_exists(public_path($history->image))) {
                    @unlink(public_path($history->image));
                }
            }

            // ✅ Hapus folder bisnis_images/{pts_id}/{bisnis_id}
            $folder = public_path("bisnis_images/{$bisnis->pts_id}/{$bisnis->id}");
            if (File::exists($folder)) {
                File::deleteDirectory($folder);
            }                        

            // ✅ Hapus master (otomatis hapus history karena foreign key cascade)
            $bisnis->delete();

            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
