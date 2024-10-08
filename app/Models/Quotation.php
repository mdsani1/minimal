<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    public function sheets()
    {
        return $this->hasMany(Quote::class, 'quotation_id');
    }

    public function changeHistories()
    {
        return $this->hasMany(ChangeHistories::class, 'quotation_id');
    }
}
