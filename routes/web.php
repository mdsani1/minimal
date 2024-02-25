<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InteriorController;
use App\Http\Controllers\NavItemController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleNavItemController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Models\Organization;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth','web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/editable-table', [DashboardController::class, 'editableTable'])->name('editableTable');

    Route::resource('roles', RoleController::class);
    Route::resource('navitems', NavItemController::class);
    Route::resource('rolenavitems', RoleNavItemController::class);

    //users crud
    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::get('/users-trash', [UserController::class, 'trash'])->name('users.trash');
    Route::get('/users-trash/{user}', [UserController::class, 'restore'])->name('users.restore');
    Route::get('/users-trash/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('/users-excel', [UserController::class, 'excel'])->name('users.excel');
    Route::get('/users-pdf', [UserController::class, 'pdf'])->name('users.pdf');

    //category crud
    Route::get('/categories-trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::get('/categories-trash/{category}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::get('/categories-trash/{category}/delete', [CategoryController::class, 'delete'])->name('categories.delete');
    Route::get('/categories-excel', [CategoryController::class, 'excel'])->name('categories.excel');
    Route::get('/categories-pdf', [CategoryController::class, 'pdf'])->name('categories.pdf');
    Route::resource('categories', CategoryController::class);

    //sub category crud
    Route::get('/sub-categories-trash', [SubCategoryController::class, 'trash'])->name('sub-categories.trash');
    Route::get('/sub-categories-trash/{sub_category}', [SubCategoryController::class, 'restore'])->name('sub-categories.restore');
    Route::get('/sub-categories-trash/{sub_category}/delete', [SubCategoryController::class, 'delete'])->name('sub-categories.delete');
    Route::get('/sub-categories-excel', [SubCategoryController::class, 'excel'])->name('sub-categories.excel');
    Route::get('/sub-categories-pdf', [SubCategoryController::class, 'pdf'])->name('sub-categories.pdf');
    Route::resource('sub-categories', SubCategoryController::class);

    //interior crud
    Route::get('/interiors-trash', [InteriorController::class, 'trash'])->name('interiors.trash');
    Route::get('/interiors-trash/{interior}', [InteriorController::class, 'restore'])->name('interiors.restore');
    Route::get('/interiors-trash/{interior}/delete', [InteriorController::class, 'delete'])->name('interiors.delete');
    Route::get('/interiors-excel', [InteriorController::class, 'excel'])->name('interiors.excel');
    Route::get('/interiors-pdf', [InteriorController::class, 'pdf'])->name('interiors.pdf');
    Route::resource('interiors', InteriorController::class);

    //organization
    Route::resource('organizations', OrganizationController::class);

    //organization
    Route::get('/quotations-trash', [QuotationController::class, 'trash'])->name('quotations.trash');
    Route::get('/quotations-trash/{quotation}', [QuotationController::class, 'restore'])->name('quotations.restore');
    Route::get('/quotations-trash/{quotation}/delete', [QuotationController::class, 'delete'])->name('quotations.delete');
    Route::get('/quotations-pdf/{id}', [QuotationController::class, 'pdf'])->name('quotations.pdf');
    Route::resource('quotations', QuotationController::class);
});


require __DIR__.'/auth.php';