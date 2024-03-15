<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Http\Requests\StoreTermRequest;
use App\Http\Requests\UpdateTermRequest;
use Illuminate\Database\QueryException;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::latest()->get();
        return view('backend.terms.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTermRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermRequest $request)
    {
        try{

            $filename = null;

            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/term', $filename);
            }

            $termData = $request->except('image');
            if ($filename) {
                $termData['image'] = $filename;
            }

            $term = Term::create(['created_by' => auth()->user()->id] + $termData);

            return redirect()->route('terms.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $term = Term::find($id);
        return view('backend.terms.show',compact('term'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = Term::find($id);
        return view('backend.terms.edit',compact('term'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTermRequest  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermRequest $request, $id)
    {
        try{
            $term = Term::find($id);
            
            $filename = null;
            
            if($request->file('image')){
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('backend/images/term', $filename);
            }
            $termData = $request->except('image');
            if ($filename) {
                $termData['image'] = $filename;
            }

            $term->update(['updated_by' => auth()->user()->id] + $termData);

            return redirect()->route('terms.index')->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function termUpdate(UpdateTermRequest $request)
    {
        try{
            // Retrieve all term IDs submitted through the form
            $termIds = $request->input('termId');
            
            // Retrieve all titles submitted through the form
            $titles = $request->input('title');
            
            // Loop through the submitted term IDs and titles
            foreach ($termIds as $key => $termId) {
                // If term ID exists, update the corresponding term record
                if ($termId) {
                    $term = Term::find($termId);
                    if ($term) {
                        $term->title = $titles[$key];
                        $term->save();
                    }
                } else {
                    // If term ID doesn't exist, create a new term record
                    $newTerm = new Term();
                    $newTerm->title = $titles[$key];
                    $newTerm->save();
                }
            }
            
            // Delete terms which were not updated or created
            Term::whereNotIn('id', $termIds)->delete();

            return redirect()->back()->withMessage('Successful update :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $term = Term::find($id);
            $term->update(['deleted_by' => auth()->user()->id]);
            $term->delete();

            return redirect()->route('terms.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
