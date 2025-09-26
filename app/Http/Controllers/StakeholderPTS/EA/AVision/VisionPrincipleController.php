<?php

namespace App\Http\Controllers\StakeholderPTS\EA\AVision;

use App\Http\Controllers\Controller;
use App\Models\SPVision;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

class VisionPrincipleController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPVision::with(['vision_comments.user'])
                ->where('pts_id', $id_pts)
                ->where('vision_id', 2);

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $vision = $query->get();
        return view('stakeholder_pts.ea.a_vision.principles.show', compact('id_pts','vision'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'status' => 'required',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            // simpan ke folder vision_images/{id_pts}
            $imagePath = $request->file('image')
                ->store("vision_images/{$request->id_pts}", 'public');
        }

        DB::beginTransaction();

        try {
            SPVision::create([
                'user_id'  => Auth::id(),
                'pts_id'     => $request->id_pts,
                'vision_id' => 2,
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
        $id_vision = $request->id;

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
            $vision = SPVision::findOrFail($id_vision);

            if ($request->hasFile('image')) {
                // hapus gambar lama kalau ada
                if ($vision->image && \Storage::disk('public')->exists($vision->image)) {
                    \Storage::disk('public')->delete($vision->image);
                }
        
                // simpan gambar baru ke folder sesuai PTS
                $imagePath = $request->file('image')
                    ->store("vision_images/{$request->id_pts}", 'public');
        
                $vision->image = $imagePath;
            }

            $data = [
                'title'  => $request->title,
                'content' => $request->content,
                'status' => $request->status,
            ];

            $vision->update($data);

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
        $vision = SPVision::find($id);

        if (!$vision) {
            return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        }

        if ($vision->image && \Storage::disk('public')->exists($vision->image)) {
            \Storage::disk('public')->delete($vision->image);
        }

        $vision->delete();
        return redirect()->back()
                         ->with('toast_success', 'Data Berhasil Dihapus!');
    }
}
