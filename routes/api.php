<?php

use App\Http\Controllers\Api\BackendApiController;
use App\Http\Controllers\Api\RoleNavItemApiController;
use App\Http\Controllers\Api\SubCategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api', 'auth', 'web'], 'as' => 'api.'], function () {
    Route::get('get-role-navitems-with-selected/{id}', [RoleNavItemApiController::class,'getnavitemWithSelected']);
    Route::get('/get-sub-category/{category_id}', [SubCategoryApiController::class, 'getSubCategory']);
    Route::get('/get-category', [SubCategoryApiController::class, 'getCategory']);
    Route::get('/quotationitem-delete/{id}', [SubCategoryApiController::class, 'quotationitemDelete']);
    Route::get('/suggestions', [BackendApiController::class, 'suggestions']);
    Route::post('/quotes/store', [BackendApiController::class, 'quotesStore']);
    Route::put('/quotes/update/{id}', [BackendApiController::class, 'quotesUpdate']);
    Route::get('/sheet/list', [BackendApiController::class, 'list']);
});

