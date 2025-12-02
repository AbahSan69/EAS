<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'domains';
    protected $fillable = ['name','description'];
    protected $appends = ['progress'];

    public function subdomain()
    {
        return $this->hasMany(SubDomain::class, 'domain_id', 'id');
    }

    /**
     * Aksesor untuk menghitung progress Domain.
     * Mengukur rata-rata progress dari semua Subdomain.
     */
    // public function getProgressAttribute()
    // {
    //     $totalSubdomain = $this->subdomain->count();
        
    //     // Pastikan relasi 'subdomain' dimuat
    //     if ($totalSubdomain == 0) {
    //         return 0;
    //     }

    //     // Menjumlahkan nilai 'progress' dari setiap Subdomain (memanggil getProgressAttribute() pada SubDomain)
    //     $totalProgress = $this->subdomain->sum('progress');
        
    //     // Progress Domain adalah rata-rata progress Subdomain
    //     return round($totalProgress / $totalSubdomain, 2);
    // }

    public function getProgressAttribute()
    {
        // Pastikan relasi 'subdomain' dimuat
        $totalSubdomain = $this->subdomain->count();
        
        if ($totalSubdomain == 0) {
            return 0;
        }

        // Menjumlahkan nilai 'progress' dari setiap Subdomain (memanggil getProgressAttribute() pada SubDomain)
        $totalProgress = $this->subdomain->sum('progress');
        
        // Progress Domain adalah rata-rata progress Subdomain
        return round($totalProgress / $totalSubdomain, 2);
    }
}

