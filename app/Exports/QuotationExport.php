<?php

namespace App\Exports;

use App\Models\Bank;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Quotation;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteItemValue;
use App\Models\SubCategory;
use App\Models\Term;
use App\Models\TermInfo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class QuotationExport implements FromView
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $quote = Quote::find($this->id);

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
                    ->where('quote_id', $this->id)
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

            $quoteItems = QuoteItem::with('quoteItemValues')->orderBy('category_id','asc')->where('quote_id',$this->id)->get()->groupBy('category_id');
            $groupedItems = $quoteItems->map(function ($group) {
                return $group->sum('amount');
            });


            $externalMenus = QuoteItemValue::where('quote_id', $quote->id)->distinct()->pluck('header');
            $organization = Organization::latest()->first();
        }
        return view('backend.quotations.excel', compact('quotation','organization','payments','terms','bank','termInfo','groupedItems','quote','organization','externalMenus','quoteItems','data'));
    }
}
