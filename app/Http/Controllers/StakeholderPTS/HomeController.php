<?php

namespace App\Http\Controllers\StakeholderPTS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPermission;
use App\Models\Component;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userUniversityId = $user->detail_role->university_id;
    
        // Ambil semua domain + relasi
        $domains = Domain::with([
            'subdomain' => function ($query) use ($userUniversityId) {
                $query->with([
                    'component' => function ($q) use ($userUniversityId) {
                        $q->with([
                            'details' => function ($qq) use ($userUniversityId) {
                                $qq->where('university_id', $userUniversityId)
                                   ->with('contents');
                            }
                        ]);
                    }
                ]);
            }
        ])->get();
    
        // Ambil izin user
        $userPermissions = UserPermission::where('user_id', $user->id)
            ->pluck('component_id')
            ->toArray();
    
        // Jika belum ada izin → akses semua
        if (empty($userPermissions)) {
            $userPermissions = Component::pluck('id')->toArray();
        }
    
        // Hitung progres
        foreach ($domains as $domain) {
            $subdomainProgress = [];
    
            foreach ($domain->subdomain as $subdomain) {
                $totalProgress = 0;
                $componentCount = $subdomain->component->count();
    
                foreach ($subdomain->component as $component) {
                    // Jika tidak punya izin → tetap dihitung tapi bernilai 0
                    if (!in_array($component->id, $userPermissions)) {
                        $component->progress = 0;
                        $totalProgress += $component->progress;
                        continue;
                    }
    
                    $details = $component->details;
    
                    if ($details->isNotEmpty()) {
                        $detailProgressSum = 0;
                        $detailCount = 0;
    
                        foreach ($details as $detail) {
                            // Ambil content terbaru
                            $latestContent = $detail->contents
                                ->sortByDesc('created_at')
                                ->first();
    
                            if ($latestContent) {
                                if ($latestContent->status === 'Selesai') {
                                    $detailProgress = 100;
                                } elseif ($latestContent->status === 'Proses') {
                                    $detailProgress = 50;
                                } else {
                                    $detailProgress = 0;
                                }
                            } else {
                                $detailProgress = 0;
                            }
    
                            $detailProgressSum += $detailProgress;
                            $detailCount++;
                        }
    
                        $component->progress = $detailCount > 0
                            ? round($detailProgressSum / $detailCount, 2)
                            : 0;
                    } else {
                        $component->progress = 0;
                    }
    
                    $totalProgress += $component->progress;
                }
    
                // Rata-rata antar komponen
                $subdomainProgressValue = $componentCount > 0
                    ? round($totalProgress / $componentCount, 2)
                    : 0;
    
                $subdomain->setAttribute('progress', $subdomainProgressValue);
                $subdomainProgress[] = $subdomainProgressValue;
            }
    
            // Rata-rata antar subdomain
            $domain->setAttribute('progress', count($subdomainProgress) > 0
                ? round(array_sum($subdomainProgress) / count($subdomainProgress), 2)
                : 0);
        }
    
        $overallProgress = $domains->count() > 0
            ? round($domains->avg('progress'), 2)
            : 0;
    
        return view('stakeholder_pts.home', compact('domains', 'overallProgress', 'userPermissions'));
    }
    

    

}
