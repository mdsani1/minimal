<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\Category;
use App\Models\SubCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\CategoriesExport;
use App\Exports\SubCategoriesExport;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBY('title','asc')
                            ->pluck('title','id')
                            ->toArray();
        return view('backend.subcategories.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubCategoryRequest $request)
    {
        try{

            $filename = null;

            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/subcategory', $filename);
            }

            $subcategoryData = $request->except('image');
            if ($filename) {
                $subcategoryData['image'] = $filename;
            }

            $subcategory = SubCategory::create(['created_by' => auth()->user()->id] + $subcategoryData);

            return redirect()->route('sub-categories.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function zoneStore(StoreSubCategoryRequest $request)
    {
        try{

            $filename = null;

            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/subcategory', $filename);
            }

            $subcategoryData = $request->except('image');
            if ($filename) {
                $subcategoryData['image'] = $filename;
            }

            $subcategory = SubCategory::create(['created_by' => auth()->user()->id] + $subcategoryData);

            return redirect()->back()->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = SubCategory::find($id);
        return view('backend.subcategories.show',compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::orderBY('title','asc')
                            ->pluck('title','id')
                            ->toArray();
        $subcategory = SubCategory::find($id);
        return view('backend.subcategories.edit',compact('subcategory','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubCategoryRequest  $request
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoryRequest $request, $id)
    {
        try{
            $subcategory = SubCategory::find($id);
            
            $filename = null;
            
            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/subcategory', $filename);
            }
            $subcategoryData = $request->except('image');
            if ($filename) {
                $subcategoryData['image'] = $filename;
            }

            $subcategory->update(['updated_by' => auth()->user()->id] + $subcategoryData);

            return redirect()->route('sub-categories.index')->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $subcategory = SubCategory::find($id);
            $subcategory->update(['deleted_by' => auth()->user()->id]);
            $subcategory->delete();

            return redirect()->route('sub-categories.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $subcategory = SubCategory::onlyTrashed()->findOrFail($id);
            $subcategory->forceDelete();
            return redirect()->route('sub-categories.trash')->withMessage('Successfully Permanent Delete!');
        }catch(QueryException $e){
            echo $e->getMessage();
        }
    }

    public function trash()
    {
        try{
            $subcategory = SubCategory::onlyTrashed()->get();
            return view('backend.subcategories.trash',[
                'subcategories' => $subcategory
            ]);
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function restore($id)
    {
        try{
            $subcategory = SubCategory::onlyTrashed()->findOrFail($id);
            $subcategory->restore();
            $subcategory->update(['deleted_by' => null]);
            return redirect()->route('sub-categories.trash')->withMessage('Successfully Restore!');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function excel()
    {
        return Excel::download(new SubCategoriesExport, 'subcategory.xlsx');
    }

    public function pdf()
    {
        $subcategory = SubCategory::all();
        $pdf = PDF::loadView('backend.subcategories.pdf', ['subcategories' => $subcategory]);
        return $pdf->download('subcategories.pdf');
    }
}
