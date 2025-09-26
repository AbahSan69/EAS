<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCommentBisnis
 */
class CommentBisnis extends Model
{
    protected $table = 'architecture_bisnis_comments';
    protected $fillable = ['user_id', 'sp_bisnis_id','comment','status_review'];

    public function bisnis()
    {
        return $this->belongsTo(SPBisnis::class, 'sp_bisnis_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
