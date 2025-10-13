<?php

namespace App\Http\Controllers\Yayasan\Informasi;

use App\Http\Controllers\Controller;
use App\Models\CommentInformasi;
use App\Models\SPInformasi;
use App\Models\SPInformasiHistory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Exception;

class InformasiController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPInformasi::with([
            // ambil history terbaru + user yang update
            'latestHistory.updatedBy',
            // ambil semua history kalau mau ditampilkan juga
            'histories.updatedBy',
            // ambil komentar + user
            'informasi_comments.user'
            ])
            ->where('pts_id', $id_pts);

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // cari di judul informasi
                $q->where('title', 'like', "%{$search}%")
                // cari di history (content)
                ->orWhereHas('histories', function ($qh) use ($search) {
                  $qh->where('content', 'like', "%{$search}%");
                });
            });
        }

        $informasi = $query->get();

        return view('yayasan.a_Informasi.show', compact('id_pts', 'informasi'));
    }


    public function save_comment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        CommentInformasi::create([
            'sp_informasi_id' => $request->id,
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
