<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRole
 */
class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nama'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
