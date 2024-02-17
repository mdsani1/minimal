<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function roleNavItems()
    {
        return $this->hasMany(RoleNavItem::class, 'nav_item_role');
    }

    // public function navitems()
    // {
    //     return $this->belongsToMany(NavItem::class);
    // }

    public function navitems()
    {
        return $this->belongsToMany(NavItem::class, 'nav_item_role', 'role_id', 'nav_item_id');
    }
}
