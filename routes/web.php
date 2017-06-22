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
Route::get('/vista', function () {
    return view('vista');
});


// Route::get('/PDF',function(){
// $pdf= PDF::loadview('vista');
// return $pdf->download('contract.pdf');

// });

Route::get('form',function(){

return view('form');
});

Route::get('pdfweb',function(){

// $html = '<html>献给母亲的爱</html>';
// $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');


// $html = '<html><head><title>Laravel</title><meta http-equiv=\'Content-Type\' content=\'text/html; charset=utf-8\'/><style>body{  font-family: \'msyh\';  }  @font-face {  font-family: \'msyh\';  font-style: normal;  font-weight: normal;  src: url(http://www.testenv.com/fonts/msyh.ttf) format(\'truetype\');  }</style></head><body><div class=\'container\'><div class=\'content\'><p style=\'font-family: msyh, DejaVu Sans,sans-serif;\'>献给母亲的爱</p><div style=\'font-family: msyh, DejaVu Sans,sans-serif;\' class=\'title\'>Laravel 5中文测试</div><div  class=\'title\'>测试三</div></div></div></body></html>';
 //        $pdf = PDF::loadHTML($html);
 //        return $pdf->stream('contract.pdf');;

// $str ='大大';
// echo mb_strlen( $str , 'utf8' );

$pdf= PDF::loadview('vista');
return $pdf->stream('contract.pdf');
});

Route::get('submit','PDFController@getPDF');



