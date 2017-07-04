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
		// $file_name = '/3.pdf';
		// $a1 = helper::get_millistime();

		// //hardcoded for 3.pdf
		// $file_name= storage_path() . '/app/3.pdf';


		// $post_data = array(
		//     "subject" => "xushuaiRemote文件创建",//合同主题
		//     "expireTime" => "2017-07-08",//合同过期时间；过期未结束签署，则作废，不传该参数则默认30天后过期。
		//     "docName" => "languageRemote",//合同文件名称
		// 	//合同文件
		// 	"file" =>  new \CURLFile(realpath($file_name))

		// 	//
		// );
		// $result =  $remoteSignServiceImpl->createByLocal($post_data);
		// $a2 = helper::get_millistime();
		// $a3 = $a2-$a1;
		// print_r($result);
		// print_r("**************耗时：".$a3);
		// print_r("<br>");

		 

		//***********************************************************************2.1 运营方签署
		/* 
		 * 指定坐标位置签署
		 * --------------------------------------------------------------
		 * 平台签署,带签名外观
		 * --------------------------------------------------------------
		 */
	$templates = array(
            'offsetX'=>0.2,
            'offsetY'=>0.2,
            'page'=>1
        );
        $post_data = array(
            "documentId" => "2319431254681039842",//合同文件在契约锁的唯一标识
            "visible" => true,//带签名外观,visible:印章是否可见
            "sealId" => "2317930302195048503",//印章在契约锁的唯一标识
            "location" => json_encode($templates)//印章坐标位置；JSON字符串，如：{"offsetX":0.5,"offsetY":0.5,"page":1}；
        );

        $result =  $remoteSignServiceImpl->signByPlatform($post_data);
        print_r($result);
		//***********************************************************************2.3 个人用户签署
		/* 指定坐标位置签署
		 * --------------------------------------------------------------
		 * 个人用户签署,带签名外观
		 * --------------------------------------------------------------
		 */
		$templates = array(
			'offsetX'=>0.7,
		    'offsetY'=>0.2,
			'page'=>1
		);
		$person = array(
			'name'=>'丁武',//用户姓名
		    'mobile'=>'45782136589'//手机号
		);
		$post_data = array(
		    "documentId" => "2319431254681039842",
		    "visible" => true,
			"sealImageBase64" =>"iVBORw0KGgoAAAANSUhEUgAAALQAAABkCAYAAAAv8xodAAABh0lEQVR42u3dUW7CQAxF0ex/02EBgFDETGI/nyPxVxXVvkwAFXEcAAAAAAAAAAAAAAAAAAAAAAAAAMBO548b73OiSbzCvjYnGoQ7bYHmEhxs8vLMZGiwXRdoFmJtszwPZEGau5n1iNnVzfxav4NgKdfn/+1nWRz2yvvB7G4bmsUIGou59SrKgCuBgwBBCxpBi9mCLEfQgjYvMxO0eWFB5oUFmZcFWZBZWZJZYUnzZuWdEUG3n5X/pRZ06zn5gICg28/Jp4YELVxRC7pLsCvuF0E/EvWO+0XQW6NePSMxP7TcqX/77ge9mAUddQUTtKBjghazoAWNoKvORtCCjn/+jKAFjWFXeKCbsaCdznixImiLM3BPNwTtdPaiW9CCFrSgPd1A0E5nCzT4ikH7UICgS52on36fzyIKuuzp7ItRb1rMv5czQfuq6VYnzeRL2DngZnEhwzjdsg+k1GGIZ/BroNRHt9PNuxlxCxWuqCOXLFxRWz7ZUYOgoWLUEBM0AAAAAAAAAABQyAu58uZgb5mSegAAAABJRU5ErkJggg==",
		    "person" => json_encode($person),//个人用户信息；JSON字符串
			"location" => json_encode($templates)
		);
		$result =  $remoteSignServiceImpl->signByPerson($post_data);
		print_r($result);



//***********************************************************************6.2 获取查看合同页面的链接
        	$post_data = array(
		    "documentId" => "2319431254681039842"//String	合同文件在契约锁的唯一标识
		);
		$result =  $remoteSignServiceImpl->viewUrl($post_data);
		print_r($result);

	
    }//
}
