<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPTeknologiHistory extends Model
{
    protected $table = 'sp_architecture_teknologi_histories';
    protected $fillable = ['sp_teknologi_id', 'content', 'image', 'status', 'updated_by'];

    public function teknologi()
    {
        return $this->belongsTo(SPTeknologi::class, 'sp_teknologi_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
