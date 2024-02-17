<?php

namespace App\Http\Controllers;

use App\Models\NavItem;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreNavItemRequest;
use App\Http\Requests\UpdateNavItemRequest;

class NavItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navitems = NavItem::latest()->get();
        return view('backend.navitems.index', compact('navitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.navitems.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNavItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNavItemRequest $request)
    {
        try{

            $navitem = NavItem::create($request->all());

            return redirect()->route('navitems.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NavItem  $navitem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $navitem = NavItem::find($id);
        return view('backend.navitems.show',compact('navitem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NavItem  $navitem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $navitem = NavItem::find($id);
        return view('backend.navitems.edit',compact('navitem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNavItemRequest  $request
     * @param  \App\Models\NavItem  $navitem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNavItemRequest $request, $id)
    {
        try{
            $navitem = NavItem::find($id);

            $navitem->update($request->all());

            return redirect()->route('navitems.index')->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NavItem  $navitem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $navitem = NavItem::find($id);

            $navitem->delete();

            return redirect()->route('navitems.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
