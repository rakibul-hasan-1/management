<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\api\GodownController;
use App\Http\Controllers\api\RackController;
use App\Http\Controllers\api\SupplierController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('/getgodown',GodownController::class);
    Route::post('/godown/edits',[GodownController::class,'edits']);
    Route::post('/godown/update',[GodownController::class,'updates']);
    Route::post('/godown/delete',[GodownController::class,'delete']);

    //Dashboard
    Route::get('/getstock',[DashboardController::class,'getstock']);
    Route::get('/getrecentorder',[DashboardController::class,'getrecentorder']);
    Route::get('/detdashboarddetails',[DashboardController::class,'detdashboarddetails']);

    // Rack
    Route::resource('/getrack',RackController::class);
    Route::post('/rack/edits',[RackController::class,'edits']);
    Route::post('/rack/update',[RackController::class,'updates']);
    Route::post('/rack/delete',[RackController::class,'delete']);
    // Supplier
    Route::resource('/getsupplier',SupplierController::class);
    Route::post('/supplier/edits',[SupplierController::class,'edits']);
    Route::post('/supplier/update',[SupplierController::class,'updates']);
    Route::post('/supplier/delete',[SupplierController::class,'delete']);
    Route::post('/suppliertransaction/delete',[SupplierController::class,'suppliertransaction']);
    Route::post('/suppliertransaction',[SupplierController::class,'suppliertransaction']);
    Route::get('/suppliertransactionrequest',[SupplierController::class,'suppliertransactionrequest']);
    Route::post('/suppliertransaction/approve',[SupplierController::class,'suppliertransactionapprove']);
    Route::post('/createsuppliertransaction',[SupplierController::class,'createsuppliertransaction']);
    Route::post('/suppliertransactionfilter',[SupplierController::class,'suppliertransactionfilter']);
    Route::post('/supplierpendingtransactionfilter',[SupplierController::class,'supplierpendingtransactionfilter']);
    // Customer
    Route::resource('/getcustomer',CustomerController::class);
    Route::post('/customer/edits',[CustomerController::class,'edits']);
    Route::post('/customer/update',[CustomerController::class,'updates']);
    Route::post('/customer/delete',[CustomerController::class,'delete']);
    // Product
    Route::resource('/getproduct',ProductController::class);
    Route::post('/product/edits',[ProductController::class,'edits']);
    Route::post('/product/update',[ProductController::class,'updates']);
    Route::post('/product/delete',[ProductController::class,'delete']);
    Route::post('/product/approve',[ProductController::class,'approve']);
    Route::post('/getracks',[ProductController::class,'getracks']);
    Route::post('/savevariant',[ProductController::class,'savevariant']);
    Route::post('/getvariant',[ProductController::class,'getvariant']);
    Route::get('/getpendingproduct',[ProductController::class,'getpendingproduct']);

    //Order
    Route::get('/getorder',[OrderController::class,'index']);
    Route::post('/getvariantbycode',[OrderController::class,'getvariantbycode']);
    Route::post('/searchcustomer',[OrderController::class,'searchcustomer']);
    Route::post('/getunitss',[OrderController::class,'getunitss']);
    Route::post('/placeorder',[OrderController::class,'placeorder']);
    Route::post('/getorder',[OrderController::class,'getorder']);
    Route::Post("/getvariantbyorder",[OrderController::class,'getvariantbyorder']);
    Route::post('/deleteorder',[OrderController::class,'deleteorder']);

    //Transaction
    Route::get('/transaction',[TransactionController::class,'index']);
    Route::post('/transaction/approve',[TransactionController::class,'approve']);
    Route::post('/transaction/delete',[TransactionController::class,'delete']);
    Route::get('/pendingtransaction',[TransactionController::class,'pendingtransaction']);
    Route::post('/transactionfilter',[TransactionController::class,'transactionfilter']);
    Route::post('/pendingtransactionfilter',[TransactionController::class,'pendingtransactionfilter']);
    Route::post('/createtransaction',[TransactionController::class,'createtransaction']);

    //User
    Route::get('/getuser',[UserController::class,'index']);
    Route::post('/createuser',[UserController::class,'createuser']);
    Route::post('/getuserbyid',[UserController::class,'getuser']);
    Route::post('/updateuser',[UserController::class,'updateuser']);
    Route::get('/getuserdetails',[UserController::class,'getuserdetails']);
});