<?php

namespace App\Http\Controllers;

use App\Models\RoleNavItem;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreRoleNavItemRequest;
use App\Http\Requests\UpdateRoleNavItemRequest;
use App\Models\NavItem;
use App\Models\Role;

class RoleNavItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rolenavitems = RoleNavItem::latest()->get()->unique('role_id');
        return view('backend.rolenavitems.index', compact('rolenavitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navitems = NavItem::get();
        $roles = Role::get();
        return view('backend.rolenavitems.create', compact('navitems','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleNavItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleNavItemRequest $request)
    {
        try {
            $roleId = $request->input('role');
            $selectedCompoents = $request->input('navitems');

            $role = Role::find($roleId);
            $navitems = NavItem::all();
            $role->navitems()->detach();

            if($selectedCompoents != null){
                    foreach($selectedCompoents as $navitemId => $navitem)
                    {
                        if (!$role->navitems->contains($navitemId)) {
                            $role->navitems()->attach($navitemId);
                        }
                    } 
                return redirect()->back()->withMessage(__('Recored Stored Successfully'));

            } 
            return redirect()->back()->withMessage(__('Recored Stored Successfully'));
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoleNavItem  $rolenavitem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rolenavitem = RoleNavItem::find($id);
        return view('backend.rolenavitems.show',compact('rolenavitem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoleNavItem  $rolenavitem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolenavitem = RoleNavItem::find($id);
        return view('backend.rolenavitems.edit',compact('rolenavitem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleNavItemRequest  $request
     * @param  \App\Models\RoleNavItem  $rolenavitem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleNavItemRequest $request, $id)
    {
        try{
            $rolenavitem = RoleNavItem::find($id);

            $rolenavitem->update($request->all());

            return redirect()->route('rolenavitems.index')->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoleNavItem  $rolenavitem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $rolenavitem = RoleNavItem::find($id);

            $rolenavitem->delete();

            return redirect()->route('rolenavitems.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
