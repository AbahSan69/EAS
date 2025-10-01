<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPTeknologi extends Model
{
    protected $table = 'sp_architecture_teknologi';
    protected $fillable = ['user_id', 'pts_id', 'title'];

    public function teknologi_comments()
    {
        return $this->hasMany(CommentTeknologi::class, 'sp_teknologi_id', 'id');
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
        return $this->hasMany(SPTeknologiHistory::class, 'sp_teknologi_id');
    }

    // Ambil versi terbaru
    public function latestHistory()
    {
        return $this->hasOne(SPTeknologiHistory::class, 'sp_teknologi_id')->latestOfMany();
    }
}
