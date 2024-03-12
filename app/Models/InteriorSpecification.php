<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InteriorSpecification extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public function interior()
    {
        return $this->belongsTo(Interior::class, 'interior_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
