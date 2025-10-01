<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentAplikasi extends Model
{
    protected $table = 'architecture_aplikasi_comments';
    protected $fillable = ['user_id', 'sp_aplikasi_id','comment','status'];

    public function aplikasi()
    {
        return $this->belongsTo(SPAplikasi::class, 'sp_aplikasi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
