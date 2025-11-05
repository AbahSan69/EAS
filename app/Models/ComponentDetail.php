<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentDetail extends Model
{
    protected $table = 'component_details';
    protected $fillable = ['component_id','university_id','title','description'];

    public function component()
    {
        return $this->belongsTo(Component::class, 'component_id', 'id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(ComponentContent::class, 'component_detail_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany(ComponentContent::class, 'component_detail_id');
    }

    public function latest()
    {
        return $this->hasOne(ComponentContent::class, 'component_detail_id')->latestOfMany();
    }
    
}

