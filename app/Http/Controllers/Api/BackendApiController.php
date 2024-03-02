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
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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

    public function quotesStore(Request $request)
    {
        try{
            $quote = Quote::where('quotation_id',$request->quotationId)->where('date', date('Y-m-d'))->latest()->first();
            if($quote != null){
                $quote->update([
                    'title'         => $request->quote_title,
                    'quotation_id'  => $request->quotationId,
                    'date'          => now(),
                ]);
            } else {
                $quote = Quote::create([
                    'title'         => $request->quote_title,
                    'quotation_id'  => $request->quotationId,
                    'date'          => now(),
                    'created_by'    => auth()->user()->id
                ]);
            }

            $quoteItems = QuoteItem::where('quote_id', $quote->id)->where('category_id', $request->category_id)->latest()->get();
            foreach ($quoteItems as $key => $data) {
                $data->delete();
            }

            $quoteItemvalues = QuoteItemValue::where('quote_id', $quote->id)->where('category_id', $request->category_id)->latest()->get();
            foreach ($quoteItemvalues as $key => $data) {
                $data->delete();
            }

            
            foreach ($request->item_data as $key => $value) {

                $interiorCheck = Interior::where('item',$value['item'])->first();

                if($interiorCheck == null) {
                    $interior = Interior::create([
                        'item'              => $value['item'],
                        'default_detail'    => $value['specification'],
                        'unit'              => $value['unit'],
                        'created_by'        => auth()->user()->id
                    ]);
                }

                $quoteItem = QuoteItem::create([
                    'quote_id'      => $quote->id,
                    'created_by'    => auth()->user()->id
                ] + $value);

            
                if ($request->missing_data && $request->missing_data[$key] !== null) { 
                    foreach ($request->missing_data[$key] as $menu => $menudata) {

                        $quoteItemvalue = QuoteItemValue::create([
                            'quote_id'              => $quote->id,
                            'quote_item_id'         => $quoteItem->id,
                            'category_id'           => $value['category_id'],
                            'header'                => $menu,
                            'value'                 => $menudata,
                            'created_by'            => auth()->user()->id
                        ]);
                    }
                }
            
            }
            
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
            $quoteCollection = Quote::with('quotation')->latest();
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
            // dd($request->all());
            $quote = Quote::find($id);
            $quote->update([
                'title'         => $request->quote_title,
                'date'          => now(),
                'updated_by'    => auth()->user()->id
            ]);
            
            foreach ($request->item_data as $key => $value) {

                $interiorCheck = Interior::where('item', $value['item'])->first();
                
                if($interiorCheck == null) {
                    $interior = Interior::create([
                        'item'              => $value['item'],
                        'default_detail'    => $value['specification'],
                        'unit'              => $value['unit'],
                        'created_by'        => auth()->user()->id
                    ]);
                }

                if(isset($value['quote_id'])){
                    $quoteItem = QuotationItem::find($value['quote_id']);
                    $quoteItem->update([
                        'quote_id'      => $quote->id,
                        'updated_by'    => auth()->user()->id
                    ] + $value);
                } else {
                    $quoteItem = QuotationItem::create([
                        'quote_id'      => $quote->id,
                        'updated_by'    => auth()->user()->id
                    ] + $value);
                }

            
                if ($request->missing_data && $request->missing_data[$key] !== null) { 
                    foreach ($request->missing_data[$key] as $menu => $menudata) {
                        if(isset($menudata['quoteItemValue']))
                        {
                            $quoteItemvalue = QuoteItemValue::find($menudata['quoteItemValue']); 
                            foreach ($menudata as $key => $item) {
                                if($key != 'quoteItemValue'){
                                    $quoteItemvalue->update([
                                        'quote_id'              => $quote->id,
                                        'quote_item_id'         => $quoteItem->id,
                                        'header'                => $key,
                                        'value'                 => $item,
                                        'updated_by'            => auth()->user()->id
                                    ]);
                                }
                            }
                        } else {
                            foreach ($menudata as $key => $item) {
                                $quoteItemvalue = QuoteItemValue::create([
                                    'quote_id'              => $quote->id,
                                    'quote_item_id'         => $quoteItem->id,
                                    'header'                => $key,
                                    'value'                 => $item,
                                    'created_by'            => auth()->user()->id
                                ]);
                            }
                        }
                    }
                }
            
            }
            
            return response()->json([
                "message" => "Successfull Update :)",
            ]);
        }catch(QueryException $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}