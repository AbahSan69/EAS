<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentHistory extends Model
{
    protected $table = 'component_histories';
    protected $fillable = ['component_id','updated_by','content','image','status'];

    public function component()
    {
        return $this->belongsTo(Component::class, 'component_id', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
