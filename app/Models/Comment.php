<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'content_comments';
    protected $fillable = ['component_content_id','user_id','comment'];

    public function contents()
    {
        return $this->belongsTo(ComponentContent::class, 'component_content_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
