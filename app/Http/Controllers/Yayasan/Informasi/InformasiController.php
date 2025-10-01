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

        $query = SPInformasi::with(['informasi_comments.user'])
                ->where('pts_id', $id_pts);

        // Jika ada pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
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
