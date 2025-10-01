<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPVisionHistory extends Model
{
    protected $table = 'sp_architecture_vision_histories';
    protected $fillable = ['sp_vision_id', 'content', 'image', 'status', 'updated_by'];

    public function visionMisi()
    {
        return $this->belongsTo(SPVision::class, 'sp_vision_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
