<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPInformasiHistory extends Model
{
    protected $table = 'sp_architecture_informasi_histories';
    protected $fillable = ['sp_informasi_id', 'content', 'image', 'status', 'updated_by'];

    public function informasi()
    {
        return $this->belongsTo(SPInformasi::class, 'sp_informasi_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
