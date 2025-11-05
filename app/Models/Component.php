<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'components';
    protected $fillable = ['subdomain_id','name','description'];

    public function subdomain()
    {
        return $this->belongsTo(SubDomain::class, 'subdomain_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(ComponentDetail::class, 'component_id', 'id');
    }
    
    // app/Models/Component.php

public function userPermissions()
{
    // Component memiliki banyak baris di tabel user_permissions
    return $this->hasMany(UserPermission::class, 'component_id', 'id');
}
}

