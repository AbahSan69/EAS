<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPAplikasiHistory extends Model
{
    protected $table = 'sp_architecture_aplikasi_histories';
    protected $fillable = ['sp_aplikasi_id', 'content', 'image', 'status', 'updated_by'];

    public function aplikasi()
    {
        return $this->belongsTo(SPVision::class, 'sp_aplikasi_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
