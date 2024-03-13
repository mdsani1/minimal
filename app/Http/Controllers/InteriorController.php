<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\Category;
use App\Models\Interior;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InteriorsExport;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreInteriorRequest;
use App\Http\Requests\UpdateInteriorRequest;
use App\Models\InteriorSpecification;

class InteriorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interiors = Interior::latest()->get();
        return view('backend.interiors.index', compact('interiors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBY('title','asc')->get();
        return view('backend.interiors.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInteriorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInteriorRequest $request)
    {
        try{
            $filename = null;

            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/interior', $filename);
            }

            $interiorData = $request->except('image','specification');
            if ($filename) {
                $interiorData['image'] = $filename;
            }

            $interior = Interior::create(['created_by' => auth()->user()->id] + $interiorData);

            if(isset($request->specification)){
                foreach ($request->specification as $key => $value) {
                    $interiorSpecification = InteriorSpecification::create([
                        'interior_id'   => $interior->id,
                        'specification' => $value,
                        'created_by'    => auth()->user()->id,
                    ]);
                }
            }

            return redirect()->route('interiors.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Interior  $interior
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interior = Interior::find($id);
        return view('backend.interiors.show',compact('interior'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Interior  $interior
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::orderBY('title','asc')->get();

        $interior = Interior::find($id);
        return view('backend.interiors.edit',compact('interior','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInteriorRequest  $request
     * @param  \App\Models\Interior  $interior
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInteriorRequest $request, $id)
    {
        try{
            $interior = Interior::find($id);

            
            $filename = null;
            
            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/interior', $filename);
            }
            $interiorData = $request->except('image','interiorSpecificationId', 'specification');
            if ($filename) {
                $interiorData['image'] = $filename;
            }

            $interior->update(['updated_by' => auth()->user()->id] + $interiorData);

            if(isset($request->specification)){
                foreach ($request->specification as $key => $value) {
    
                    if($request->interiorSpecificationId[$key] != null) {
                        $interiorSpecification = InteriorSpecification::find($request->interiorSpecificationId[$key]);
                        $interiorSpecification->update([
                            'specification' => $value,
                            'updated_by'    => auth()->user()->id,
                        ]);
                    } else {
                        $interiorSpecification = InteriorSpecification::create([
                            'interior_id'   => $interior->id,
                            'specification' => $value,
                            'created_by'    => auth()->user()->id,
                        ]);
                    }
                }
            }

            return redirect()->route('interiors.index')->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Interior  $interior
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $interior = Interior::find($id);
            $interior->update(['deleted_by' => auth()->user()->id]);
            $interior->delete();

            return redirect()->route('interiors.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function interiorspecificationDelete($id)
    {
        try{
            $interiorSpecification = InteriorSpecification::find($id);
            $interiorSpecification->update(['deleted_by' => auth()->user()->id]);
            $interiorSpecification->delete();

            return redirect()->back()->withMessage('Successful Delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $interior = Interior::onlyTrashed()->findOrFail($id);
            $interior->forceDelete();
            return redirect()->route('interiors.trash')->withMessage('Successfully Permanent Delete!');
        }catch(QueryException $e){
            echo $e->getMessage();
        }
    }

    public function trash()
    {
        try{
            $interior = Interior::onlyTrashed()->get();
            return view('backend.interiors.trash',[
                'interiors' => $interior
            ]);
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function restore($id)
    {
        try{
            $interior = Interior::onlyTrashed()->findOrFail($id);
            $interior->restore();
            $interior->update(['deleted_by' => null]);
            return redirect()->route('interiors.trash')->withMessage('Successfully Restore!');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function excel()
    {
        return Excel::download(new InteriorsExport, 'interior.xlsx');
    }

    public function pdf()
    {
        $interior = Interior::all();
        $pdf = PDF::loadView('backend.interiors.pdf', ['interiors' => $interior]);
        return $pdf->download('interiors.pdf');
    }
}
