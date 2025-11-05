<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDomainContent extends Model
{
    protected $table = 'subdomain_contents';
    protected $fillable = ['subdomain_id','university_id','title','description','status'];

    public function subdomain()
    {
        return $this->belongsTo(SubDomain::class, 'subdomain_id', 'id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(SubDomainContentDetail::class, 'subdomain_content_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany(SubDomainContentDetail::class, 'subdomain_content_id');
    }

    public function latest()
    {
        return $this->hasOne(SubDomainContentDetail::class, 'subdomain_content_id')->latestOfMany();
    }
}
