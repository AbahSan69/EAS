<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPAplikasi extends Model
{
    protected $table = 'sp_architecture_aplikasi';
    protected $fillable = ['user_id', 'pts_id', 'title'];

    public function aplikasi_comments()
    {
        return $this->hasMany(CommentAplikasi::class, 'sp_aplikasi_id', 'id');
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
        return $this->hasMany(SPAplikasiHistory::class, 'sp_aplikasi_id');
    }

    // Ambil versi terbaru
    public function latestHistory()
    {
        return $this->hasOne(SPAplikasiHistory::class, 'sp_aplikasi_id')->latestOfMany();
    }
}
