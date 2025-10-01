<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPKeamanan extends Model
{
    protected $table = 'sp_architecture_keamanan';
    protected $fillable = ['user_id', 'pts_id', 'title'];

    public function keamanan_comments()
    {
        return $this->hasMany(CommentKeamanan::class, 'sp_keamanan_id', 'id');
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
        return $this->hasMany(SPKeamananHistory::class, 'sp_keamanan_id');
    }

    // Ambil versi terbaru
    public function latestHistory()
    {
        return $this->hasOne(SPKeamananHistory::class, 'sp_keamanan_id')->latestOfMany();
    }
}
