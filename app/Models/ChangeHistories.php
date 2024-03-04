<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangeHistories extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
