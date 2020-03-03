<?php

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
    return view('welcome');
});

Auth::routes();

/**
 * all admin routes
 */
Route::group(['middleware' => ['\App\Http\Middleware\Admin']] , function(){
    /**
     * the dashboard
     */
    Route::get('/home', 'HomeController@index')->name('home');

    /**
     * users routes
     */
    Route::get('/users' , 'UsersController@index')->name('users');
    // store
    Route::post('/user/store' , 'UsersController@store')->name('user.store');
    // show
    Route::get('/user/show/{id}' , 'UsersController@show')->name('user.show');
    // edit
    Route::get('/user/edit/{id}' , 'UsersController@edit')->name('user.edit');
    // update
    Route::post('/user/update/{id}' , 'UsersController@update')->name('user.update');
    // delete
    Route::post('/user/delete/{id}' , 'UsersController@destroy')->name('user.delete');
    // export
    Route::get('/users/export/all' , 'UsersController@exportAll')->name('users.export');
    // import
    Route::post('/users/import' , 'UsersController@importJson')->name('users.import');


    /**
     * donatings routes
     */
    Route::get('/donates' , 'DonatesController@index')->name('donates');
    // store
    Route::post('/donate/store' , 'DonatesController@store')->name('donate.store');
    // show
    Route::get('/donate/show/{id}' , 'DonatesController@show')->name('donate.show');
    // edit
    Route::get('/donate/edit/{id}' , 'DonatesController@edit')->name('donate.edit');
    // update
    Route::post('/donate/update/{id}' , 'DonatesController@update')->name('donate.update');
    // delete
    Route::post('/donate/delete/{id}' , 'DonatesController@destroy')->name('donate.delete');
    // export
    Route::get('/donates/export/all' , 'DonatesController@exportAll')->name('donates.export');
    // import
    Route::post('/donates/import' , 'DonatesController@importJson')->name('donates.import');



    /**
     * donatings routes
     */
    Route::get('/DonatesCounter' , 'DonatesCounterController@index')->name('DonatesCounter');
    // store
    Route::post('/DonateCounter/store' , 'DonatesCounterController@store')->name('DonateCounter.store');
    // show
    Route::get('/DonateCounter/show/{id}' , 'DonatesCounterController@show')->name('DonateCounter.show');
    // edit
    Route::get('/DonateCounter/edit/{id}' , 'DonatesCounterController@edit')->name('DonateCounter.edit');
    // update
    Route::post('/DonateCounter/update/{id}' , 'DonatesCounterController@update')->name('DonateCounter.update');
    // delete
    Route::post('/DonateCounter/delete/{id}' , 'DonatesCounterController@destroy')->name('DonateCounter.delete');
    // export
    Route::get('/DonatesCounter/export/all' , 'DonatesCounterController@exportAll')->name('DonatesCounter.export');
    // import
    Route::post('/DonatesCounter/import' , 'DonatesCounterController@importJson')->name('DonatesCounter.import');

});
