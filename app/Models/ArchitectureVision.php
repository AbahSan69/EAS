<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperArchitectureVision
 */
class ArchitectureVision extends Model
{
    protected $table = 'architecture_visions';
    protected $fillable = ['judul', 'deskripsi'];
}
