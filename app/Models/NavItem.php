<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NavItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class)->withTimestamps();
    // }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'nav_item_role', 'nav_item_id', 'role_id');
    }

}
