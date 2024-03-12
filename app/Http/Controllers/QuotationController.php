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
use App\Models\Bank;
use App\Models\ChangeHistories;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteItemValue;
use App\Models\Term;
use Illuminate\Support\Facades\DB;

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
        $categories = Category::get();
        return view('backend.quotations.create', compact('categories'));
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
            DB::beginTransaction();

            $quotationData = $request->except(['work_scope', 'amount']);

            $workScopes = $request->input('work_scope', []);
            $amounts = $request->input('amount', []);

            if($request->purpose == 'Residential (R)' && $request->type != null) {
                if($request->type == 'Basic (B)') {
                    $refPurpose = 'RB';
                } else if ($request->type == 'Premium (P)') {
                    $refPurpose = 'RP';
                } else if ($request->type == 'Compact Luxury (C)') {
                    $refPurpose = 'RC';
                } else if ($request->type == 'Luxury (L)') {
                    $refPurpose = 'RL';
                }
            } else if($request->purpose == 'Residential (R)') {
                $refPurpose = 'R';
            } else if($request->purpose == 'Commercial (C)') {
                $refPurpose = 'C';
            } else if($request->purpose == 'Architectural (A)') {
                $refPurpose = 'A';
            }


            $currentYear = Carbon::now()->format('Y');
            $currentYearLastTwoDigits = substr(date('Y'), -2);
            $nextReferenceNumber = Quotation::whereYear('created_at', $currentYear)->count() + 1;
            $referenceNumber = str_pad($nextReferenceNumber, 3, '0', STR_PAD_LEFT); // Pad with leading zeros
            
            $referenceCode = 'MNML/' . $request->input('name') . '/' . $currentYearLastTwoDigits . '-' . $referenceNumber . '-' . $refPurpose;
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

            $quote = Quote::create([
                'title'         => $request->input('name') . ' New Sheet',
                'quotation_id'  => $quotation->id,
                'version'       => 'V1.0',
                'date'          => now(),
                'created_by'    => auth()->user()->id
            ]);

            
            foreach ($quotation->quotationItems as $key => $quotationItem) {

                $quoteItem = QuoteItem::create([
                    'quote_id'      => $quote->id,
                    'category_id'   => $quotationItem->work_scope,
                    'sl'            => '1',
                    'created_by'    => auth()->user()->id
                ] );
        
            }

            DB::commit();
            
            return redirect()->route('quotations.index')->withMessage('Successful create :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function changeHistories(StoreQuotationRequest $request, $id)
    {
        try{

            $changeHistories = ChangeHistories::create([
                'quotation_id'  => $id,
                'version'       => $request->version,
                'change'        => $request->change,
                'date'          => now(),
                'created_by'    => auth()->user()->id
            ]);
            
            return redirect()->route('quotations.index')->withMessage('Successful Save :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function duplicate(StoreQuotationRequest $request, $id)
    {
        try{
            // DB::transaction();
            DB::transaction(function () use ($id) {
                $sheet = Quote::find($id);
                $quotation = Quotation::find($sheet->quotation_id);

                $purpose = $quotation->purpose;
                $type = $quotation->type;
                $name = $quotation->name;

                if($purpose == 'Residential (R)' && $type != null) {
                    if($type == 'Basic (B)') {
                        $refPurpose = 'RB';
                    } else if ($type == 'Premium (P)') {
                        $refPurpose = 'RP';
                    } else if ($type == 'Compact Luxury (C)') {
                        $refPurpose = 'RC';
                    } else if ($type == 'Luxury (L)') {
                        $refPurpose = 'RL';
                    }
                } else if($purpose == 'Residential (R)') {
                    $refPurpose = 'R';
                } else if($purpose == 'Commercial (C)') {
                    $refPurpose = 'C';
                } else if($purpose == 'Architectural (A)') {
                    $refPurpose = 'A';
                }


                $currentYear = Carbon::now()->format('Y');
                $currentYearLastTwoDigits = substr(date('Y'), -2);
                $nextReferenceNumber = Quotation::whereYear('created_at', $currentYear)->count() + 1;
                $referenceNumber = str_pad($nextReferenceNumber, 3, '0', STR_PAD_LEFT); // Pad with leading zeros
                
                $referenceCode = 'MNML/' . $name . '/' . $currentYearLastTwoDigits . '-' . $referenceNumber . '-' . $refPurpose. ' Copy ';

                $data = Quotation::create([
                    'ref'       => $referenceCode,
                    'name'      => $quotation->name,
                    'area'      => $quotation->area,
                    'address'   => $quotation->address,
                    'city'      => $quotation->city,
                    'purpose'   => $quotation->purpose,
                    'type'      => $quotation->type,
                    'date'      => now(),
                    'created_by' => auth()->user()->id
                ]);

                foreach ($quotation->quotationItems as $key => $value) {
                    QuotationItem::create([
                        'quotation_id'  => $data->id,
                        'work_scope'    => $value->work_scope,
                        'created_by'    => auth()->user()->id
                    ]);
                }

                $lastQuote = Quote::where('quotation_id', $data->id)->orderBy('id', 'desc')->first();
                if($lastQuote){
                    $version = $lastQuote->version;
                    // Split the version string into major and minor parts
                    list($major, $minor) = explode('.', $version);

                    // Increment the minor version
                    $minor++;

                    // Format the new version string
                    $newVersion = $major . '.' . $minor;
                } else {
                    $newVersion = 'V1.0';
                }

                

                $quoteCount = 1;
                $newTitle = $sheet->title. ' Copy';

                // Check if a title with the current suffix exists, if so, increment the suffix
                while (Quote::where('quotation_id', $data->id)->where('title', $newTitle)->exists()) {
                    $newTitle = $sheet->title . ' Copy ' . $quoteCount;
                    $quoteCount++;
                }

                $quote = Quote::create([
                    'title'         => $newTitle,
                    'quotation_id'  => $data->id,
                    'version'       => $newVersion,
                    'date'          => now(),
                    'created_by'    => auth()->user()->id
                ]);


                foreach ($sheet->quoteItems as $key => $quoteItem) {
                    $newquoteItem = QuoteItem::create([
                        'quote_id'          => $quote->id,
                        'category_id'       => $quoteItem->category_id,
                        'sl'                => $quoteItem->sl,
                        'item'              => $quoteItem->item,
                        'specification'     => $quoteItem->specification,
                        'qty'               => $quoteItem->qty,
                        'unit'              => $quoteItem->unit,
                        'rate'              => $quoteItem->rate,
                        'amount'            => $quoteItem->amount,
                        'created_by'        => auth()->user()->id
                    ]);

                    foreach ($quoteItem->quoteItemValues as $key => $quoteItemValue) {
                        $quoteItemValue = QuoteItemValue::create([
                            'quote_id'          => $quote->id,
                            'category_id'       => $quoteItemValue->category_id,
                            'quote_item_id'     => $newquoteItem->id,
                            'unique_header'     => $quoteItemValue->unique_header,
                            'header'            => $quoteItemValue->header,
                            'value'             => $quoteItemValue->value,
                            'created_by'        => auth()->user()->id
                        ]);
                    }
                }

            });
            
            return redirect()->route('quotations.index')->withMessage('Successful Duplicate :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function versionCopy($id)
    {
        try{
            DB::beginTransaction();
            $sheet = Quote::find($id);
            $lastQuote = Quote::where('quotation_id', $sheet->quotation_id)->orderBy('id', 'desc')->first();
            $version = $lastQuote->version;

            // Split the version string into major and minor parts
            list($major, $minor) = explode('.', $version);

            // Increment the minor version
            $minor++;

            // Format the new version string
            $newVersion = $major . '.' . $minor;

            $quoteCount = 1;
            $newTitle = $sheet->title. ' Copy';

            // Check if a title with the current suffix exists, if so, increment the suffix
            while (Quote::where('quotation_id', $sheet->quotation_id)->where('title', $newTitle)->exists()) {
                $newTitle = $sheet->title . ' Copy ' . $quoteCount;
                $quoteCount++;
            }

            $quote = Quote::create([
                'title'         => $newTitle,
                'quotation_id'  => $sheet->quotation_id,
                'version'       => $newVersion,
                'date'          => now(),
                'created_by'    => auth()->user()->id
            ]);


            foreach ($sheet->quoteItems as $key => $quoteItem) {
                $newquoteItem = QuoteItem::create([
                    'quote_id'          => $quote->id,
                    'category_id'       => $quoteItem->category_id,
                    'sl'                => $quoteItem->sl,
                    'item'              => $quoteItem->item,
                    'specification'     => $quoteItem->specification,
                    'qty'               => $quoteItem->qty,
                    'unit'              => $quoteItem->unit,
                    'rate'              => $quoteItem->rate,
                    'amount'            => $quoteItem->amount,
                    'created_by'        => auth()->user()->id
                ]);

                foreach ($quoteItem->quoteItemValues as $key => $quoteItemValue) {
                    $quoteItemValue = QuoteItemValue::create([
                        'quote_id'          => $quote->id,
                        'category_id'       => $quoteItemValue->category_id,
                        'quote_item_id'     => $newquoteItem->id,
                        'unique_header'     => $quoteItemValue->unique_header,
                        'header'            => $quoteItemValue->header,
                        'value'             => $quoteItemValue->value,
                        'created_by'        => auth()->user()->id
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('quotations.index')->withMessage('Successful Duplicate :)');
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
        $payments = Payment::get();
        $terms = Term::get();
        $bank = Bank::latest()->first();

        $view = view('backend.quotations.pdf', compact('quotation','organization','payments','terms','bank'))->render();

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

    public function quotationToSheet($id)
    {
        $sheet = Quote::where('quotation_id', $id)->orderBy('id', 'desc')->first();
        if($sheet != null) {
            return redirect()->route('go-to-sheet-edit', $sheet->id);
        }
    }
}
