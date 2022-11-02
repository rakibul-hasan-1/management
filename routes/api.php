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
    Route::post('/getracks',[ProductController::class,'getracks']);
    Route::post('/savevariant',[ProductController::class,'savevariant']);
    Route::post('/getvariant',[ProductController::class,'getvariant']);

    //Order
    Route::get('/getorder',[OrderController::class,'index']);
    Route::post('/getvariantbycode',[OrderController::class,'getvariantbycode']);
    Route::post('/searchcustomer',[OrderController::class,'searchcustomer']);
});