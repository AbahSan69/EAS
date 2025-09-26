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

class ConstrainController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPBisnis::with(['bisnis_comments.user'])
                ->where('pts_id', $id_pts)
                ->where('bisnis_id', 5);

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $bisnis = $query->get();
        return view('stakeholder_pts.ea.a_bisnis.constrains.show', compact('id_pts','bisnis'));
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
        if ($request->hasFile('image')) {
            // simpan ke folder bisnis_images/{id_pts}
            $imagePath = $request->file('image')
                ->store("bisnis_images/{$request->id_pts}", 'public');
        }

        DB::beginTransaction();

        try {
            SPBisnis::create([
                'user_id'  => Auth::id(),
                'pts_id'     => $request->id_pts,
                'bisnis_id' => 5,
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

            if ($request->hasFile('image')) {
                // hapus gambar lama kalau ada
                if ($bisnis->image && \Storage::disk('public')->exists($bisnis->image)) {
                    \Storage::disk('public')->delete($bisnis->image);
                }
        
                // simpan gambar baru ke folder sesuai PTS
                $imagePath = $request->file('image')
                    ->store("bisnis_images/{$request->id_pts}", 'public');
        
                $bisnis->image = $imagePath;
            }

            $data = [
                'title'  => $request->title,
                'content' => $request->content,
                'status' => $request->status,
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

        if (!$bisnis) {
            return redirect()->back()->with('toast_error', 'Data tidak ditemukan!');
        }

        if ($bisnis->image && \Storage::disk('public')->exists($bisnis->image)) {
            \Storage::disk('public')->delete($bisnis->image);
        }

        $bisnis->delete();
        return redirect()->back()
                         ->with('toast_success', 'Data Berhasil Dihapus!');
    }
}
