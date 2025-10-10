<?php

namespace App\Http\Controllers\Admin\EA\ATeknologi;

use App\Http\Controllers\Controller;
use App\Models\SPTeknologi;
use App\Models\SPTeknologiHistory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

class TeknologiController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPTeknologi::with([
            // ambil history terbaru + user yang update
            'latestHistory.updatedBy',
            // ambil semua history kalau mau ditampilkan juga
            'histories.updatedBy',
            // ambil komentar + user
            'teknologi_comments.user'
            ])
            ->where('pts_id', $id_pts);

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // cari di judul teknologi
                $q->where('title', 'like', "%{$search}%")
                // cari di history (content)
                ->orWhereHas('histories', function ($qh) use ($search) {
                  $qh->where('content', 'like', "%{$search}%");
                });
            });
        }

        $teknologi = $query->get();

        return view('admin.ea.a_teknologi.show', compact('id_pts', 'teknologi'));
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
            $teknologi = SPTeknologi::create([
                'user_id'   => Auth::id(),
                'pts_id'    => $request->id_pts,
                'title'     => $request->title,
            ]);

            // ✅ Simpan gambar (jika ada)
            $imagePath = null;
            // if ($request->hasFile('image')) {
            // simpan ke folder teknologi_images/{id_pts}
            //     $imagePath = $request->file('image')
            //         ->store("teknologi_images/{$request->id_pts}", 'public');
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("teknologi_images/{$request->id_pts}/{$teknologi->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "teknologi_images/{$request->id_pts}/{$teknologi->id}/{$fileName}";
            }

            // ✅ Simpan ke history
            SPTeknologiHistory::create([
                'sp_teknologi_id' => $teknologi->id,
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
            'id'      => 'required|integer|exists:sp_architecture_teknologi,id',
            'title'   => 'required|string|max:255',
            'status'  => 'required|in:Proses,Selesai',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $teknologi = SPTeknologi::findOrFail($request->id);

            // ✅ Kelola gambar
            $imagePath = null;
            // if ($request->hasFile('image')) {
            //     // hapus gambar lama kalau ada
            //     if ($teknologi->image && \Storage::disk('public')->exists($teknologi->image)) {
            //         \Storage::disk('public')->delete($teknologi->image);
            //     }
        
            //     // simpan gambar baru ke folder sesuai PTS
            //     $imagePath = $request->file('image')
            //         ->store("teknologi_images/{$request->id_pts}", 'public');
        
            //     $teknologi->image = $imagePath;
            // }
            if ($request->hasFile('image')) {
                $folder = public_path("teknologi_images/{$request->id_pts}/{$teknologi->id}");

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($folder, $fileName);

                $imagePath = "teknologi_images/{$request->id_pts}/{$teknologi->id}/{$fileName}";
            }

            // ✅ Tambah history baru
            SPTeknologiHistory::create([
                'sp_teknologi_id' => $teknologi->id,
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
            $teknologi = SPTeknologi::findOrFail($id);

            // ✅ Hapus semua file gambar dari setiap history
            foreach ($teknologi->histories as $history) {
                if ($history->image && file_exists(public_path($history->image))) {
                    @unlink(public_path($history->image));
                }
            }

            // ✅ Hapus folder teknologi_images/{pts_id}/{teknologi_id}
            $folder = public_path("teknologi_images/{$teknologi->pts_id}/{$teknologi->id}");
            if (File::exists($folder)) {
                File::deleteDirectory($folder);
            }                        

            // ✅ Hapus master (otomatis hapus history karena foreign key cascade)
            $teknologi->delete();

            DB::commit();

            return redirect()->back()->with('toast_success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
