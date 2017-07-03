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


Route::get('/remotesigntest','phpsdk\test\RemoteSignTest@test');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vista', function () {
    return view('vista');
});


Route::get('form',function(){
return view('form');
});

Route::get('pdfweb',function(){

$pdf= PDF::loadview('vista');
return $pdf->stream('contract.pdf');
});

Route::get('/submit','PDFController@getPDF');
//App\Http\Controllers\sdk-php-sample-master\com.qiyuesuo.Test\


//Route::get('sealtest','SealTest@test')

// Route::get ('util','util');

