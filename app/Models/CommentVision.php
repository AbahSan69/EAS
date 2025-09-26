<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCommentVision
 */
class CommentVision extends Model
{
    protected $table = 'architecture_vision_comments';
    protected $fillable = ['user_id', 'sp_vision_id','comment','status_review'];

    public function vision()
    {
        return $this->belongsTo(SPVision::class, 'sp_vision_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
