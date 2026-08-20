<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});


Route::get('/login',[App\Http\Controllers\LoginController::class,'Show'])->name('login');
Route::post('/login',[App\Http\Controllers\LoginController::class,'Login'])->name('login');
Route::get('/logout',[App\Http\Controllers\LoginController::class,'Logout'])->name('logout');
Route::get('/change-password',[App\Http\Controllers\LoginController::class,'ShowChangePassword'])->name('password.change');
Route::post('/change-password',[App\Http\Controllers\LoginController::class,'ChangePassword'])->name('password.update');
Route::get('/dashboard',[App\Http\Controllers\HomeController::class,'Show'])->name('dashboard');

Route::get('/customer',[App\Http\Controllers\CustomerController::class,'Show'])->name('customer');
Route::get('/customeradd',[App\Http\Controllers\CustomerController::class,'ShowAdd'])->name('customeradd');
Route::post('/customeradd',[App\Http\Controllers\CustomerController::class,'Add'])->name('customeradd');
Route::get('/customeredit/{id?}',[App\Http\Controllers\CustomerController::class,'ShowEdit'])->name('customeredit');
Route::post('/customeredit',[App\Http\Controllers\CustomerController::class,'Edit'])->name('customereditconfirm');

Route::get('/deviceType',[App\Http\Controllers\DeviceTypeController::class,'Show'])->name('deviceType');
Route::get('/deviceTypeadd',[App\Http\Controllers\DeviceTypeController::class,'ShowAdd'])->name('deviceTypeadd');
Route::post('/deviceTypeadd',[App\Http\Controllers\DeviceTypeController::class,'Add'])->name('deviceTypeadd');
Route::get('/deviceTypeedit/{id?}',[App\Http\Controllers\DeviceTypeController::class,'ShowEdit'])->name('deviceTypeedit');
Route::post('/deviceTypeedit',[App\Http\Controllers\DeviceTypeController::class,'Edit'])->name('deviceTypeeditconfirm');

Route::get('/parts',[App\Http\Controllers\PartsController::class,'Show'])->name('part');
Route::get('/partadd',[App\Http\Controllers\PartsController::class,'ShowAdd'])->name('partadd');
Route::post('/partadd',[App\Http\Controllers\PartsController::class,'Add'])->name('partadd');
Route::get('/partedit/{id?}',[App\Http\Controllers\PartsController::class,'ShowEdit'])->name('partedit');
Route::post('/partedit',[App\Http\Controllers\PartsController::class,'Edit'])->name('parteditconfirm');

Route::get('/serviceCentre',[App\Http\Controllers\ServiceCenterController::class,'Show'])->name('serviceCentre');
Route::get('/serviceCentreadd',[App\Http\Controllers\ServiceCenterController::class,'ShowAdd'])->name('serviceCentreadd');
Route::post('/serviceCentreadd',[App\Http\Controllers\ServiceCenterController::class,'Add'])->name('serviceCentreadd');
Route::get('/serviceCentreedit/{id?}',[App\Http\Controllers\ServiceCenterController::class,'ShowEdit'])->name('serviceCentreedit');
Route::post('/serviceCentreedit',[App\Http\Controllers\ServiceCenterController::class,'Edit'])->name('serviceCentreeditconfirm');

Route::get('/deviceVersion',[App\Http\Controllers\DeviceVersionController::class,'Show'])->name('deviceVersion');
Route::get('/deviceVersionadd',[App\Http\Controllers\DeviceVersionController::class,'ShowAdd'])->name('deviceVersionadd');
Route::post('/deviceVersionadd',[App\Http\Controllers\DeviceVersionController::class,'Add'])->name('deviceVersionadd');
Route::get('/deviceVersionedit/{id?}',[App\Http\Controllers\DeviceVersionController::class,'ShowEdit'])->name('deviceVersionedit');
Route::post('/deviceVersionedit',[App\Http\Controllers\DeviceVersionController::class,'Edit'])->name('deviceVersioneditconfirm');

Route::get('/problems',[App\Http\Controllers\ProblemsController::class,'Show'])->name('problems');
Route::get('/problemsadd',[App\Http\Controllers\ProblemsController::class,'ShowAdd'])->name('problemsadd');
Route::post('/problemsadd',[App\Http\Controllers\ProblemsController::class,'Add'])->name('problemsadd');
Route::get('/problemsedit/{id?}',[App\Http\Controllers\ProblemsController::class,'ShowEdit'])->name('problemsedit');
Route::post('/problemsedit',[App\Http\Controllers\ProblemsController::class,'Edit'])->name('problemseditconfirm');

Route::get('/technician',[App\Http\Controllers\TechnicianController::class,'Show'])->name('technician');
Route::get('/technicianadd',[App\Http\Controllers\TechnicianController::class,'ShowAdd'])->name('technicianadd');
Route::post('/technicianadd',[App\Http\Controllers\TechnicianController::class,'Add'])->name('technicianadd');
Route::get('/technicianedit/{id?}',[App\Http\Controllers\TechnicianController::class,'ShowEdit'])->name('technicianedit');
Route::post('/technicianedit',[App\Http\Controllers\TechnicianController::class,'Edit'])->name('technicianeditconfirm');

Route::get('/make',[App\Http\Controllers\MakeController::class,'Show'])->name('make');
Route::get('/makeadd',[App\Http\Controllers\MakeController::class,'ShowAdd'])->name('makeadd');
Route::post('/makeadd',[App\Http\Controllers\MakeController::class,'Add'])->name('makeadd');
Route::get('/makeedit/{id?}',[App\Http\Controllers\MakeController::class,'ShowEdit'])->name('makeedit');
Route::post('/makeedit',[App\Http\Controllers\MakeController::class,'Edit'])->name('makeeditconfirm');


Route::get('/component',[App\Http\Controllers\ComponentController::class,'Show'])->name('component');


Route::get('/devices',[App\Http\Controllers\DeviceController::class,'Show'])->name('devices');
Route::get('/devicesadd',[App\Http\Controllers\DeviceController::class,'ShowAdd'])->name('devicesadd');
Route::post('/devicesadd',[App\Http\Controllers\DeviceController::class,'Add'])->name('devicesadd');
Route::get('/devicesedit/{trans_dt?}/{trans_no?}',[App\Http\Controllers\DeviceController::class,'ShowEdit'])->name('devicesedit');
Route::post('/devicesedit',[App\Http\Controllers\DeviceController::class,'Edit'])->name('deviceseditconfirm');

Route::post('/devicesdelete',[App\Http\Controllers\DeviceController::class,'Delete'])->name('devicesdelete');


Route::get('/deviceSale',[App\Http\Controllers\DeviceSaleController::class,'Show'])->name('deviceSale');
Route::get('/deviceSaleadd',[App\Http\Controllers\DeviceSaleController::class,'ShowAdd'])->name('deviceSaleadd');
Route::post('/deviceSaleadd',[App\Http\Controllers\DeviceSaleController::class,'Add'])->name('deviceSaleadd');
Route::get('/deviceSaleedit/{trans_dt?}/{trans_no?}',[App\Http\Controllers\DeviceSaleController::class,'ShowEdit'])->name('deviceSaleedit');
Route::post('/deviceSaleedit',[App\Http\Controllers\DeviceSaleController::class,'Edit'])->name('deviceSaleeditconfirm');
Route::post('/deviceSaledelete',[App\Http\Controllers\DeviceSaleController::class,'Delete'])->name('deviceSaledelete');

Route::get('/stock-alert',[App\Http\Controllers\StockController::class,'alert'])->name('stock.alert');
Route::get('/stock-alert/add',[App\Http\Controllers\StockController::class,'showAdd'])->name('stock.alert.add');
Route::post('/stock-alert/add',[App\Http\Controllers\StockController::class,'storeAdd'])->name('stock.alert.store');
Route::get('/stock-alert/{mc_id}/edit',[App\Http\Controllers\StockController::class,'showEdit'])->name('stock.alert.edit');
Route::post('/stock-alert/{mc_id}/edit',[App\Http\Controllers\StockController::class,'update'])->name('stock.alert.update');
Route::post('/stock-alert/delete',[App\Http\Controllers\StockController::class,'delete'])->name('stock.alert.delete');


Route::group(['prefix'=>'reports','as'=>'reports.'], function(){
    Route::get('/stock', [App\Http\Controllers\Report\StockController::class,'Show'])->name('stock');

    Route::get('/warrantystatus', [App\Http\Controllers\Report\WarrantyStatusController::class,'Show'])->name('warrantystatus');
	 Route::get('/warrantystatusp', [App\Http\Controllers\Report\WarrantyStatusController::class,'ShowPurchase'])->name('warrantystatusp');
    Route::get('/warranty-current-month', [App\Http\Controllers\Report\WarrantyStatusController::class,'ShowCurrentMonthSale'])->name('warranty.current.month.sale');
    Route::get('/warranty-current-month-purchase', [App\Http\Controllers\Report\WarrantyStatusController::class,'ShowCurrentMonthPurchase'])->name('warranty.current.month.purchase');
    Route::get('/itemwisesale', [App\Http\Controllers\Report\ItemWiseSaleController::class,'Show'])->name('itemwisesale');
    Route::get('/itemwisein', [App\Http\Controllers\Report\ItemWiseInController::class,'Show'])->name('itemwisein');
    Route::get('/itemwisetrf', [App\Http\Controllers\Report\ItemWiseTransferController::class,'Show'])->name('itemwisetrf');
    
    Route::get('/customerwisesale', [App\Http\Controllers\Report\CustomerWiseSaleController::class,'Show'])->name('customerwisesale');
    Route::get('/datewiseinvoice', [App\Http\Controllers\Report\DateWiseInvoiceController::class,'Show'])->name('datewiseinvoice');
    Route::get('/deviceledger', [App\Http\Controllers\Report\DeviceLedgerController::class,'Show'])->name('deviceledger');
    Route::get('/devicesledgerbranch', [App\Http\Controllers\Report\DeviceLedgerBranchController::class,'Show'])->name('deviceledgerbranch');
	
    Route::get('/stock/test', [App\Http\Controllers\Report\DeviceTransferController::class,'Test'])->name('stockTest');
	
});

