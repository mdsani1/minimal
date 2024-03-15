<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateItem extends Model
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

    public function quoteItemValues()
    {
        return $this->hasMany(QuoteItemValue::class, 'quote_item_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function templateItemValues()
    {
        return $this->hasMany(TemplateItemValue::class, 'template_item_id');
    }
}
