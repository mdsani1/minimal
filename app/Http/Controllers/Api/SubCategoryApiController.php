<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\QuotationItem;

class SubCategoryApiController extends Controller
{

    public function getSubCategory($category_id)
    {
        $data = SubCategory::where('category_id', $category_id)
                            ->selectRaw('id as id, title as text')
                            ->distinct('id')
                            ->get();

        if(!$data == null){
            return response()->json($data, 200);
        }else{
            return response()->json([
                "message" => "No Data Found!"
            ], 400);
        }
    }

    public function getCategory()
    {
        $data = Category::selectRaw('id as id, title as text')
                        ->distinct('id')
                        ->get();

        if(!$data == null){
            return response()->json($data, 200);
        }else{
            return response()->json([
                "message" => "No Data Found!"
            ], 400);
        }
    }

    public function quotationitemDelete($id)
    {
        $quotationItem = QuotationItem::find($id);
        $quotationItem->delete();
        return response()->json([
            'message' => 'Successfully Delete :)'
        ], 200);
    }
}