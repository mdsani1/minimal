<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationZoneManage extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'quotation_zone_manages';

    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
