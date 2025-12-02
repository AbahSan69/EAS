<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDomain extends Model
{
    protected $table = 'subdomains';
    protected $fillable = ['domain_id','name','description'];
    protected $appends = ['progress'];

    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id', 'id');
    }

    public function component()
    {
        return $this->hasMany(Component::class, 'subdomain_id', 'id');
    }

    public function subdomain_contents()
    {
        return $this->hasMany(SubDomainContent::class, 'subdomain_id', 'id');
    }

//     public function getProgressAttribute()
// {
//     $totalItems = 0;
//     $completedItems = 0;

//     foreach ($this->component as $component) {
//         foreach ($component->details as $detail) {
//             $totalItems++;

//             $latestContent = $detail->contents
//                 ->sortByDesc('created_at')
//                 ->first();

//             if ($latestContent && $latestContent->status === 'Selesai') {
//                 $completedItems++;
//             }
//         }
//     }

//     return $totalItems > 0
//         ? round(($completedItems / $totalItems) * 100, 2)
//         : 0;
// }

public function getProgressAttribute()
    {
        $totalDetailCount = 0;
        $totalProgressSum = 0;

        // Iterasi melalui Component dan Details
        foreach ($this->component as $component) {
            // Asumsi relasi 'details' dan 'contents' sudah dimuat (eager loaded) di Controller.
            foreach ($component->details as $detail) {
                $totalDetailCount++; 
                $detailProgress = 0; // Default: 0%

                // Ambil content terbaru untuk detail ini
                // Pastikan relasi 'contents' ada di model Detail dan dimuat
                $latestContent = $detail->contents
                    ->sortByDesc('created_at')
                    ->first();

                if ($latestContent) {
                    if ($latestContent->status === 'Selesai') {
                        $detailProgress = 100;
                    } elseif ($latestContent->status === 'Proses') {
                        $detailProgress = 50;
                    } 
                    // Jika status lain/null, $detailProgress tetap 0
                }
                
                $totalProgressSum += $detailProgress;
            }
        }

        // Progress SubDomain adalah rata-rata progress semua Detail
        return $totalDetailCount > 0
            ? round($totalProgressSum / $totalDetailCount, 2)
            : 0;
    }
    
}

