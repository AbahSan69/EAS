<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentRead extends Model
{
    protected $table = 'comment_reads';
    protected $fillable = ['user_id','component_content_id','last_read_at'];

    public function contents()
    {
        return $this->belongsTo(ComponentContent::class, 'component_content_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
