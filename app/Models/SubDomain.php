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

    public function getProgressAttribute()
{
    $totalItems = 0;
    $completedItems = 0;

    foreach ($this->component as $component) {
        foreach ($component->details as $detail) {
            $totalItems++;

            $latestContent = $detail->contents
                ->sortByDesc('created_at')
                ->first();

            if ($latestContent && $latestContent->status === 'Selesai') {
                $completedItems++;
            }
        }
    }

    return $totalItems > 0
        ? round(($completedItems / $totalItems) * 100, 2)
        : 0;
}


    
}

