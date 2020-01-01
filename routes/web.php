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
});
