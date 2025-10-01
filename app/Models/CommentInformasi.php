<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentInformasi extends Model
{
    protected $table = 'architecture_informasi_comments';
    protected $fillable = ['user_id', 'sp_informasi_id','comment','status'];

    public function informasi()
    {
        return $this->belongsTo(SPInformasi::class, 'sp_informasi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
