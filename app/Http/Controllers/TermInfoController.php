<?php

namespace App\Http\Controllers;

use App\Models\TermInfo;
use App\Http\Requests\StoreTermInfoRequest;
use App\Http\Requests\UpdateTermInfoRequest;
use Illuminate\Database\QueryException;

class TermInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terminfos = TermInfo::latest()->get();
        return view('backend.terminfos.index', compact('terminfos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.terminfos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTermInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermInfoRequest $request)
    {
        try{
            $filename = null;

            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/terminfo', $filename);
            }

            $terminfoData = $request->except('image');
            if ($filename) {
                $terminfoData['image'] = $filename;
            }

            $terminfo = TermInfo::create(['created_by' => auth()->user()->id] + $terminfoData);

            return redirect()->route('terminfos.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TermInfo  $terminfo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $terminfo = TermInfo::find($id);
        return view('backend.terminfos.show',compact('terminfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermInfo  $terminfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $terminfo = TermInfo::find($id);
        return view('backend.terminfos.edit',compact('terminfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTermInfoRequest  $request
     * @param  \App\Models\TermInfo  $terminfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermInfoRequest $request, $id)
    {
        try{
            $terminfo = TermInfo::find($id);
            
            $filename = null;
            
            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/terminfo', $filename);
            }
            $terminfoData = $request->except('image');
            if ($filename) {
                $terminfoData['image'] = $filename;
            }

            $terminfo->update(['updated_by' => auth()->user()->id] + $terminfoData);

            return redirect()->back()->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermInfo  $terminfo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $terminfo = TermInfo::find($id);
            $terminfo->update(['deleted_by' => auth()->user()->id]);
            $terminfo->delete();

            return redirect()->route('terminfos.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
