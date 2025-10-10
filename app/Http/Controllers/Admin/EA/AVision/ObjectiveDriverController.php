<?php

namespace App\Http\Controllers\Admin\EA\AVision;

use App\Http\Controllers\Controller;
use App\Models\SPVision;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SPVisionHistory;
use Illuminate\Support\Facades\File;
use Exception;


class ObjectiveDriverController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPVision::with([
            // ambil history terbaru + user yang update
            'latestHistory.updatedBy',
            // ambil semua history kalau mau ditampilkan juga
            'histories.updatedBy',
            // ambil komentar + user
            'vision_comments.user'
            ])
            ->where('pts_id', $id_pts)
            ->where('vision_id', 4);

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // cari di judul vision
                $q->where('title', 'like', "%{$search}%")
                // cari di history (content)
                ->orWhereHas('histories', function ($qh) use ($search) {
                  $qh->where('content', 'like', "%{$search}%");
                });
            });
        }

        $vision = $query->get();

        return view('admin.ea.a_vision.objective_driver.show', compact('id_pts', 'vision'));
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
            $vision = SPVision::create([
                'user_id'   => Auth::id(),
                'pts_id'    => $request->id_pts,
                'vision_id' => 4,
                'title'     => $request->title,
            ]);

            // ✅ Simpan gambar (jika ada)
            $imagePath = null;
            // if ($request->hasFile('image')) {
            // simpan ke folder vision_images/{id_pts}
            //     $imagePath = $request->file('image')
            //         ->store("vision_images/{$request->id_pts}", 'public');
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("vision_images/{$request->id_pts}/{$vision->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "vision_images/{$request->id_pts}/{$vision->id}/{$fileName}";
            }

            // ✅ Simpan ke history
            SPVisionHistory::create([
                'sp_vision_id' => $vision->id,
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
            'id'      => 'required|integer|exists:sp_architecture_visions,id',
            'title'   => 'required|string|max:255',
            'status'  => 'required|in:Proses,Selesai',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $vision = SPVision::findOrFail($request->id);

            // ✅ Kelola gambar
            $imagePath = null;
            // if ($request->hasFile('image')) {
            //     // hapus gambar lama kalau ada
            //     if ($vision->image && \Storage::disk('public')->exists($vision->image)) {
            //         \Storage::disk('public')->delete($vision->image);
            //     }
        
            //     // simpan gambar baru ke folder sesuai PTS
            //     $imagePath = $request->file('image')
            //         ->store("vision_images/{$request->id_pts}", 'public');
        
            //     $vision->image = $imagePath;
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("vision_images/{$request->id_pts}/{$vision->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "vision_images/{$request->id_pts}/{$vision->id}/{$fileName}";
            }

            // ✅ Tambah history baru
            SPVisionHistory::create([
                'sp_vision_id' => $vision->id,
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
            $vision = SPVision::findOrFail($id);

            // ✅ Hapus semua file gambar dari setiap history
            foreach ($vision->histories as $history) {
                if ($history->image && file_exists(public_path($history->image))) {
                    @unlink(public_path($history->image));
                }
            }

            // ✅ Hapus folder vision_images/{pts_id}/{vision_id}
            $folder = public_path("vision_images/{$vision->pts_id}/{$vision->id}");
            if (File::exists($folder)) {
                File::deleteDirectory($folder);
            }                        

            // ✅ Hapus master (otomatis hapus history karena foreign key cascade)
            $vision->delete();

            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
