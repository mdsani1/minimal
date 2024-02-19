<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\CategoriesExport;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try{

            $filename = null;

            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/category', $filename);
            }

            $categoryData = $request->except('image');
            if ($filename) {
                $categoryData['image'] = $filename;
            }

            $category = Category::create(['created_by' => auth()->user()->id] + $categoryData);

            return redirect()->route('categories.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return view('backend.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('backend.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try{
            $category = Category::find($id);
            
            $filename = null;
            
            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/category', $filename);
            }
            $categoryData = $request->except('image');
            if ($filename) {
                $categoryData['image'] = $filename;
            }

            $category->update(['updated_by' => auth()->user()->id] + $categoryData);

            return redirect()->route('categories.index')->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $category = Category::find($id);
            $category->update(['deleted_by' => auth()->user()->id]);
            $category->delete();

            return redirect()->route('categories.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->forceDelete();
            return redirect()->route('categories.trash')->withMessage('Successfully Permanent Delete!');
        }catch(QueryException $e){
            echo $e->getMessage();
        }
    }

    public function trash()
    {
        try{
            $category = Category::onlyTrashed()->get();
            return view('backend.categories.trash',[
                'categories' => $category
            ]);
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function restore($id)
    {
        try{
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->restore();
            $category->update(['deleted_by' => null]);
            return redirect()->route('categories.trash')->withMessage('Successfully Restore!');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function excel()
    {
        return Excel::download(new CategoriesExport, 'category.xlsx');
    }

    public function pdf()
    {
        $category = Category::all();
        $pdf = PDF::loadView('backend.categories.pdf', ['categories' => $category]);
        return $pdf->download('categories.pdf');
    }
}
