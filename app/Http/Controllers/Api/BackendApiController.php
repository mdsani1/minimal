<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\Interior;
use App\Models\QuotationItem;

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
}