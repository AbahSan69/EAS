<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPKeamananHistory extends Model
{
    protected $table = 'sp_architecture_keamanan_histories';
    protected $fillable = ['sp_keamanan_id', 'content', 'image', 'status', 'updated_by'];

    public function keamanan()
    {
        return $this->belongsTo(SPKeamanan::class, 'sp_keamananan_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
