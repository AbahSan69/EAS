<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentTeknologi extends Model
{
    protected $table = 'architecture_teknologi_comments';
    protected $fillable = ['user_id', 'sp_teknologi_id','comment','status'];

    public function teknologi()
    {
        return $this->belongsTo(SPTeknologi::class, 'sp_teknologi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
