<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', 'AuthController@register');
Route::get('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');
Route::get('recover', 'AuthController@recover');

/**
 * generate razorpay order id  
 */
Route::post('razorpay/create/order/id' , 'PaymentsController@GenerateRazorpayOrderId');

/**
 * needs auth routes
 */
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');

    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});

/**
 * get last payments
 */
Route::get('previews/{limit}' , 'PreviewsController@previews');


/**
 * store the payment
 */
Route::post('store/paypal/payment' , 'PreviewsController@storePaypal');
/**
 * for razorpay
 */
Route::post('store/razorpay/payment' , 'PreviewsController@storeRazorpay');


/**
 * get last trees amount
 */
Route::get('trees/amount/last' , 'PreviewsController@treesAmount');

/**
 * store subscribe request
 */
Route::post('trees/subscribe/request' , 'SubscribersController@subscribe');