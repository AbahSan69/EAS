<?php

namespace App\Http\Controllers\Admin\EA\AKeamanan;

use App\Http\Controllers\Controller;
use App\Models\SPKeamanan;
use App\Models\SPKeamananHistory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

class KeamananController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPKeamanan::with([
            // ambil history terbaru + user yang update
            'latestHistory.updatedBy',
            // ambil semua history kalau mau ditampilkan juga
            'histories.updatedBy',
            // ambil komentar + user
            'keamanan_comments.user'
            ])
            ->where('pts_id', $id_pts);

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // cari di judul keamanan
                $q->where('title', 'like', "%{$search}%")
                // cari di history (content)
                ->orWhereHas('histories', function ($qh) use ($search) {
                  $qh->where('content', 'like', "%{$search}%");
                });
            });
        }

        $keamanan = $query->get();

        return view('admin.ea.a_keamanan.show', compact('id_pts', 'keamanan'));
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
            $keamanan = SPKeamanan::create([
                'user_id'   => Auth::id(),
                'pts_id'    => $request->id_pts,
                'title'     => $request->title,
            ]);

            // ✅ Simpan gambar (jika ada)
            $imagePath = null;
            // if ($request->hasFile('image')) {
            // simpan ke folder keamanan_images/{id_pts}
            //     $imagePath = $request->file('image')
            //         ->store("keamanan_images/{$request->id_pts}", 'public');
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("keamanan_images/{$request->id_pts}/{$keamanan->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "keamanan_images/{$request->id_pts}/{$keamanan->id}/{$fileName}";
            }

            // ✅ Simpan ke history
            SPKeamananHistory::create([
                'sp_keamanan_id' => $keamanan->id,
                'content'      => $request->content,
                'image'        => $imagePath,
                'status'       => $request->status,
                'updated_by'    => Auth::id(),
            ]);

            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error simpan teknologi: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);
        
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }     
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'      => 'required|integer|exists:sp_architecture_keamanan,id',
            'title'   => 'required|string|max:255',
            'status'  => 'required|in:Proses,Selesai',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $keamanan = SPkeamanan::findOrFail($request->id);

            // ✅ Kelola gambar
            $imagePath = null;
            // if ($request->hasFile('image')) {
            //     // hapus gambar lama kalau ada
            //     if ($keamanan->image && \Storage::disk('public')->exists($keamanan->image)) {
            //         \Storage::disk('public')->delete($keamanan->image);
            //     }
        
            //     // simpan gambar baru ke folder sesuai PTS
            //     $imagePath = $request->file('image')
            //         ->store("keamanan_images/{$request->id_pts}", 'public');
        
            //     $keamanan->image = $imagePath;
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("keamanan_images/{$request->id_pts}/{$keamanan->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "keamanan_images/{$request->id_pts}/{$keamanan->id}/{$fileName}";
            }

            // ✅ Tambah history baru
            SPKeamananHistory::create([
                'sp_keamanan_id' => $keamanan->id,
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
            $keamanan = SPKeamanan::findOrFail($id);

            // ✅ Hapus semua file gambar dari setiap history
            foreach ($keamanan->histories as $history) {
                if ($history->image && file_exists(public_path($history->image))) {
                    @unlink(public_path($history->image));
                }
            }

            // ✅ Hapus folder keamanan_images/{pts_id}/{keamanan_id}
            $folder = public_path("keamanan_images/{$keamanan->pts_id}/{$keamanan->id}");
            if (File::exists($folder)) {
                File::deleteDirectory($folder);
            }                        

            // ✅ Hapus master (otomatis hapus history karena foreign key cascade)
            $keamanan->delete();

            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
