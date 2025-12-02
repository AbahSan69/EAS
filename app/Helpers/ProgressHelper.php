<?php

namespace App\Helpers;

class ProgressHelper
{
    /**
     * Hitung progress komponen berdasarkan isi detail (contents)
     */
    public static function componentProgress($component, $universityId)
    {
        $details = $component->details->where('university_id', $universityId)->first();

        if (!$details) {
            return 0;
        }

        $contents = $details->contents;

        if ($contents->count() === 0) {
            return 0;
        }

        $filledCount = $contents->filter(function ($c) {
            return (
                !empty($c->text) ||
                !empty($c->file_path) ||
                !empty($c->json_data)
            );
        })->count();

        return round(($filledCount / $contents->count()) * 100, 2);
    }

    /**
     * Hitung progress subdomain → rata-rata progress komponen
     */
    public static function subdomainProgress($subdomain, $universityId)
    {
        $components = $subdomain->component;

        if ($components->count() === 0) {
            return 0; // tidak auto 100
        }

        $progressList = [];

        foreach ($components as $component) {
            $progressList[] = self::componentProgress($component, $universityId);
        }

        return round(array_sum($progressList) / count($progressList), 2);
    }

    /**
     * Hitung progress domain → rata-rata progress subdomain
     */
    public static function domainProgress($domain, $universityId)
    {
        $subdomains = $domain->subdomain;

        if ($subdomains->count() === 0) {
            return 0;
        }

        $progressList = [];

        foreach ($subdomains as $subdomain) {
            $progressList[] = self::subdomainProgress($subdomain, $universityId);
        }

        return round(array_sum($progressList) / count($progressList), 2);
    }
}
