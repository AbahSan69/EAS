<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSPVision
 */
class SPVision extends Model
{
    protected $table = 'sp_architecture_visions';
    protected $fillable = ['user_id', 'pts_id', 'vision_id', 'title'];

    public function vision_comments()
    {
        return $this->hasMany(CommentVision::class, 'sp_vision_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pts()
    {
        return $this->belongsTo(Pts::class, 'pts_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany(SPVisionHistory::class, 'sp_vision_id');
    }

    // Ambil versi terbaru
    public function latestHistory()
    {
        return $this->hasOne(SPVisionHistory::class, 'sp_vision_id')->latestOfMany();
    }
}
