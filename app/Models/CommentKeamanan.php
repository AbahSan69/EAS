<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentKeamanan extends Model
{
    protected $table = 'architecture_keamanan_comments';
    protected $fillable = ['user_id', 'sp_keamanan_id','comment','status'];

    public function keamanan()
    {
        return $this->belongsTo(SPKeamanan::class, 'sp_keamanan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
