<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NavItem;
use App\Models\Role;

class RoleNavItemApiController extends Controller
{
    public function getNavitemWithSelected($roleId)
    {
        $role = Role::find($roleId);

        $navitems = NavItem::all();

        $collection = [];
        foreach($navitems as $navitem)
        {
            if ($role->navitems->contains($navitem->id)) {
                $collection[] = ['id'=>$navitem->id,'title'=>$navitem->title,'isSelected'=>1];
            } else {
                $collection[] = ['id'=>$navitem->id,'title'=>$navitem->title,'isSelected'=>0];
            }
        }
        $navItems = collect($collection)->chunk(count($collection));
        return response()->json($navItems, 200);
    }

}
