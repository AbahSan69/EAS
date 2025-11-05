<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDomainContentDetail extends Model
{
    protected $table = 'subdomain_content_details';
    protected $fillable = ['subdomain_content_id','updated_by','content_type','text','file_path','link_url'];

    public function detail()
    {
        return $this->belongsTo(ComponentDetail::class, 'component_detail_id', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
