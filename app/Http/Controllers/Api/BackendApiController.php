<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\Interior;
use App\Models\QuotationItem;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteItemMenu;
use App\Models\QuoteItemValue;
use App\Models\Template;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackendApiController extends Controller
{
    public function suggestions()
    {
        $data = Interior::pluck('item')->toArray();
        $suggestions = $data;
        $suggestions = array_unique($suggestions);
        sort($suggestions);
        if(!$data == null){
            return response()->json($data, 200);
        }else{
            return response()->json([
                "message" => "No Data Found!"
            ], 400);
        }
    }

    public function addTemplate($id)
    {
        $checkTemplate = Template::where('quote_id', $id)->first();

        if($checkTemplate == null) {
            $template = Template::create([
                'quote_id'      => $id,
                'created_by'    => auth()->user()->id
            ]);
            return response()->json($template, 200);
        } else {
            return response()->json([
                "message" => "This Template Allready Add."
            ], 400);
        }
    }

    public function quotesStore(Request $request)
    {
        try{
            // dd($request->all());
            DB::beginTransaction();
            $quote = Quote::where('quotation_id',$request->quotationId)->where('title',$request->quote_title)->where('date', date('Y-m-d'))->latest()->first();
            if($quote != null){
                $quote->update([
                    'title'         => $request->quote_title,
                    'quotation_id'  => $request->quotationId,
                    'version'       => 'V1.0',
                    'date'          => now(),
                ]);
            } else {
                $quote = Quote::create([
                    'title'         => $request->quote_title,
                    'quotation_id'  => $request->quotationId,
                    'version'       => 'V1.0',
                    'date'          => now(),
                    'created_by'    => auth()->user()->id
                ]);
            }

            
            foreach ($request->item_data as $key => $value) {

                $interiorCheck = Interior::where('item',$value['item'])->first();

                if($interiorCheck == null) {
                    if($value['item'] != null) {
                        $interior = Interior::create([
                            'item'              => $value['item'],
                            'specification1'    => $value['specification'],
                            'unit'              => $value['unit'],
                            'created_by'        => auth()->user()->id
                        ]);
                    }
                }

                $quoteItem = QuoteItem::where('quote_id', $quote->id)->where('category_id', $request->category_id)->where('sl', $value['sl'])->latest()->first();
                if($quoteItem == null) {
                    $quoteItem = QuoteItem::create([
                        'quote_id'      => $quote->id,
                        'created_by'    => auth()->user()->id
                    ] + $value);
                } else {
                    $quoteItem->update([
                        'quote_id'      => $quote->id,
                        'created_by'    => auth()->user()->id
                    ] + $value);
                }

            
                if ($request->missing_data && $request->missing_data[$key] !== null) { 
                    foreach ($request->missing_data[$key] as $menu => $menudata) {

                        if(isset($menudata['uniqueHeader']))
                        {
                            $quoteItemvalue = QuoteItemValue::where('unique_header', $menudata['uniqueHeader'])->latest()->first(); 

                            if($quoteItemvalue != null) {
                                foreach ($menudata as $key => $item) {
                                    if($key != 'uniqueHeader'){
                                        $quoteItemvalue->update([
                                            'quote_id'              => $quote->id,
                                            'quote_item_id'         => $quoteItem->id,
                                            'header'                => $key,
                                            'value'                 => $item,
                                        ]);
                                    }
                                }
                            } else {
                                foreach ($menudata as $key => $item) {
                                    if($key != 'uniqueHeader'){
                                        $quoteItemvalue = QuoteItemValue::create([
                                            'quote_id'              => $quote->id,
                                            'quote_item_id'         => $quoteItem->id,
                                            'unique_header'         => $menudata['uniqueHeader'],
                                            'header'                => $key,
                                            'value'                 => $item,
                                            'created_by'            => auth()->user()->id
                                        ]);
                                    }
                                }
                            }

                            
                        }

                        // $quoteItemvalue = QuoteItemValue::create([
                        //     'quote_id'              => $quote->id,
                        //     'quote_item_id'         => $quoteItem->id,
                        //     'category_id'           => $value['category_id'],
                        //     'header'                => $menu,
                        //     'value'                 => $menudata,
                        //     'created_by'            => auth()->user()->id
                        // ]);
                    }
                }
            
            }

            DB::commit();
            
            return response()->json([
                "message" => "Successfull Create :)",
            ]);
        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()]);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list()
    {
        try{
            $quoteIds = Template::pluck('quote_id');
            $quoteCollection = Quote::whereIn('id', $quoteIds)->with('quotation')->latest();
            if(request('search')){
                $quotes = $quoteCollection->where('title','like', '%'.request('search').'%');
            }

            $quotes = $quoteCollection->get();
            return response()->json($quotes);

        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function quotesUpdate(Request $request, $id)
    {
        try{

            
            DB::beginTransaction();
            $quote = Quote::find($id);
            $quote->update([
                'title'         => $request->quote_title,
                'date'          => now(),
                'updated_by'    => auth()->user()->id
            ]);
            
            foreach ($request->item_data as $key => $value) {

                $interiorCheck = Interior::where('item',$value['item'])->first();

                if($interiorCheck == null) {
                    if($value['item'] != null) {
                        $interior = Interior::create([
                            'item'              => $value['item'],
                            'specification1'    => $value['specification'],
                            'unit'              => $value['unit'],
                            'created_by'        => auth()->user()->id
                        ]);
                    }
                }

                $quoteItem = QuoteItem::where('quote_id', $quote->id)->where('category_id', $request->category_id)->where('sub_category_id', $request->sub_category_id)->where('sl', $value['sl'])->latest()->first();
                if($quoteItem == null) {
                    $quoteItem = QuoteItem::create([
                        'quote_id'          => $quote->id,
                        'sub_category_id'   => $request->sub_category_id,
                        'created_by'        => auth()->user()->id
                    ] + $value);
                } else {
                    $quoteItem->update([
                        'quote_id'          => $quote->id,
                        'sub_category_id'   => $request->sub_category_id,
                        'created_by'        => auth()->user()->id
                    ] + $value);
                }
            
                if ($request->missing_data && $request->missing_data[$key] !== null) { 
                    foreach ($request->missing_data[$key] as $menu => $menudata) {

                        if(isset($menudata['uniqueHeader']))
                        {
                            $quoteItemvalue = QuoteItemValue::where('quote_id', $quote->id)->where('quote_item_id', $quoteItem->id)->where('unique_header', $menudata['uniqueHeader'])->latest()->first(); 

                            if($quoteItemvalue != null) {
                                foreach ($menudata as $key => $item) {
                                    if($key != 'uniqueHeader'){
                                        $quoteItemvalue->update([
                                            'quote_id'              => $quote->id,
                                            'quote_item_id'         => $quoteItem->id,
                                            'category_id'           => $request->category_id,
                                            'sub_category_id'       => $request->sub_category_id,
                                            'header'                => $key,
                                            'value'                 => $item,
                                        ]);
                                    }
                                }
                            } else {
                                foreach ($menudata as $key => $item) {
                                    if($key != 'uniqueHeader'){
                                        $quoteItemvalue = QuoteItemValue::create([
                                            'quote_id'              => $quote->id,
                                            'quote_item_id'         => $quoteItem->id,
                                            'category_id'           => $request->category_id,
                                            'sub_category_id'       => $request->sub_category_id,
                                            'unique_header'         => $menudata['uniqueHeader'],
                                            'header'                => $key,
                                            'value'                 => $item,
                                            'created_by'            => auth()->user()->id
                                        ]);
                                    }
                                }
                            }

                            
                        }
                    }
                }
            
            }

            DB::commit();
            
            return response()->json([
                "message" => "Successfull Update :)",
            ]);
        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}