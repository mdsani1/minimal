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

        $navitems = NavItem::all()->sortBy('title');

        $collection = [];
        foreach($navitems as $navitem)
        {
            if ($role->navitems->contains($navitem->id)) {
                $collection[] = ['id'=>$navitem->id,'title'=>$navitem->title,'isSelected'=>1];
            } else {
                $collection[] = ['id'=>$navitem->id,'title'=>$navitem->title,'isSelected'=>0];
            }
        }
        
        // Check if the count of the collection is greater than 0
        if (count($collection) > 1) {
            $navItems = collect($collection)->chunk(count($collection)/2);
            return response()->json($navItems, 200);
        } else {
            // Handle the case where the collection is empty
            $navItems = collect($collection)->chunk(count($collection)/1);
            return response()->json($navItems, 200);
        }
    }

}
