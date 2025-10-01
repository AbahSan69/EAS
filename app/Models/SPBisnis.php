<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSPBisnis
 */
class SPBisnis extends Model
{
    protected $table = 'sp_architecture_bisnis';
    protected $fillable = ['user_id', 'pts_id', 'bisnis_id', 'title'];

    public function bisnis_comments()
    {
        return $this->hasMany(CommentBisnis::class, 'sp_bisnis_id', 'id');
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
        return $this->hasMany(SPBisnisHistory::class, 'sp_bisnis_id');
    }

    // Ambil versi terbaru
    public function latestHistory()
    {
        return $this->hasOne(SPBisnisHistory::class, 'sp_bisnis_id')->latestOfMany();
    }
}
