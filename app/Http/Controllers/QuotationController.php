<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Organization;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::latest()->get();
        return view('backend.quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.quotations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuotationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuotationRequest $request)
    {
        try{

            $quotationData = $request->except(['work_scope', 'amount']);

            $workScopes = $request->input('work_scope', []);
            $amounts = $request->input('amount', []);

            $currentYear = Carbon::now()->format('Y');
            $nextReferenceNumber = Quotation::whereYear('created_at', $currentYear)->count() + 1;
            $referenceNumber = str_pad($nextReferenceNumber, 3, '0', STR_PAD_LEFT); // Pad with leading zeros
            
            $referenceCode = 'MNML/' . $request->input('name') . '/' . $currentYear . '-' . $referenceNumber;
            $quotationData['ref'] = $referenceCode;

            $quotation = Quotation::create([
                'date'      => now(),
                'created_by' => auth()->user()->id
            ] + $quotationData);

            foreach ($workScopes as $index => $workScope) {
                $quotationItemData = [
                    'work_scope' => $workScope,
                    'amount' => $amounts[$index] ?? null, // safeguard in case array sizes are not matching
                    'quotation_id' => $quotation->id,
                ];
                QuotationItem::create(['created_by' => auth()->user()->id] + $quotationItemData);
            }
            
            return redirect()->route('quotations.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::find($id);
        return view('backend.quotations.show',compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::orderBY('title','asc')->get();

        $quotation = Quotation::find($id);
        return view('backend.quotations.edit',compact('quotation','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuotationRequest  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuotationRequest $request, $id)
    {
        try {
            $quotation = Quotation::find($id);
            
            $quotationData = $request->except(['work_scope', 'amount', 'quotationItemId']);

            $workScopes = $request->input('work_scope', []);
            $amounts = $request->input('amount', []);
            $quotationItemIds = $request->input('quotationItemId', []);

            $quotation->update(['updated_by' => auth()->user()->id] + $quotationData);

            foreach ($workScopes as $index => $workScope) {
                $quotationItemData = [
                    'work_scope' => $workScope,
                    'amount' => $amounts[$index] ?? null, // safeguard in case array sizes are not matching
                    'quotation_id' => $quotation->id,
                ];

                // Check if a quotation item ID exists at this index
                if(isset($quotationItemIds[$index])) {
                    $quotationItemId = $quotationItemIds[$index];
                    $quotationItem = QuotationItem::find($quotationItemId);
                    // Update existing quotation item
                    $quotationItem->update(['updated_by' => auth()->user()->id] + $quotationItemData);
                } else {
                    // Create new quotation item
                    QuotationItem::create(['created_by' => auth()->user()->id] + $quotationItemData);
                }
            }

            return redirect()->route('quotations.index')->withMessage('Successful update :)');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $quotation = Quotation::find($id);
            $quotation->update(['deleted_by' => auth()->user()->id]);
            $quotation->delete();

            return redirect()->route('quotations.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $quotation = Quotation::onlyTrashed()->findOrFail($id);
            $quotation->forceDelete();
            return redirect()->route('quotations.trash')->withMessage('Successfully Permanent Delete!');
        }catch(QueryException $e){
            echo $e->getMessage();
        }
    }

    public function trash()
    {
        try{
            $quotation = Quotation::onlyTrashed()->get();
            return view('backend.quotations.trash',[
                'quotations' => $quotation
            ]);
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function restore($id)
    {
        try{
            $quotation = Quotation::onlyTrashed()->findOrFail($id);
            $quotation->restore();
            $quotation->update(['deleted_by' => null]);
            return redirect()->route('quotations.trash')->withMessage('Successfully Restore!');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function pdf($id)
    {
        $quotation = Quotation::find($id);
        $organization = Organization::latest()->first();

        $view = view('backend.quotations.pdf', compact('quotation','organization'))->render();

        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'format' => 'A4',
            'margin_left' => 4,
            'margin_right' => 0,
            'margin_top' => 4,
            'margin_bottom' => 0,
        ]);
        $mpdf->SetTitle('Quotation');
        $mpdf->WriteHTML($view);
        $mpdf->Output(time() . '-quotation' . ".pdf", "I");
    }
}
