<?php

namespace App\Http\Controllers;

use App\Exports\QuotationExport;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Bank;
use Intervention\Image\Facades\Image;
use App\Models\ChangeHistories;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\QuotationZoneManage;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteItemValue;
use App\Models\SubCategory;
use App\Models\Term;
use App\Models\TermInfo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
            // DB::beginTransaction();

            $quotationData = $request->except(['work_scope', 'amount','first_person','second_person','third_person','fourth_person','fifth_person']);

            $workScopes = $request->input('work_scope', []);
            $amounts = $request->input('amount', []);

            if($request->purpose == 'Residential (R)' && $request->type != null) {
                if($request->type == 'Basic (B)') {
                    $refPurpose = 'R/B';
                } else if ($request->type == 'Premium (P)') {
                    $refPurpose = 'R/P';
                } else if ($request->type == 'Compact Luxury (C)') {
                    $refPurpose = 'R/C';
                } else if ($request->type == 'Luxury (L)') {
                    $refPurpose = 'R/L';
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
            
            $referenceCode = 'MNML/' . $request->input('name') . '/' . $currentYearLastTwoDigits . '-' . $referenceNumber . '' . $refPurpose;
            $quotationData['ref'] = $referenceCode;

            $first_person = nl2br($request->input('first_person'));
            $second_person = nl2br($request->input('second_person'));
            $third_person = nl2br($request->input('third_person'));
            $fourth_person = nl2br($request->input('fourth_person'));
            $fifth_person = nl2br($request->input('fifth_person'));

            $quotationData['first_person'] = $first_person;
            $quotationData['second_person'] = $second_person;
            $quotationData['third_person'] = $third_person;
            $quotationData['fourth_person'] = $fourth_person;
            $quotationData['fifth_person'] = $fifth_person;

            if ($request->hasFile('first_person_signature')) {
                $image = $request->file('first_person_signature');
                $filename = 'first_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                $image->move(public_path('images'), $filename);

                $quotationData['first_person_signature'] = $filename;
            }

            if ($request->hasFile('second_person_signature')) {
                $image = $request->file('second_person_signature');
                $filename = 'second_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                $image->move(public_path('images'), $filename);

                $quotationData['second_person_signature'] = $filename;
            }

            if ($request->hasFile('third_person_signature')) {
                $image = $request->file('third_person_signature');
                $filename = 'third_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                $image->move(public_path('images'), $filename);

                $quotationData['third_person_signature'] = $filename;
            }

            if ($request->hasFile('fourth_person_signature')) {
                $image = $request->file('fourth_person_signature');
                $filename = 'fourth_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                $image->move(public_path('images'), $filename);

                $quotationData['fourth_person_signature'] = $filename;
            }

            if ($request->hasFile('fifth_person_signature')) {
                $image = $request->file('fifth_person_signature');
                $filename = 'fifth_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                $image->move(public_path('images'), $filename);

                $quotationData['fifth_person_signature'] = $filename;
            }

            $quotation = Quotation::create([
                'date'      => now(),
                'created_by' => auth()->user()->id
            ] + $quotationData);

            foreach ($workScopes as $index => $workScope) {
                $quotationItemData = [
                    'work_scope' => $workScope,
                    'quotation_id' => $quotation->id,
                ];
                QuotationItem::create(['created_by' => auth()->user()->id] + $quotationItemData);
            }

            $quote = Quote::create([
                'title'         => $request->input('name') . ' New Sheet',
                'quotation_id'  => $quotation->id,
                'version'       => 'V1.0',
                'change'        => '- Initial quotation',
                'date'          => now(),
                'created_by'    => auth()->user()->id
            ]);

            // DB::commit();
            
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
                        $refPurpose = 'R/B';
                    } else if ($type == 'Premium (P)') {
                        $refPurpose = 'R/P';
                    } else if ($type == 'Compact Luxury (C)') {
                        $refPurpose = 'R/C';
                    } else if ($type == 'Luxury (L)') {
                        $refPurpose = 'R/L';
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
                
                $referenceCode = 'MNML/' . $name . '/' . $currentYearLastTwoDigits . '-' . $referenceNumber . '' . $refPurpose. ' Copy ';

                $data = Quotation::create([
                    'ref'                           => $referenceCode,
                    'name'                          => $quotation->name,
                    'area'                          => $quotation->area,
                    'address'                       => $quotation->address,
                    'city'                          => $quotation->city,
                    'purpose'                       => $quotation->purpose,
                    'type'                          => $quotation->type,
                    'active_bank'                   => $quotation->active_bank,
                    'first_person'                  => $quotation->first_person,
                    'first_person_signature'        => $quotation->first_person_signature,
                    'second_person'                 => $quotation->second_person,
                    'second_person_signature'       => $quotation->second_person_signature,
                    'third_person'                  => $quotation->third_person,
                    'third_person_signature'        => $quotation->third_person_signature,
                    'fourth_person'                 => $quotation->third_person_signature,
                    'fourth_person_signature'       => $quotation->third_person_signature,
                    'fifth_person'                  => $quotation->third_person_signature,
                    'fifth_person_signature'        => $quotation->third_person_signature,
                    'date'                          => now(),
                    'created_by'                    => auth()->user()->id
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
                        'sub_category_id'   => $quoteItem->sub_category_id,
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
                            'sub_category_id'   => $quoteItemValue->sub_category_id,
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
            // DB::beginTransaction();
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
                    'sub_category_id'   => $quoteItem->sub_category_id,
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
                        'sub_category_id'   => $quoteItemValue->sub_category_id,
                        'quote_item_id'     => $newquoteItem->id,
                        'unique_header'     => $quoteItemValue->unique_header,
                        'header'            => $quoteItemValue->header,
                        'value'             => $quoteItemValue->value,
                        'created_by'        => auth()->user()->id
                    ]);
                }
            }

            // DB::commit();

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
            
            $quotationData = $request->except(['work_scope', 'amount', 'quotationItemId','first_person','second_person','third_person','fourth_person','fifth_person']);

            $workScopes = $request->input('work_scope', []);
            $amounts = $request->input('amount', []);
            $quotationItemIds = $request->input('quotationItemId', []);

            $first_person = $this->cleanInput($request->input('first_person'));
            $second_person = $this->cleanInput($request->input('second_person'));
            $third_person = $this->cleanInput($request->input('third_person'));
            $fourth_person = $this->cleanInput($request->input('fourth_person'));
            $fifth_person = $this->cleanInput($request->input('fifth_person'));



            $quotationData['first_person'] = $first_person;
            $quotationData['second_person'] = $second_person;
            $quotationData['third_person'] = $third_person;
            $quotationData['fourth_person'] = $fourth_person;
            $quotationData['fifth_person'] = $fifth_person;


            if ($request->hasFile('first_person_signature')) {
                $image = $request->file('first_person_signature');
                $filename = 'first_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                Image::make($image)->fit(200, 100)->save($path);

                $quotationData['first_person_signature'] = $filename;
            }

            if ($request->hasFile('second_person_signature')) {
                $image = $request->file('second_person_signature');
                $filename = 'second_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                Image::make($image)->fit(200, 100)->save($path);

                $quotationData['second_person_signature'] = $filename;
            }

            if ($request->hasFile('third_person_signature')) {
                $image = $request->file('third_person_signature');
                $filename = 'third_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                Image::make($image)->fit(200, 100)->save($path);

                $quotationData['third_person_signature'] = $filename;
            }

            if ($request->hasFile('fourth_person_signature')) {
                $image = $request->file('fourth_person_signature');
                $filename = 'fourth_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                Image::make($image)->fit(200, 100)->save($path);

                $quotationData['fourth_person_signature'] = $filename;
            }

            if ($request->hasFile('fifth_person_signature')) {
                $image = $request->file('fifth_person_signature');
                $filename = 'fifth_person_signature_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('images/' . $filename);
    
                // Resize and save the image
                Image::make($image)->fit(200, 100)->save($path);

                $quotationData['fifth_person_signature'] = $filename;
            }

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

    function cleanInput($input) {
        $input = nl2br($input);
        $input = preg_replace('/(<br\s*\/?>\s*){2,}/', '<br />', $input);
        return $input;
    }

    public function updateDate(UpdateQuotationRequest $request, $id)
    {
        try {
            
            $quotation = Quotation::find($id);

            $quotation->update(['updated_by' => auth()->user()->id] + $request->all());

            return redirect()->back()->withMessage('Successful update :)');
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

    public function quotationItemDelete($id)
    {
        try{
            $quotationItem = QuotationItem::find($id);
            $quotationItem->update(['deleted_by' => auth()->user()->id]);
            $quotationItem->delete();

            return redirect()->back()->withMessage('Successful delete :)');
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
        $quote = Quote::find($id);

        if ($quote) {
            $quotation = Quotation::find($quote->quotation->id);
            $organization = Organization::latest()->first();
            $payments = Payment::orderBy('sequence', 'asc')->get();
            $terms = Term::get();
            $bank = Bank::latest()->first();
            $termInfo = TermInfo::latest()->first();
            $data = [];

            foreach ($quotation->quotationItems as $quotationItem) {
                $categoryTitle = $quotationItem->category->title;
                $workScope = $quotationItem->work_scope;

                // Check if the work scope is associated with a sub-category
                $checkSubCategory = SubCategory::where('category_id', $workScope)->first();

                // Retrieve data based on whether it has a sub-category or not
                $quoteItemsQuery = QuoteItem::with('quoteItemValues')
                    ->where('quote_id', $id)
                    ->where('category_id', $workScope);

                if ($checkSubCategory == null) {
                    // No sub-category
                    $categoryData = $quoteItemsQuery->get();
                    if ($categoryData->isNotEmpty()) {
                        $data[$categoryTitle]['category'] = $categoryData;
                    }
                } else {
                    // With sub-category
                    $subCategoryData = $quoteItemsQuery->get()->groupBy('sub_category_id');
                    if ($subCategoryData->isNotEmpty()) {
                        $data[$categoryTitle]['subcategory'] = $subCategoryData;
                    }
                }
            }

            $quoteItems = QuoteItem::with('quoteItemValues')->orderBy('category_id','asc')->where('quote_id',$id)->get()->groupBy('category_id');
            $groupedItems = $quoteItems->map(function ($group) {
                return $group->sum('amount');
            });


            $externalMenus = QuoteItemValue::where('quote_id', $quote->id)->distinct()->pluck('header');
            $organization = Organization::latest()->first();

            $view = view('backend.quotations.pdf', compact('quotation','organization','payments','terms','bank','termInfo','groupedItems','quote','organization','externalMenus','quoteItems','data'))->render();
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'format' => 'A4',
                'margin_left' => 15,
                'margin_right' => 10,
                'margin_top' => 42,
                'margin_bottom' => 10,
            ]);

            $dateString = $quotation->date;
            $formattedDate = date("F j, Y", strtotime($dateString));

            // Build the HTML string for the header
            $headerHtml = '
            <div class="row">
                <div class="column">
                    <img src="' . public_path('backend/images/organization/'.$organization->image ?? '') . '" alt="" style="width: 70%">
                </div>
                <div class="column organization-details">
                    <div style="font-size: 8px">' . $organization->address . '</div>
                    <div>
                        <p style="font-size: 8px">' . $organization->phone . '</p>
                        <p style="font-size: 8px">' . $organization->email . '</p>
                        <p style="font-size: 8px"><a href="' . $organization->facebook . '">' . $organization->facebook . '</a></p>
                        <p style="font-size: 8px"><a href="' . $organization->website . '" target="_blank">' . $organization->website . '</a></p>
                        <p style="margin-top: 10px; font-size: 11px">' . $formattedDate . '</p>
                    </div>
                </div>
            </div>
            ';

            // Set the HTML header
            $mpdf->SetHTMLHeader($headerHtml);


            $mpdf->SetHTMLFooter('
                <table width="100%">
                    <tr>
                        <td style="border:none !important; width:33.3%" align="center" align="left"></td>
                        <td style="border:none !important; width:33.3%" align="center">Page {PAGENO} of {nb}</td>
                        <td style="border:none !important; width:33.3%" align="right">MINIMAL LIMITED</td>
                    </tr>
                </table>
            ');

            $mpdf->SetTitle('Quotation');
            $mpdf->WriteHTML($view);
            $mpdf->Output(time() . '-quotation' . ".pdf", "I");

        } else {
            return redirect()->back();
        }
    }

    public function quotationToSheet($id)
    {
        $sheet = Quote::where('quotation_id', $id)->orderBy('id', 'desc')->first();
        if($sheet != null) {
            return redirect()->route('go-to-sheet-edit', $sheet->id);
        }
    }

    public function quotationTitleUpdate(UpdateQuotationRequest $request, $id)
    {
        try {
            
            $quotation = Quotation::find($id);

            $quotation->update([
                'title'         => $request->title,
                'updated_by'    => auth()->user()->id
            ]);

            return redirect()->back()->withMessage('Successful update :)');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function sheetDateUpdate(UpdateQuotationRequest $request, $id)
    {
        try {
            
            $quote = Quote::find($id);

            $quote->update([
                'date'          => $request->date,
                'updated_by'    => auth()->user()->id
            ]);

            return redirect()->back()->withMessage('Successful update :)');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function sheetChangeUpdate(UpdateQuotationRequest $request, $id)
    {
        try {
            
            $quote = Quote::find($id);

            $quote->update([
                'change'          => $request->change,
                'updated_by'    => auth()->user()->id
            ]);

            return redirect()->back()->withMessage('Successful update :)');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function excel($id) 
    {
        return Excel::download(new QuotationExport($id), 'quotation.xlsx');    
    }

    public function quotationZone($id)
    {
        $categories = Category::orderBY('title','asc')->get();

        $quotation = Quotation::find($id);
        return view('backend.quotations.zone',compact('quotation','categories'));
    }

    public function zoneManage($quotagtionId, $categoryId)
    {
        $category = Category::find($categoryId);
        $quotation = Quotation::find($quotagtionId);
        $quotationZoneManage = QuotationZoneManage::where('quotation_id', $quotagtionId)->where('category_id', $categoryId)->get();

        return view('backend.quotations.zone-manage',compact('quotation','category','quotationZoneManage'));
    }

    public function deleteZone($quotagtionId, $categoryId, $subCategoryId)
    {
        try{
            $quotationZoneManage = QuotationZoneManage::create([
                'quotation_id'      => $quotagtionId,
                'category_id'       => $categoryId,
                'sub_category_id'   => $subCategoryId
            ]);
            $quotationZoneManage->update(['created_by' => auth()->user()->id]);
            return redirect()->back()->withMessage('Successfully Delete!');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function restoreZone($id)
    {
        try{
            $quotationZoneManage = QuotationZoneManage::find($id);
            $quotationZoneManage->delete();
            $quotationZoneManage->update(['deleted_by' => auth()->user()->id]);
            return redirect()->back()->withMessage('Successfully Restore!');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
