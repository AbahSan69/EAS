<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRole
 */
class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nama','description'];

    public function detail_role()
    {
        return $this->hasMany(RoleDetails::class);
    }
}
