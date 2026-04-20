<?php

namespace App\Http\Controllers\Yayasan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPermission;
use App\Models\Component;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userUniversityId = $user->detail_role->university_id;

        // Ambil domain + relasi
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

        $totalOverallProgressSum = 0;
        $totalDomainCount = $domains->count();

        $progressReport = [
            'domains' => []
        ];

        foreach ($domains as $domain) {

            $subdomainProgressValues = [];

            $domainReport = [
                'domain_id' => $domain->id,
                'domain_name' => $domain->name,
                'subdomains' => [],
                'progress' => 0,
            ];

            foreach ($domain->subdomain as $subdomain) {

                // 🔥 Ambil SEMUA komponen (biar tidak miss)
                $allComponents = Component::where('subdomain_id', $subdomain->id)->get();

                // Komponen yang sudah di-load (punya detail)
                $loadedComponents = $subdomain->component->keyBy('id');

                $totalRequiredComponents = $allComponents->count();
                $componentProgressSum = 0;
                $filledCount = 0;

                $subdomainReport = [
                    'subdomain_id' => $subdomain->id,
                    'subdomain_name' => $subdomain->name,
                    'components' => [],
                    'calculated_progress' => 0,
                    'total_required_components' => $totalRequiredComponents,
                    'filled_components' => 0,
                    'empty_components' => 0,
                ];

                foreach ($allComponents as $component) {

                    $loadedComponent = $loadedComponents->get($component->id);
                    $details = $loadedComponent ? $loadedComponent->details : collect();

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

                        $currentCompProgress = $detailCount > 0
                            ? round($detailProgressSum / $detailCount, 2)
                            : 0;
                    }

                    // 🔥 STATUS FILLED
                    $isFilled = $currentCompProgress > 0;

                    if ($isFilled) {
                        $filledCount++;
                    }

                    $componentProgressSum += $currentCompProgress;

                    $subdomainReport['components'][] = [
                        'component_id' => $component->id,
                        'component_name' => $component->name,
                        'progress' => $currentCompProgress,
                        'is_filled' => $isFilled,
                    ];
                }

                // 🔥 HITUNG EMPTY
                $emptyCount = $totalRequiredComponents - $filledCount;

                // 🔥 HITUNG PROGRESS SUBDOMAIN
                $subdomainProgress = $totalRequiredComponents > 0
                    ? round($componentProgressSum / $totalRequiredComponents, 2)
                    : 0;

                $subdomainReport['calculated_progress'] = $subdomainProgress;
                $subdomainReport['filled_components'] = $filledCount;
                $subdomainReport['empty_components'] = $emptyCount;

                $subdomainProgressValues[] = $subdomainProgress;
                $domainReport['subdomains'][] = $subdomainReport;
            }

            // 🔥 PROGRESS DOMAIN
            $domainProgress = count($subdomainProgressValues) > 0
                ? round(array_sum($subdomainProgressValues) / count($subdomainProgressValues), 2)
                : 0;

            $domainReport['progress'] = $domainProgress;
            $totalOverallProgressSum += $domainProgress;

            $progressReport['domains'][] = $domainReport;
        }

        // 🔥 OVERALL
        $overallProgress = $totalDomainCount > 0
            ? round($totalOverallProgressSum / $totalDomainCount, 2)
            : 0;

        $progressReport['overall_progress'] = $overallProgress;
        $progressReport['total_domain_count'] = $totalDomainCount;

        return view('yayasan.dashboard', [
            'progressReport' => $progressReport
        ]);
    }
}
