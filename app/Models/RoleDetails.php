<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleDetails extends Model
{
    protected $table = 'role_details';
    protected $fillable = ['role_id','university_id','name','position','description'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function user()
    {
        return $this->hasMany(User::class, 'role_detail_id');
    }
}
