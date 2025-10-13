<?php

namespace App\Http\Controllers\Yayasan\Vision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SPVision;
use App\Models\CommentVision;
use Illuminate\Support\Facades\Auth;

class BisnisController extends Controller
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
            ->where('vision_id', 3);

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
        return view('yayasan.a_vision.bisnis.show', compact('id_pts','vision'));
    }

    public function save_comment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        CommentVision::create([
            'sp_vision_id' => $request->id,
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
