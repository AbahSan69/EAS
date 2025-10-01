<?php

namespace App\Http\Controllers\StakeholderPTS\EA\AAplikasi;

use App\Http\Controllers\Controller;
use App\Models\SPAplikasi;
use App\Models\SPAplikasiHistory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Exception;

class AplikasiController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPAplikasi::with([
            // ambil history terbaru + user yang update
            'latestHistory.updatedBy',
            // ambil semua history kalau mau ditampilkan juga
            'histories.updatedBy',
            // ambil komentar + user
            'aplikasi_comments.user'
            ])
            ->where('pts_id', $id_pts);

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // cari di judul aplikasi
                $q->where('title', 'like', "%{$search}%")
                // cari di history (content)
                ->orWhereHas('histories', function ($qh) use ($search) {
                  $qh->where('content', 'like', "%{$search}%");
                });
            });
        }

        $aplikasi = $query->get();

        return view('stakeholder_pts.ea.a_aplikasi.show', compact('id_pts', 'aplikasi'));
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
            $aplikasi = SPAplikasi::create([
                'user_id'   => Auth::id(),
                'pts_id'    => $request->id_pts,
                'title'     => $request->title,
            ]);

            // ✅ Simpan gambar (jika ada)
            $imagePath = null;
            // if ($request->hasFile('image')) {
            // simpan ke folder aplikasi_images/{id_pts}
            //     $imagePath = $request->file('image')
            //         ->store("aplikasi_images/{$request->id_pts}", 'public');
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("aplikasi_images/{$request->id_pts}/{$aplikasi->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "aplikasi_images/{$request->id_pts}/{$aplikasi->id}/{$fileName}";
            }

            // ✅ Simpan ke history
            SPaplikasiHistory::create([
                'sp_aplikasi_id' => $aplikasi->id,
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
            'id'      => 'required|integer|exists:sp_architecture_aplikasi,id',
            'title'   => 'required|string|max:255',
            'status'  => 'required|in:Proses,Selesai',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $aplikasi = SPAplikasi::findOrFail($request->id);

            // ✅ Kelola gambar
            $imagePath = null;
            // if ($request->hasFile('image')) {
            //     // hapus gambar lama kalau ada
            //     if ($aplikasi->image && \Storage::disk('public')->exists($aplikasi->image)) {
            //         \Storage::disk('public')->delete($aplikasi->image);
            //     }
        
            //     // simpan gambar baru ke folder sesuai PTS
            //     $imagePath = $request->file('image')
            //         ->store("aplikasi_images/{$request->id_pts}", 'public');
        
            //     $aplikasi->image = $imagePath;
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("aplikasi_images/{$request->id_pts}/{$aplikasi->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "aplikasi_images/{$request->id_pts}/{$aplikasi->id}/{$fileName}";
            }

            // ✅ Tambah history baru
            SPAplikasiHistory::create([
                'sp_aplikasi_id' => $aplikasi->id,
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
            $aplikasi = SPAplikasi::findOrFail($id);

            // ✅ Hapus semua file gambar dari setiap history
            foreach ($aplikasi->histories as $history) {
                if ($history->image && file_exists(public_path($history->image))) {
                    @unlink(public_path($history->image));
                }
            }

            // ✅ Hapus folder aplikasi_images/{pts_id}/{aplikasi_id}
            $folder = public_path("aplikasi_images/{$aplikasi->pts_id}/{$aplikasi->id}");
            if (File::exists($folder)) {
                File::deleteDirectory($folder);
            }                        

            // ✅ Hapus master (otomatis hapus history karena foreign key cascade)
            $aplikasi->delete();

            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
