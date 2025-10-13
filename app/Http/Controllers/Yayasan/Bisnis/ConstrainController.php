<?php

namespace App\Http\Controllers\Yayasan\Bisnis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SPBisnis;
use App\Models\CommentBisnis;
use Illuminate\Support\Facades\Auth;

class ConstrainController extends Controller
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
            ->where('bisnis_id', 5);

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

        return view('yayasan.a_bisnis.constrain.show', compact('id_pts', 'bisnis'));
    }


    public function save_comment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        CommentBisnis::create([
            'sp_bisnis_id' => $request->id,
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
