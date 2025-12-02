<?php

namespace App\Services;

class ProgressService
{
    public function detailProgress($detail)
    {
        $latest = $detail->contents->sortByDesc('created_at')->first();

        return match(optional($latest)->status) {
            'Selesai' => 100,
            'Proses' => 50,
            default => 0,
        };
    }

    public function componentProgress($component)
    {
        if ($component->details->isEmpty()) {
            return 0;
        }

        $detailValues = $component->details->map(function ($detail) {
            return $this->detailProgress($detail);
        });

        return round($detailValues->avg(), 2);
    }

    public function subdomainProgress($subdomain)
    {
        if ($subdomain->component->isEmpty()) {
            return 0;
        }

        $componentValues = $subdomain->component->map(function ($component) {
            return $this->componentProgress($component);
        });

        return round($componentValues->avg(), 2);
    }

    public function domainProgress($domain)
    {
        if ($domain->subdomain->isEmpty()) {
            return 0;
        }

        $subdomainValues = $domain->subdomain->map(function ($subdomain) {
            return $this->subdomainProgress($subdomain);
        });

        return round($subdomainValues->avg(), 2);
    }
}
