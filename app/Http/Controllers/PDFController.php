<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use PDF;
use View;
class PDFController extends Controller
{


	public function getPDF(Request $request) {
		// //check for correct request method
		// $method = $request->method();
		// if ($request->isMethod('POST')) {
		//     echo "please use GET method";
		//     return;
		// }
		
		//name1 and name2 are the landlord and renter
		$name1 =  $request->input('name1');
		$name2 =  $request->input('name2');
		
		//contractNumber should be generated and stored in DB
		//this is hardcoded for testing purpose
		$contractNumber = '3';
		// $contractNumber = $request->input('contractNumber');

		//accepting terms as an array as the number of terms is unknown.
		//this is hardcoded for testing
		$terms = $request->input('term');
		//$terms = array("(一）甲方保证上述房屋：已依法取得房屋所有权证书或相关产权证明文件；权属明晰，无产权争议；不在建设拆迁公告范围内；能保证安全居住、使用；有关法律、法规未限制出租。 其它：已取得其他共有人书面同意；已经抵押权人同意；如系托管的房屋，已经托管的房屋所有权人委托出租。 如甲方上述保证不实，由此给乙方造成的损失，由甲方负责赔偿。", "(二）甲方负责对房屋及其附属设施定期检查并承担正常的房屋维修费用。如因延期修缮致使乙方遭受损失，甲方负责赔偿。（本条双方另有约定的除外）。" , 3, 4);
		// $contractNumber = $request->input('terms');

		//buildung up the inital term with the two names
		$combinedterm='甲方（出租方）：'.$name1.'(以下简称甲方）<br>乙方（承租方）：'.$name2.'（以下简称乙方）';
	       

	    //looping over each term,  break line for each 40th character, break line for every new term.                   
		foreach ($terms as &$term) {
	   		 $term = $this->wordwrap_utf8($term,40);
	   		 $combinedterm=$combinedterm.'<br>'.$term;
	   	}
	  	//echo $combinedterm;

		//put combinedterms into view vista and export it as pdf
		$pdf = PDF::loadHTML(View::make('vista')->with('terms',$combinedterm));

		//prepare the filename using contractNumeber
		$filename = $contractNumber.'.pdf';

		//store the file 
		Storage::put($filename, $pdf->output());


		//check if file exist
		if ($exists = Storage::disk()->exists($filename)){
			return "success";
		}
		
	}

		//custom function for for utf-8 character newline
		//$str is the initial text string
		//$length is the length of word in each length
		//http://www.lorui.com/php-utf8-wordwrap.html
	public	function wordwrap_utf8($str, $length = 75, $break = '<br />') {
		    $len = mb_strlen($str,'utf-8');
		    if($len <= $length) return $str;
		    $temp = array();
		    $num = ceil($len/$length);  
		    for($i = 0; $i < $num; $i++) {
		        array_push($temp, 
		            mb_substr($str, $length*$i, $length, 'utf-8')
		        );      
		    }
		   return implode($break, $temp);
		}

	
	
};
