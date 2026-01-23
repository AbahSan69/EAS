<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentContent extends Model
{
    protected $table = 'component_contents';
    protected $fillable = ['component_detail_id','updated_by','content_type','text','file_path','link_url','status'];

    public function detail()
    {
        return $this->belongsTo(ComponentDetail::class, 'component_detail_id', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function comments()
    {
        // User memiliki banyak baris di tabel user_permissions
        return $this->hasMany(Comment::class, 'component_content_id', 'id');
    }

    public function commentReads()
    {
        return $this->hasMany(CommentRead::class, 'component_content_id');
    }
}

