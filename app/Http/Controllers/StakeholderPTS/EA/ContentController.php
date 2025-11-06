<?php

namespace App\Http\Controllers\StakeholderPTS\EA;

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
use Illuminate\Support\Facades\Storage;


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
                    $q->where('university_id', $userUniversityId)
                      ->with('contents');
                }]);
            }
        ])->findOrFail($id);
    
        $totalProgress = 0;
        $componentCount = $subdomain->component->count();
    
        foreach ($subdomain->component as $component) {
            $details = $component->details;
    
            if ($details->isNotEmpty()) {
                $detailProgressSum = 0;
                $detailCount = 0;
    
                foreach ($details as $detail) {
                    // 🔹 Ambil content terbaru untuk detail ini
                    $latestContent = $detail->contents->sortByDesc('created_at')->first();
    
                    if ($latestContent) {
                        if ($latestContent->status === 'Selesai') {
                            $detailProgress = 100;
                        } elseif ($latestContent->status === 'Proses') {
                            $detailProgress = 50;
                        } else {
                            $detailProgress = 0;
                        }
                    } else {
                        $detailProgress = 0; // Belum ada content
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
    
            $totalProgress += $component->progress;
        }
    
        // 🔹 Hitung rata-rata progress semua komponen
        $subdomainProgress = $componentCount > 0 ? round($totalProgress / $componentCount, 2) : 0;
    
        return view('stakeholder_pts.ea.index', [
            'subdomain' => $subdomain,
            'subkomponendetail' => $subdomain->component,
            'progress' => $subdomainProgress,
            'userPermissions' => $userPermissions,
        ]);
    }
    

public function storeComponent(Request $request)
{
    // Validasi dasar
    $request->validate([
        'component_id'=> 'required|exists:components,id',
        'title'=> 'required|string|max:255',
        'jenis_konten' => 'required|in:Text,File,Link',
        // Tambahkan validasi untuk tiap jenis konten
        'content'=> 'nullable|required_if:jenis_konten,Text|string',
        'file_content'=> 'nullable|required_if:jenis_konten,File|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // 2MB
        'link_url'=> 'nullable|required_if:jenis_konten,Link|url',
    ]);

    // 1. Buat detail komponen
    $detail = ComponentDetail::create([
        'component_id' => $request->component_id,
        'university_id' => Auth::user()->detail_role->university->id,
        'title'=> $request->title,
        'description'=> $request->input('description'), // Pastikan input 'description' ada jika diperlukan
    ]);

    $contentData = [
        'component_detail_id' => $detail->id,
        'updated_by'=> Auth::user()->id,
        'content_type'=> $request->jenis_konten,
        'status' => 'Proses'
    ];

    // 2. Proses dan tambahkan konten berdasarkan jenis
    switch ($request->jenis_konten) {
        case 'Text':
            // Ubah $request->Text menjadi $request->content
            $contentData['text'] = $request->content; 
            break;

        case 'File':
            // Ubah $request->file('File') menjadi $request->file('file_content')
            if ($request->hasFile('file_content')) { 
                $file = $request->file('file_content');
                $destinationPath = public_path('uploads/components/' . $request->component_id);

                // Buat folder jika belum ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
            
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
            
                $contentData['file_path'] = 'uploads/components/' . $request->component_id . '/' . $fileName;
            }
            break;

        case 'Link':
            // Ubah $request->Link menjadi $request->link_url
            $contentData['link_url'] = $request->link_url; 
            break;
    }

    // 3. Buat konten komponen
    ComponentContent::create($contentData);

    // 4. Update progres component/subdomain (optional, perlu logika tambahan)
    // Logika update progress harus dipanggil di sini setelah konten berhasil dibuat.

    return back()->with('success', 'Konten berhasil ditambahkan ke komponen.');
}

// File: ComponentController.php

public function updateComponent($id, Request $request)
{
    // ... (Validasi dan Update ComponentDetail seperti sebelumnya) ...

    $detail = ComponentDetail::find($id);

    $detail->update([
        'component_id' => $request->component_id,
        'university_id' => Auth::user()->detail_role->university->id,
        'title' => $request->title,
        'description' => $request->input('description'),
    ]);

    $contentData = [
        'component_detail_id' => $detail->id,
        'updated_by' => Auth::user()->id,
        'content_type' => $request->jenis_konten,
        'status' => $request->status,
        // Inisialisasi default agar tidak membawa data yang tidak relevan
        'text' => null,
        'file_path' => null,
        'link_url' => null,
    ];

    // Ambil konten lama yang akan dipertahankan (jika ada)
    $oldContent = $detail->contents()->latest()->first(); 
    
    switch ($request->jenis_konten) {
        case 'Text':
            $contentData['text'] = $request->content;
            break;

        case 'File':
            if ($request->hasFile('file_path')) {
                // 1. ADA FILE BARU: Simpan file baru
                $destinationPath = public_path('uploads/components/' . $request->component_id);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file = $request->file('file_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
                $contentData['file_path'] = 'uploads/components/' . $request->component_id . '/' . $fileName;

            } elseif ($oldContent && $oldContent->content_type === 'File') {
                // 2. TIDAK ADA FILE BARU & Tipe konten sebelumnya sama: Pertahankan path file lama
                $contentData['file_path'] = $oldContent->file_path;

            }
            break;

        case 'Link':
            $contentData['link_url'] = $request->link_url;
            break;
    }
    
    // Pastikan konten lama (Text/Link) juga dipertahankan jika tidak ada perubahan tipe
    if ($request->jenis_konten === 'Text' && !isset($contentData['text']) && $oldContent) {
        $contentData['text'] = $oldContent->text;
    } elseif ($request->jenis_konten === 'Link' && !isset($contentData['link_url']) && $oldContent) {
        $contentData['link_url'] = $oldContent->link_url;
    }


    ComponentContent::create($contentData);
    return back()->with('success', 'Konten berhasil diupdate.');
}

public function deleteComponent($id)
{
    DB::beginTransaction();

    try {
        $detail = ComponentDetail::findOrFail($id);
        
        // 1. Hapus semua file dari setiap riwayat konten
        foreach ($detail->contents as $content) {
            
            // *** PERBAIKAN: Gunakan 'file_path' bukan 'image' ***
            $filePath = ltrim($content->file_path ?? '', '/'); 
            
            // Karena Anda menyimpan di public/, gunakan public_path()
            $fullPath = public_path($filePath);
            
            if ($filePath && file_exists($fullPath)) {
                // @unlink digunakan untuk menekan error jika file gagal dihapus (misal karena permission),
                // tapi lebih baik hanya menggunakan unlink() dan membiarkan exception/log terjadi
                unlink($fullPath); 
            }
            
            // Jika ada logika lain untuk 'Storage', pastikan disesuaikan
            // Contoh: Jika Anda menyimpan ke Storage::disk('local'), logikanya berbeda.
        }

        // 2. Hapus folder utama
        // Folder harus menggunakan component_id, bukan detail->id (jika path folder mengikuti component_id)
        // KODE ANDA: public_path("uploads/components/{$detail->id}");
        // KODE SAYA: public_path("uploads/components/{$detail->component_id}"); <--- Sesuaikan dengan logika penyimpanan Anda
        
        // Asumsi folder yang dibuat di storeComponent adalah berdasarkan component_id,
        // namun jika Anda membuat folder berdasarkan detail->id, kode Anda sudah benar.
        // Mari kita asumsikan struktur folder mengikuti: uploads/components/{component_id}
        
        // $folderPath = public_path("uploads/components/{$detail->component_id}");
        
        // // Logika Anda untuk menghapus folder (File::deleteDirectory) sudah benar dan komprehensif.
        // // File::deleteDirectory akan menghapus folder beserta isinya.
        // if (File::exists($folderPath)) {
        //     File::deleteDirectory($folderPath);
        // }

        // 3. Hapus master (otomatis hapus history karena foreign key cascade)
        $detail->delete();

        DB::commit();

        return redirect()->back()->with('toast_success', 'Data berhasil dihapus!');
    } catch (\Exception $e) {
        DB::rollBack();
        // Anda mungkin ingin mencatat $e->getMessage() untuk debugging
        // Log::error("Gagal menghapus komponen: " . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
    }
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
    return view('stakeholder_pts.ea.komponen.show', [
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
        return view('stakeholder_pts.ea.subdomain.stakeholder', compact('users', 'component'));
    }

    public function create($id)
    {
        // 1. Ambil Component untuk data default role
        $component = Component::findOrFail($id);
        
        // 2. Tentukan Default Permissions
        $existing_permissions = [
            $component->key_name ?? ('comp_' . $id) => [
                'view' => true,
                // Tambahkan izin default lainnya jika diperlukan
            ]
        ];
        
        // 3. Ambil data modul akses umum
        $data = $this->getAccessModules();

        // 4. Kirim data ke view
        return view('stakeholder_pts.ea.komponen.create_update', array_merge($data, [
            'stakeholder' => null, // Mode Create, tidak ada objek User
            'existing_permissions' => $existing_permissions,
            'is_edit_mode' => false,
            'target_component_name' => $component->name,
            'target_component_id' => $component->id
        ]));
    }

    // === METHOD UNTUK HALAMAN EDIT (UPDATE) ===
    public function edit($id, $componentId)
{
    // 1️⃣ Ambil user stakeholder
    $stakeholder = User::findOrFail($id);
    $component   = Component::findOrFail($componentId);
    // 2️⃣ Ambil semua izin (UserPermission) yang sudah tersimpan untuk user ini
    // Hasil akhirnya: [component_id => ['view', 'create', 'update', 'delete']]
    $permissions = UserPermission::where('user_id', $stakeholder->id)
    ->select('component_id', 'access')
    ->get()
    ->groupBy('component_id')
    ->map(function ($group) {
        return collect($group)->pluck('access')->map(function ($a) {
            return $a === 'view' ? 'lihat' : $a; // ubah 'view' jadi 'lihat'
        })->toArray();
    })
    ->toArray();


    // 3️⃣ Ambil data domain/subdomain/component untuk form
    // ⚠️ Perhatikan: nama relasi harus sesuai dengan yang ada di model
    $data = $this->getAccessModules();

    // 4️⃣ Tambahkan data tambahan untuk form edit
    return view('stakeholder_pts.ea.komponen.create_update', array_merge($data, [
        'stakeholder'          => $stakeholder,
        'existing_permissions' => $permissions,
        'is_edit_mode'         => true,
        'target_component_name' => $component->name,
        'target_component_id' => $component->id
    ]));
}



    // === METHOD PRIVATE: LOGIKA PENGAMBILAN DATA UMUM ===
    /**
     * Mengambil semua data Domain, Subdomain, dan Component (modul/fitur)
     * Menggunakan eager loading untuk menghindari N+1 query problem
     */
    private function getAccessModules(): array
    {
        $all_access_modules = Domain::with([
            'subdomain' => function ($query) {
                $query->with('component'); // Mengambil Komponen di bawah Subdomain
            }
        ])->get();

        return [
            'all_access_modules' => $all_access_modules,
        ];
    }

    public function storeStakeholder(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|confirmed',
            'status'        => 'required|in:Aktif,Nonaktif',
            'permissions'   => 'nullable|array',
            'component_name'=> 'required|string',
            'component_id'  => 'nullable|integer|exists:components,id',
        ]);
    
        DB::transaction(function () use ($request) {
    
            // 1️⃣ Role Detail
            $roleDetail = RoleDetails::firstOrCreate(
                [
                    'role_id'       => 2,
                    'university_id' => optional(Auth::user()->detail_role->university)->id,
                    'name'          => $request->component_name,
                ],
                [
                    'position'      => $request->component_name,
                ]
            );
    
            // 2️⃣ Buat User
            $user = User::create([
                'role_detail_id' => $roleDetail->id,
                'name'           => $request->name,
                'email'          => $request->email,
                'status'         => $request->status,
                'password'       => Hash::make($request->password),
            ]);
    
            // 3️⃣ Simpan Permissions
            $permissions = $request->input('permissions', []);
    
            foreach ($permissions as $componentId => $accessList) {
                // Validasi component ID
                if (!is_numeric($componentId) || !Component::where('id', $componentId)->exists()) {
                    continue;
                }
    
                foreach ($accessList as $accessType) {
                    UserPermission::create([
                        'user_id'      => $user->id,
                        'component_id' => (int) $componentId,
                        'access'       => $accessType, // langsung simpan nama akses: lihat/create/update/delete
                    ]);
                }
            }
    
            // 4️⃣ Component Detail & Content
                $detail = ComponentDetail::create([
                    'component_id'  => $request->component_id,
                    'university_id' => optional(Auth::user()->detail_role->university)->id,
                    'title'         => $request->name,
                ]);
    
                ComponentContent::create([
                    'component_detail_id' => $detail->id,
                    'updated_by'          => Auth::user()->id,
                    'status'              => 'Selesai',
                ]);
        });

        return redirect()->route('sp.ea.stakeholder_show', $request->component_id)->with('success', 'Stakeholder baru berhasil ditambahkan.');

    }

    public function updateStakeholder(Request $request)
{
    $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|unique:users,email,' . $request->id,
        'password'      => 'nullable|min:6|confirmed',
        'status'        => 'required|in:Aktif,Nonaktif',
        'permissions'   => 'nullable|array',
        'component_name'=> 'nullable|string',
        'component_id'  => 'nullable|integer|exists:components,id',
    ]);

    DB::transaction(function () use ($request) {
        $id = $request->id;
        $user = User::findOrFail($id);

        $componentDetail = ComponentDetail::where('title', $user->name)
        ->where('university_id', Auth::user()->detail_role->university->id)
        ->first();

        $componentDetail->update([
            'title' => $request->name
        ]);

        // 1️⃣ Optional: Role Detail (hanya jika dikirim)
        // if ($request->filled('component_name')) {
        //     $roleDetail = RoleDetails::firstOrCreate(
        //         [
        //             'role_id'       => 2,
        //             'university_id' => Auth::user()->detail_role->university->id,
        //             'name'          => $request->component_name,
        //         ],
        //         [
        //             'position'      => $request->component_name,
        //         ]
        //     );
        //     $user->role_detail_id = $roleDetail->id;
        // }

        // 2️⃣ Update User
        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'status'   => $request->status,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);

        // 3️⃣ Update Permissions
        UserPermission::where('user_id', $user->id)->delete();

        $permissions = $request->input('permissions', []);
        $validComponentIds = Component::pluck('id')->toArray();

        foreach ($permissions as $componentId => $accessList) {
            if (!in_array($componentId, $validComponentIds)) continue;

            foreach ($accessList as $accessType) {
                UserPermission::create([
                    'user_id'      => $user->id,
                    'component_id' => (int) $componentId,
                    'access'       => $accessType,
                ]);
            }
        }

            $detail = ComponentDetail::updateOrCreate(
                [
                    'component_id'  => $request->component_id,
                    'university_id' => optional(Auth::user()->detail_role->university)->id,
                    'title'         => $request->name,
                ],
                [
                    'description'   => $request->input('description'),
                ]
            );

            ComponentContent::updateOrCreate(
                ['component_detail_id' => $detail->id],
                [
                    'updated_by' => Auth::user()->id,
                    'status'     => 'Selesai',
                ]
            );
    });

    return redirect()->route('sp.ea.stakeholder_show', $request->component_id)->with('success', 'Stakeholder baru berhasil diperbarui.');
}
    

public function destroyStakeholder($id)
{
    DB::transaction(function () use ($id) {
        $user = User::findOrFail($id);

        UserPermission::where('user_id', $user->id)->delete();

        // Hapus semua ComponentDetail dan Content yang terkait user ini (jika ada)
        $details = ComponentDetail::where('title', $user->name)
            ->where('university_id', Auth::user()->detail_role->university->id)
            ->get();

        foreach ($details as $detail) {
            ComponentContent::where('component_detail_id', $detail->id)->delete();
            $detail->delete();
        }

        // Hapus user itu sendiri
        $user->delete();
    });

    return back()->with('success', 'Stakeholder berhasil dihapus.');
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

}