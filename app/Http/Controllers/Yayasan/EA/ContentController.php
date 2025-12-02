<?php

namespace App\Http\Controllers\Yayasan\EA;

use App\Http\Controllers\Controller;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Models\SubDomain;
use App\Models\ComponentDetail;
use App\Models\ComponentContent;
use App\Models\Domain;
use App\Models\RoleDetails;
use App\Models\SubDomainContent;
use App\Models\SubDomainContentDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\UserPermission;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function index($id, Request $request)
{
    $user = Auth::user();
    $userUniversityId = $user->detail_role->university_id;

    // 🔹 Ambil semua izin komponen untuk user ini
    $userPermissions = UserPermission::where('user_id', $user->id)
        ->pluck('component_id')
        ->toArray();

    // 🔹 Jika user tidak punya izin spesifik → beri akses penuh
    if (empty($userPermissions)) {
        $userPermissions = Component::pluck('id')->toArray();
    }

    // 🔹 Ambil subdomain lengkap untuk universitas ini
    $subdomain = Subdomain::with([
        'component' => function ($query) use ($userUniversityId) {
            $query->with(['details' => function ($q) use ($userUniversityId) {
                // Filtering Detail berdasarkan university_id
                $q->where('university_id', $userUniversityId)
                    ->with('contents'); // Memuat contents untuk cek status
            }]);
        }
    ])->findOrFail($id);

    // Untuk memastikan setiap component punya properti progress (jika diperlukan untuk view)
    $componentCount = 0;
    $componentProgressSum = 0;

    // Loop ini akan berjalan HANYA untuk Component yang memiliki Detail 
    // setelah filtering university_id (misal: 3 Component)
    foreach ($subdomain->component as $component) {
        $details = $component->details;
        
        $detailProgressSum = 0;
        $detailCount = 0;

        if ($details->isNotEmpty()) {
            foreach ($details as $detail) {
                // 🔹 Ambil content terbaru untuk detail ini
                $latestContent = $detail->contents->sortByDesc('created_at')->first();
                $detailProgress = 0;
                
                if ($latestContent) {
                    if ($latestContent->status === 'Selesai') {
                        $detailProgress = 100;
                    } elseif ($latestContent->status === 'Proses') {
                        $detailProgress = 50;
                    }
                }

                $detailProgressSum += $detailProgress;
                $detailCount++;
            }

            // 🔹 Hitung rata-rata progress antar detail di komponen
            $component->progress = $detailCount > 0
                ? round($detailProgressSum / $detailCount, 2)
                : 0;
        } else {
            $component->progress = 0;
        }

        $componentProgressSum += $component->progress;
        // $componentCount++ di sini akan menghitung HANYA Component yang ada di Collection $subdomain->component 
        // yang sudah difilter oleh Eager Loading Details. Inilah sumber masalah 83.33%.
        $componentCount++; 
    }

    // --- PERBAIKAN DILAKUKAN DI SINI ---

    // 1. Ambil jumlah TOTAL Component yang seharusnya ada (misalnya: 5)
    // Ini mengasumsikan semua Component yang dibutuhkan ada di tabel 'components'
    // dan terhubung ke Subdomain saat ini.
    $totalRequiredComponents = Component::where('subdomain_id', $id)->count(); 

    // 2. Hitung rata-rata progress menggunakan total Component yang benar sebagai pembagi.
    // Jika $totalRequiredComponents = 5 dan $componentProgressSum = 250, hasilnya 50.00%.
    $subdomainProgress = $totalRequiredComponents > 0 
        ? round($componentProgressSum / $totalRequiredComponents, 2) 
        : 0;

    // Karena Anda sudah memperbaiki Accessor di model SubDomain, 
    // Anda juga bisa mengganti seluruh loop di atas dan langsung menggunakan Accessor:
    // $subdomainProgress = $subdomain->progress; 
    // *Tetapi* pastikan Accessor SubDomain juga sudah diperbaiki untuk menghitung total Component yang benar.

    return view('yayasan.ea.index', [
        'subdomain' => $subdomain,
        'subkomponendetail' => $subdomain->component,
        'progress' => $subdomainProgress,
        'userPermissions' => $userPermissions,
    ]);
}

    public function component_detail($id, Request $request)
{
    $search = $request->input('search');
    $user = Auth::user();

    // 1️⃣ Ambil komponen utama
    $component = Component::find($id);

    if (!$component) {
        return redirect()->back()->with('error', 'Data Komponen tidak ditemukan.');
    }

    // 2️⃣ Ambil semua detail + konten terbaru
    $details = ComponentDetail::where('component_id', $component->id)
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })
        ->with([
            'contents' => fn($query) => $query->latest('created_at'),
            'latest.updatedBy',
            'histories.updatedBy'
        ])
        ->orderByDesc('id')
        ->get();

    // Supaya $component->details bisa langsung dipakai di blade
    $component->setRelation('details', $details);

    // 3️⃣ Ambil semua izin user untuk komponen ini
    $permissions = UserPermission::where('user_id', $user->id)
        ->where('component_id', $component->id)
        ->pluck('access')
        ->toArray();

    // 4️⃣ Jika user tidak punya izin sama sekali → akses penuh
    if (empty($permissions)) {
        // Ini yang penting: user tanpa permission TETAP boleh masuk
        $permissions = ['lihat', 'create', 'update', 'delete'];
    }

    // ⚠️ Jangan abort 403 lagi — biarkan user tanpa izin tetap bisa lihat halaman
    // if (!in_array('view', $permissions)) {
    //     abort(403, 'Anda tidak memiliki izin untuk melihat halaman ini.');
    // }

    // 5️⃣ Kirim data ke view
    return view('yayasan.ea.komponen.show', [
        'component' => $component,
        'search' => $search,
        'permissions' => $permissions,
    ]);
}

public function stakeholder_detail($id, Request $request)
    {
        // 1️⃣ Ambil komponen berdasarkan ID
        $component = Component::find($id);
    
        if (!$component) {
            return redirect()->back()->with('error', 'Komponen tidak ditemukan.');
        }
    
        // 2️⃣ Ambil ID universitas user yang login
        $userUniversityId = Auth::user()->detail_role->university_id;
    
        // 3️⃣ Query user berdasarkan role detail (universitas & nama sama seperti komponen)
        $query = User::whereHas('detail_role', function ($q) use ($userUniversityId, $component) {
            $q->where('university_id', $userUniversityId)
              ->where('name', $component->name);
        });
    
        // 4️⃣ Tambahkan pencarian opsional
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
    
        // 5️⃣ Eksekusi query
        $users = $query->get();
    
        // 6️⃣ Tampilkan view walaupun kosong (supaya tidak redirect bolak-balik)
        return view('yayasan.ea.subdomain.stakeholder', compact('users', 'component'));
    }

    public function getComments($id)
    {
        $content = ComponentContent::find($id);

        if (! $content) {
            return response()->json([
                'success' => false,
                'message' => 'Component content tidak ditemukan'
            ], 404);
        }

        // Eager load user to hindari N+1
        $comments = $content->comments()
            ->with('user:id,name') // hanya select kolom minimum
            ->latest()
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'user_name' => $c->user->name ?? 'Anonim',
                    'comment' => e($c->comment), // escape saat return (XSS defense)
                    'created_at' => $c->created_at->format('d M Y H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'comments' => $comments,
        ]);
    }

    /**
     * Simpan komentar (POST dari form / AJAX)
     * Route: POST /yayasan/teknologi/save-comment
     */
    public function saveComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'component_content_id' => 'required|exists:component_contents,id',
            'comment' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $content = ComponentContent::find($request->component_content_id);
        if (! $content) {
            return response()->json([
                'success' => false,
                'message' => 'Component content tidak ditemukan'
            ], 404);
        }

        $comment = Comment::create([
            'component_content_id' => $content->id,
            'user_id' => Auth::id(), // null jika guest
            'comment' => $request->comment,
        ]);

        // Optional: load user
        $comment->load('user:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil disimpan',
            'data' => [
                'id' => $comment->id,
                'user_name' => $comment->user->name ?? 'Anonim',
                'comment' => e($comment->comment),
                'created_at' => $comment->created_at->format('d M Y H:i'),
            ],
        ]);
    }

}
