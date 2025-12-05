<?php

namespace App\Http\Controllers\StakeholderPTS\EA;

use App\Http\Controllers\Controller;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Models\ComponentDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPermission;

class ContentDetailController extends Controller
{
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
        return view('stakeholder_pts.ea.komponen.show', [
            'component' => $component,
            'search' => $search,
            'permissions' => $permissions,
        ]);
    }
}
