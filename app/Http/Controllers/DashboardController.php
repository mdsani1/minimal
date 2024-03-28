<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Land;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Quotation;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteItemValue;
use App\Models\Template;
use App\Models\TemplateItem;
use App\Models\TemplateItemValue;
use App\Models\Term;
use App\Models\TermInfo;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth()->user()->id)->first();

        if($user->role_id == 1 || $user->role_id == 2){
            return view('backend.dashboard');
        }
        else{
            return view('welcome');
        }
    }

    public function goToSheet()
    {
        $quotes = Quote::latest()->limit(6)->get();
        return view('backend.quotes.dashboard', compact('quotes'));
    }

    public function template()
    {
        $templates = Template::latest()->limit(6)->get();
        return view('backend.quotes.dashboard', compact('templates'));
    }

    public function editableTable($id = null)
    {
        $organization = Organization::latest()->first();
        $quotation = Quotation::find($id);
        $quotations = Quotation::latest()->get();
        $payments = Payment::get();
        $terms = Term::get();
        $bank = Bank::latest()->first();
        $termInfo = TermInfo::latest()->first();
        return view('backend.quotes.editable', compact('quotation','quotations','organization','payments','terms','bank','termInfo'));
    }

    public function pdf($id)
    {
        $quote = Quote::find($id);

        if ($quote) {
            $quoteZoneItems = QuoteItem::with('quoteItemValues')
                ->where('quote_id', $id)
                ->whereNotNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            // Retrieve QuoteItems with null sub_category_id
            $quoteWorkItems = QuoteItem::with('quoteItemValues')
                ->where('quote_id', $id)
                ->whereNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            if(!$quoteZoneItems->isEmpty()) {
                // Merge the two collections, ignoring keys from $quoteWorkItems if they exist in $quoteZoneItems
                $quoteItems = $quoteZoneItems->merge($quoteWorkItems->except($quoteZoneItems->keys()->all()));
            } else {
                $quoteItems = $quoteWorkItems;
            }


            $externalMenus = QuoteItemValue::where('quote_id', $quote->id)->distinct()->pluck('header');
            $organization = Organization::latest()->first();

            $view = view('backend.quotes.pdf', compact('quote','organization','externalMenus','quoteItems'))->render();

            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'format' => 'A4-L',
                'margin_left' => 4,
                'margin_right' => 0,
                'margin_top' => 4,
                'margin_bottom' => 0,
            ]);
            $mpdf->SetTitle('Quotation');
            $mpdf->WriteHTML($view);
            $mpdf->Output(time() . '-Sheet' . ".pdf", "I");
        } else {
            return redirect()->back();
        }

    }
    
    public function destroy($id)
    {
        try{
            $quote = Quote::find($id);
            $quote->update(['deleted_by' => auth()->user()->id]);
            $quote->delete();

            foreach ($quote->quoteItems as $key => $quoteItem) {
                $quoteItem->update(['deleted_by' => auth()->user()->id]);
                $quoteItem->delete();

                foreach ($quoteItem->quoteItemValues as $key => $quoteItemValue) {
                    $quoteItemValue->update(['deleted_by' => auth()->user()->id]);
                    $quoteItemValue->delete();
                }
            }

            return redirect()->route('quotations.index')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $quote = Quote::find($id);
        $organization = Organization::latest()->first();
        $quotations = Quotation::latest()->get();
        $externalMenus = QuoteItemValue::where('quote_id', $quote->id)->distinct()->pluck('header');
        $quoteItems = QuoteItem::with('quoteItemValues')->where('quote_id',$id)->get()->groupBy('category_id');
        $payments = Payment::get();
        $quotation = Quotation::find($quote->quotation_id);
        $terms = Term::get();
        $bank = Bank::latest()->first();
        $categories = Category::orderBY('title','asc')
                            ->pluck('title','id')
                            ->toArray();
        $termInfo = TermInfo::latest()->first();
        $quoteItems = QuoteItem::with('quoteItemValues')->where('quote_id',$id)->get()->groupBy('category_id');
        $groupedItems = $quoteItems->map(function ($group) {
            return $group->sum('amount');
        });

        return view('backend.quotes.edit', compact('quote','quotation','quotations','externalMenus','organization','quoteItems','payments','terms','bank','categories','termInfo','groupedItems'));
    }

    public function templateEdit($id)
    {
        $template = Template::find($id);
        $organization = Organization::latest()->first();
        $quotations = Quotation::latest()->get();
        $externalMenus = TemplateItemValue::where('template_id', $template->id)->distinct()->pluck('header');
        $templateItems = TemplateItem::with('templateItemValues')->where('template_id',$id)->get()->groupBy('category_id');
        $payments = Payment::get();
        $quotation = Quotation::find($template->quotation_id);
        $terms = Term::get();
        $bank = Bank::latest()->first();
        $termInfo = TermInfo::latest()->first();


        return view('backend.quotes.template-edit', compact('template','quotation','quotations','externalMenus','organization','templateItems','payments','terms','bank','termInfo'));
    }

    public function templatePdf($id)
    {
        $template = Template::find($id);

        if ($template) {
            $templateZoneItems = TemplateItem::with('templateItemValues')
                ->where('template_id', $id)
                ->whereNotNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            // Retrieve TemplateItems with null sub_category_id
            $templateWorkItems = TemplateItem::with('templateItemValues')
                ->where('template_id', $id)
                ->whereNull('sub_category_id')
                ->get()
                ->groupBy(['category_id', 'sub_category_id']);

            if(!$templateZoneItems->isEmpty()) {
                // Merge the two collections, ignoring keys from $templateWorkItems if they exist in $templateZoneItems
                $templateItems = $templateZoneItems->merge($templateWorkItems->except($templateZoneItems->keys()->all()));
            } else {
                $templateItems = $templateWorkItems;
            }


            // $templateItems = TemplateItem::with('templateItemValues')
            //         ->where('template_id', $id)
            //         ->get()
            //         ->groupBy(['category_id', 'sub_category_id']);

            $externalMenus = TemplateItemValue::where('template_id', $template->id)->distinct()->pluck('header');
            $organization = Organization::latest()->first();
    
            $view = view('backend.quotes.template-pdf', compact('template','organization','externalMenus','templateItems'))->render();
    
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'format' => 'A4-L',
                'margin_left' => 4,
                'margin_right' => 0,
                'margin_top' => 4,
                'margin_bottom' => 0,
            ]);
            $mpdf->SetTitle('Quotation');
            $mpdf->WriteHTML($view);
            $mpdf->Output(time() . '-Sheet' . ".pdf", "I");
        } else {
            return redirect()->back();
        }
    }

    public function templateDestroy($id)
    {
        try{
            $template = Template::find($id);
            $template->update(['deleted_by' => auth()->user()->id]);

            foreach ($template->templateItems as $key => $templateItem) {
                $templateItem->update(['deleted_by' => auth()->user()->id]);

                foreach ($templateItem->templateItemValues as $key => $templateItemValue) {
                    $templateItemValue->update(['deleted_by' => auth()->user()->id]);
                    $templateItemValue->delete();
                }

                $templateItem->delete();
            }

            $template->delete();


            return redirect()->route('template')->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function quoteBank($id)
    {
        $quote = Quote::find($id);
        $quote->quotation->update([
            'active_bank' => 1
        ]);
        return redirect()->back()->withMessage('Successful delete :)');
    }

    public function templateItemDelete($id)
    {
        try{
            $templateItem = TemplateItem::find($id);
            $templateItem->update(['deleted_by' => auth()->user()->id]);
            $templateItem->delete();

            return redirect()->back()->withMessage('Successful delete :)');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function quotationItemZoneDelete($quoteId, $zoneId)
    {
        try{
            $quoteItem = QuoteItem::where('quote_id', $quoteId)->where('sub_category_id', $zoneId)->first();
            $quoteItem->update(['deleted_by' => auth()->user()->id]);
            $quoteItem->delete();

            return redirect()->back()->withMessage('Successful delete :)');
        }catch(QueryException $e){
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}