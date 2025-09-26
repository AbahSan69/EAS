<?php

namespace App\Http\Controllers\Yayasan\Vision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SPVision;
use App\Models\CommentVision;
use Illuminate\Support\Facades\Auth;

class PrincipleController extends Controller
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
        return view('yayasan.a_vision.principles.show', compact('id_pts','vision'));
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
