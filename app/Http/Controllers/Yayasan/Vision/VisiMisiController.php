<?php

namespace App\Http\Controllers\Yayasan\Vision;

use App\Http\Controllers\Controller;
use App\Models\SPVision;
use App\Models\CommentVision;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class VisiMisiController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPVision::with(['vision_comments.user'])
                ->where('pts_id', $id_pts)
                ->where('vision_id', 1);

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $vision = $query->get();

        return view('yayasan.a_vision.vision.show', compact('id_pts', 'vision'));
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
