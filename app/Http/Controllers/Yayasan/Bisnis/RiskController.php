<?php

namespace App\Http\Controllers\Yayasan\Bisnis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SPBisnis;
use App\Models\CommentBisnis;
use Illuminate\Support\Facades\Auth;
class RiskController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPBisnis::with(['bisnis_comments.user'])
                ->where('pts_id', $id_pts)
                ->where('bisnis_id', 6);

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $bisnis = $query->get();

        return view('yayasan.a_bisnis.risk.show', compact('id_pts', 'bisnis'));
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
