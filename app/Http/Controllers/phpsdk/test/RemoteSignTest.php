<?php

namespace App\Http\Controllers\phpsdk\test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\phpsdk\serviceIMPL\RemoteSignServiceImpl;
use App\Http\Controllers\phpsdk\common\Receiver;
use App\Http\Controllers\phpsdk\common\Helper as helper;
use App\Http\Controllers\phpsdk\common\SDKClient;
use App\Http\Controllers\phpsdk\common\Util;
use Illuminate\Support\Facades\Storage;


class RemoteSignTest extends Controller
{


		

	public function test() {
	
		//	require_once("../serviceIMPL/RemoteSignServiceImpl.php");
		//require_once("../common/Receiver.php");
	//	require_once("../common/Helper.php");
	//	require_once("../common/SDKClient.php");
	//	require_once "../common/Util.php";

		$url = Util::url;
		$accessKey = Util::accessKey;
		$accessSecret = Util::accessSecret;
		
		$SDk = new SDKClient($accessKey, $accessSecret, $url);
		$remoteSignServiceImpl = new RemoteSignServiceImpl($SDk);
		//***********************************************************************1.1 由本地PDF文件创建
	//	$file_name = '/3.pdf';
		$a1 = helper::get_millistime();

		//hardcoded for 3.pdf
		$file_name= storage_path() . '/app/3.pdf';


		$post_data = array(
		    "subject" => "xushuaiRemote文件创建",//合同主题
		    "expireTime" => "2017-07-08",//合同过期时间；过期未结束签署，则作废，不传该参数则默认30天后过期。
		    "docName" => "languageRemote",//合同文件名称
			//合同文件
			"file" =>  new \CURLFile(realpath($file_name))

			//
		);
		$result =  $remoteSignServiceImpl->createByLocal($post_data);
		$a2 = helper::get_millistime();
		$a3 = $a2-$a1;
		print_r($result);
		print_r("**************耗时：".$a3);
		 }





	
    //
}
