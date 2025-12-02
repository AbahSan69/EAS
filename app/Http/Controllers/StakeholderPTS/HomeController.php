<?php

namespace App\Http\Controllers\StakeholderPTS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPermission;
use App\Models\Component;
use App\Services\ProgressService;

class HomeController extends Controller
{
//     public function index()
// {
//     $user = Auth::user();
//     $userUniversityId = $user->detail_role->university_id;

//     // Ambil semua domain + relasi (sama seperti sebelumnya)
//     $domains = Domain::with([
//         'subdomain' => function ($query) use ($userUniversityId) {
//             $query->with([
//                 'component' => function ($q) use ($userUniversityId) {
//                     $q->with([
//                         'details' => function ($qq) use ($userUniversityId) {
//                             $qq->where('university_id', $userUniversityId)
//                                ->with('contents');
//                         }
//                     ]);
//                 }
//             ]);
//         }
//     ])->get();

//     // Ambil izin user untuk view (TIDAK mempengaruhi perhitungan progress)
//     $userPermissions = UserPermission::where('user_id', $user->id)
//         ->pluck('component_id')
//         ->toArray();

//     if (empty($userPermissions)) {
//         $userPermissions = Component::pluck('id')->toArray();
//     }

//     // 🔥 Perhitungan progress disamakan 100% dengan Method 1
//     foreach ($domains as $domain) {
//         $subdomainProgressValues = [];

//         foreach ($domain->subdomain as $subdomain) {

//             $totalProgress = 0;
//             $componentCount = $subdomain->component->count();

//             foreach ($subdomain->component as $component) {

//                 $details = $component->details;

//                 if ($details->isNotEmpty()) {

//                     $detailProgressSum = 0;
//                     $detailCount = 0;

//                     foreach ($details as $detail) {

//                         $latestContent = $detail->contents
//                             ->sortByDesc('created_at')
//                             ->first();

//                         if ($latestContent) {
//                             if ($latestContent->status === 'Selesai') {
//                                 $detailProgress = 100;
//                             } elseif ($latestContent->status === 'Proses') {
//                                 $detailProgress = 50;
//                             } else {
//                                 $detailProgress = 0;
//                             }
//                         } else {
//                             $detailProgress = 0;
//                         }

//                         $detailProgressSum += $detailProgress;
//                         $detailCount++;
//                     }

//                     // Rata-rata progress di level DETAIL (persis method 1)
//                     $component->progress = $detailCount > 0
//                         ? round($detailProgressSum / $detailCount, 2)
//                         : 0;

//                 } else {

//                     // Komponen tanpa detail = 0 (persis method 1)
//                     $component->progress = 0;

//                 }

//                 // Tambah progress komponen ke total
//                 $totalProgress += $component->progress;
//             }

//             // Rata-rata komponen di subdomain (persis method 1)
//             $subdomainProgress = $componentCount > 0
//                 ? round($totalProgress / $componentCount, 2)
//                 : 0;

//             // Set hasil
//             $subdomain->setAttribute('progress', $subdomainProgress);
//             $subdomainProgressValues[] = $subdomainProgress;
//         }

//         // Rata-rata seluruh subdomain di domain itu
//         $domain->setAttribute('progress',
//             count($subdomainProgressValues) > 0
//                 ? round(array_sum($subdomainProgressValues) / count($subdomainProgressValues), 2)
//                 : 0
//         );
//     }

//     // Rata-rata seluruh domain
//     $overallProgress = $domains->count() > 0
//         ? round($domains->avg('progress'), 2)
//         : 0;

//     return view('stakeholder_pts.home', compact('domains', 'overallProgress', 'userPermissions'));
// }
    public function index()
    {
        $user = Auth::user();
        $userUniversityId = $user->detail_role->university_id;

        // Ambil semua domain + relasi yang dibutuhkan
        $domains = Domain::with([
            'subdomain' => function ($query) use ($userUniversityId) {
                $query->with([
                    'component' => function ($q) use ($userUniversityId) {
                        $q->with([
                            'details' => function ($qq) use ($userUniversityId) {
                                // Filtering Detail berdasarkan university_id
                                $qq->where('university_id', $userUniversityId)
                                    ->with('contents'); // Memuat contents untuk cek status
                            }
                        ]);
                    }
                ]);
            }
        ])->get();

        // Ambil izin user untuk view
        $userPermissions = UserPermission::where('user_id', $user->id)
            ->pluck('component_id')
            ->toArray();

        if (empty($userPermissions)) {
            $userPermissions = Component::pluck('id')->toArray();
        }

        $totalOverallProgressSum = 0;
        $totalDomainCount = $domains->count();

        // Array untuk menyimpan hasil progress yang akan di-dd()
        $progressReport = [];

        // --- MULAI PERHITUNGAN MANUAL AKURAT ---
        foreach ($domains as $domain) {
            $subdomainProgressValues = [];
            $domainReport = [
                'domain_id' => $domain->id,
                'domain_name' => $domain->name,
                'subdomains' => [],
                'progress' => 0,
            ];

            foreach ($domain->subdomain as $subdomain) {
                $componentProgressSum = 0;
                
                // Ambil JUMLAH TOTAL Component yang seharusnya ada di SubDomain ini (Denominator)
                $totalRequiredComponents = Component::where('subdomain_id', $subdomain->id)->count(); 
                
                $subdomainReport = [
                    'subdomain_id' => $subdomain->id,
                    'subdomain_name' => $subdomain->name,
                    'components' => [],
                    'calculated_progress' => 0,
                    'total_required_components' => $totalRequiredComponents
                ];

                // Iterasi melalui Component yang DIMUAT (hanya yang punya Detail terfilter)
                foreach ($subdomain->component as $component) {

                    $details = $component->details;
                    $detailProgressSum = 0;
                    $detailCount = 0;
                    $currentCompProgress = 0;

                    if ($details->isNotEmpty()) {
                        foreach ($details as $detail) {
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

                        // Rata-rata progress Component
                        $currentCompProgress = $detailCount > 0
                            ? round($detailProgressSum / $detailCount, 2)
                            : 0;
                    } 
                    // Jika details kosong, currentCompProgress tetap 0, seperti yang diinisialisasi di awal loop.

                    $componentProgressSum += $currentCompProgress;

                    $subdomainReport['components'][] = [
                        'component_id' => $component->id,
                        'component_name' => $component->name,
                        'progress' => $currentCompProgress,
                        'details_count_filtered' => $details->count(),
                    ];
                }
                
                // Hitung rata-rata SubDomain menggunakan TOTAL Component sebagai pembagi (Denominator yang benar)
                $subdomainProgress = $totalRequiredComponents > 0
                    ? round($componentProgressSum / $totalRequiredComponents, 2)
                    : 0;

                // Set hasil progress pada objek SubDomain dan Report
                $subdomain->setAttribute('progress', $subdomainProgress);
                $subdomainReport['calculated_progress'] = $subdomainProgress;
                
                $subdomainProgressValues[] = $subdomainProgress;
                $domainReport['subdomains'][] = $subdomainReport;
            }

            // Hitung rata-rata seluruh subdomain di domain itu
            $domainProgress = count($subdomainProgressValues) > 0
                ? round(array_sum($subdomainProgressValues) / count($subdomainProgressValues), 2)
                : 0;

            $domain->setAttribute('progress', $domainProgress);
            $domainReport['progress'] = $domainProgress;
            $totalOverallProgressSum += $domainProgress;
            
            $progressReport['domains'][] = $domainReport;
        }

        // Rata-rata seluruh domain (Overall Progress)
        $overallProgress = $totalDomainCount > 0
            ? round($totalOverallProgressSum / $totalDomainCount, 2)
            : 0;
        
        $progressReport['overall_progress'] = $overallProgress;
        $progressReport['total_domain_count'] = $totalDomainCount;
        // --- AKHIR PERHITUNGAN MANUAL AKURAT ---

        // Tampilkan hasil perhitungan menggunakan dd()
    //    dd($progressReport);
    return view('stakeholder_pts.home', [
        'progressReport' => $progressReport
    ]);
    
    }

}

