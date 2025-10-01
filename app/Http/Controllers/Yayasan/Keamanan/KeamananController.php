<?php

namespace App\Http\Controllers\Yayasan\Keamanan;

use App\Http\Controllers\Controller;
use App\Models\CommentKeamanan;
use App\Models\SPKeamanan;
use App\Models\SPKeamananHistory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Exception;

class KeamananController extends Controller
{
    public function show($id, Request $request)
    {
        $id_pts = $id;

        $query = SPKeamanan::with(['keamanan_comments.user'])
                ->where('pts_id', $id_pts);

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $keamanan = $query->get();

        return view('yayasan.a_keamanan.show', compact('id_pts', 'keamanan'));
    }


    public function save_comment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        CommentKeamanan::create([
            'sp_keamanan_id' => $request->id,
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
