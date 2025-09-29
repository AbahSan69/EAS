<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPts
 */
class Pts extends Model
{
    protected $table = 'pts';
    protected $fillable = ['user_id','nama', 'jenis'];

    public function vision()
    {
        return $this->hasMany(SPVision::class, 'pts_id', 'id');
    }
}
