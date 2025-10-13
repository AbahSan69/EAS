<?php

namespace App\Http\Controllers\Yayasan\Aplikasi;

use App\Http\Controllers\Controller;
use App\Models\CommentAplikasi;
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

        return view('yayasan.a_aplikasi.show', compact('id_pts', 'aplikasi'));
    }


    public function save_comment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        CommentAplikasi::create([
            'sp_aplikasi_id' => $request->id,
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
