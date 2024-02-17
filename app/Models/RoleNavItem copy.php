<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleNavItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'nav_item_role';
    protected $guarded = [];

    public function role()
    {
        return $this->hasOne(Role::class);
    }
}
