<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPInformasi extends Model
{
    protected $table = 'sp_architecture_informasi';
    protected $fillable = ['user_id', 'pts_id', 'title'];

    public function informasi_comments()
    {
        return $this->hasMany(CommentInformasi::class, 'sp_informasi_id', 'id');
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
        return $this->hasMany(SPInformasiHistory::class, 'sp_informasi_id');
    }

    // Ambil versi terbaru
    public function latestHistory()
    {
        return $this->hasOne(SPInformasiHistory::class, 'sp_informasi_id')->latestOfMany();
    }
}
