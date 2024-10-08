<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InteriorController;
use App\Http\Controllers\NavItemController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleNavItemController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TermInfoController;
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
    Route::get('/go-to-sheet', [DashboardController::class, 'goToSheet'])->name('go-to-sheet');
    Route::get('/template', [DashboardController::class, 'template'])->name('template');

    Route::get('/editable-table/{id?}', [DashboardController::class, 'editableTable'])->name('editableTable');
    Route::get('/sheet-pdf/{id}', [DashboardController::class, 'pdf'])->name('sheet.pdf');
    Route::delete('/sheet-delete/{id}', [DashboardController::class, 'destroy'])->name('sheet.delete');
    Route::get('/go-to-sheet/edit/{id}', [DashboardController::class, 'edit'])->name('go-to-sheet-edit');
    Route::get('/template/edit/{id}', [DashboardController::class, 'templateEdit'])->name('template-edit');
    Route::get('/template-pdf/{id}', [DashboardController::class, 'templatePdf'])->name('template.pdf');
    Route::delete('/template-delete/{id}', [DashboardController::class, 'templateDestroy'])->name('template.delete');
    Route::delete('/templateItem-delete/{id}', [DashboardController::class, 'templateItemDelete'])->name('templateItem-delete');
    Route::delete('/quotationItemZone-delete/{quotationId}/{quoteId}/{categoryId}/{zoneId}', [DashboardController::class, 'quotationItemZoneDelete'])->name('quotationItemZone-delete');
    


    Route::resource('roles', RoleController::class);
    Route::resource('navitems', NavItemController::class);
    Route::resource('rolenavitems', RoleNavItemController::class);


    Route::get('/database-backup', [DashboardController::class, 'databaseBackup'])->name('database-backup');

    
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
    Route::post('/zone/store', [SubCategoryController::class, 'zoneStore'])->name('zone.store');
    Route::resource('sub-categories', SubCategoryController::class);

    //interior crud
    Route::get('/interiors-trash', [InteriorController::class, 'trash'])->name('interiors.trash');
    Route::get('/interiors-trash/{interior}', [InteriorController::class, 'restore'])->name('interiors.restore');
    Route::get('/interiors-trash/{interior}/delete', [InteriorController::class, 'delete'])->name('interiors.delete');
    Route::get('/interiors-excel', [InteriorController::class, 'excel'])->name('interiors.excel');
    Route::get('/interiors-pdf', [InteriorController::class, 'pdf'])->name('interiors.pdf');
    Route::get('/interiorspecification/delete/{id}', [InteriorController::class, 'interiorspecificationDelete'])->name('interiorspecification.delete');

    Route::resource('interiors', InteriorController::class);

    //organization
    Route::resource('organizations', OrganizationController::class);

    //organization
    Route::get('/quotations-trash', [QuotationController::class, 'trash'])->name('quotations.trash');
    Route::get('/quotations-trash/{quotation}', [QuotationController::class, 'restore'])->name('quotations.restore');
    Route::get('/quotations-trash/{quotation}/delete', [QuotationController::class, 'delete'])->name('quotations.delete');
    Route::get('/quotations-pdf/{id}', [QuotationController::class, 'pdf'])->name('quotations.pdf');
    Route::get('/quotations-zone/{quotagtionId}', [QuotationController::class, 'quotationZone'])->name('quotations-zone');
    Route::get('/quotations-zone-manage/{quotagtionId}/{categoryId}', [QuotationController::class, 'zoneManage'])->name('quotations-zone-manage');
    Route::get('/quotations-zone-manage-delete/{quotagtionId}/{categoryId}/{sunCategoryId}', [QuotationController::class, 'deleteZone'])->name('quotations-zone-manage.delete');
    Route::get('/quotations-zone-manage-trash/{id}', [QuotationController::class, 'restoreZone'])->name('quotations-zone-manage.restore');


    Route::get('/quotations-excel/{id}', [QuotationController::class, 'excel'])->name('quotations.excel');
    Route::get('/quotation-to-sheet/{id}', [QuotationController::class, 'quotationToSheet'])->name('quotation-to-sheet');
    Route::get('/quotations-duplicate/{id}', [QuotationController::class, 'duplicate'])->name('quotations.duplicate');
    Route::get('/version-copy/{id}', [QuotationController::class, 'versionCopy'])->name('version-copy');
    Route::delete('/quotationItem-delete/{id}', [QuotationController::class, 'quotationItemDelete'])->name('quotationItem-delete');

    Route::patch('/quotation-title-update/{id}', [QuotationController::class, 'quotationTitleUpdate'])->name('quotation-title-update');
    Route::patch('/sheet-date-update/{id}', [QuotationController::class, 'sheetDateUpdate'])->name('sheet-date-update');
    Route::patch('/sheet-change-update/{id}', [QuotationController::class, 'sheetChangeUpdate'])->name('sheet-change-update');
    Route::patch('/quotaion-date-update/{id}', [QuotationController::class, 'updateDate'])->name('quotaion-date-update');


    Route::post('/change-histories/{id}', [QuotationController::class, 'changeHistories'])->name('change-histories');
    Route::resource('quotations', QuotationController::class);

    Route::resource('terms', TermController::class);
    Route::resource('terminfos', TermInfoController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('banks', BankController::class);
    Route::patch('/bank/update/{bank}', [BankController::class, 'bankUpdate'])->name('bank.update');
    Route::post('/term/update', [TermController::class, 'termUpdate'])->name('term.update');
    Route::post('/payment/update', [PaymentController::class, 'paymentUpdate'])->name('payment.update');
    Route::get('/quote/bank/{id}', [DashboardController::class, 'quoteBank'])->name('quote.bank');
});


require __DIR__.'/auth.php';    