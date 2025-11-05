<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $table = 'universities';
    protected $fillable = ['name','type','code','estabilished_year',];

    public function detail_role()
    {
        return $this->hasMany(RoleDetails::class);
    }

    public function component()
    {
        return $this->hasMany(Component::class, 'university_id', 'id');
    }
}
