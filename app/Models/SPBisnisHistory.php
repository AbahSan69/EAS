<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPBisnisHistory extends Model
{
    protected $table = 'sp_architecture_bisnis_histories';
    protected $fillable = ['sp_bisnis_id', 'content', 'image', 'status', 'updated_by'];

    public function bisnis()
    {
        return $this->belongsTo(SPVision::class, 'sp_bisnis_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
