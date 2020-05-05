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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::post('payment/pay', 'PaymentController@pay')->name('pay');
    Route::post('payment/approval', 'PaymentController@approval')->name('approval');
    Route::post('payment/cancelled', 'PaymentController@cancelled')->name('cancelled');
});
