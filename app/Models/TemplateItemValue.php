<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateItemValue extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
